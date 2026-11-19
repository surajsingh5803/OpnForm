<?php

namespace App\Http\Controllers;

use App\Jobs\Billing\WorkspaceUsersUpdated;
use App\Models\UserInvite;
use App\Traits\EnsureUserHasWorkspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Workspace;
use App\Models\User;
use App\Service\License\SelfHostedSeatLimitService;
use App\Service\WorkspaceHelper;

class WorkspaceUserController extends Controller
{
    use EnsureUserHasWorkspace;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listUsers(Request $request, Workspace $workspace)
    {
        $this->authorize('view', $workspace);

        return (new WorkspaceHelper($workspace))->getAllUsers();
    }

    public function addUser(Request $request, Workspace $workspace)
    {
        $this->authorize('inviteUser', $workspace);

        $this->validate($request, [
            'email' => 'required|email',
            'role' => 'required|in:' . implode(',', User::ROLES),
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->inviteUser($workspace, $request->email, $request->role);
        }

        if ($workspace->users->contains($user->id)) {
            return $this->success([
                'message' => 'User is already in workspace.'
            ]);
        }

        // User found - add user to workspace
        $workspace->users()->sync([
            $user->id => [
                'role' => $request->role,
            ],
        ], false);
        $workspace->flushWithOwners();
        $user->flush();
        WorkspaceUsersUpdated::dispatch($workspace);
        app(\App\Service\LpForms\WorkspaceAuditTrail::class)
            ->record($workspace, $request->user(), 'member.added', 'user', $user->id);

        return $this->success([
            'message' => 'User has been successfully added to workspace.'
        ]);
    }

    private function inviteUser(Workspace $workspace, string $email, string $role)
    {
        $workspace->requireFeature('invite_user');

        if (
            UserInvite::where('email', $email)
            ->where('workspace_id', $workspace->id)
            ->notExpired()
            ->pending()
            ->exists()
        ) {
            return $this->error([
                'message' => 'User has already been invited.'
            ]);
        }

        app(SelfHostedSeatLimitService::class)->assertCanInviteEmail($email);

        // Send new invite
        $invite = UserInvite::inviteUser($email, $role, $workspace, now()->addDays(7));
        app(\App\Service\LpForms\WorkspaceAuditTrail::class)
            ->record($workspace, auth()->user(), 'invite.created', 'invite', $invite->id);

        return $this->success([
            'message' => 'Registration invitation email sent to user.',
            'invite' => $invite
        ]);
    }

    public function updateUserRole(Request $request, Workspace $workspace, User $user)
    {
        $this->authorize('adminAction', $workspace);
        if (!$workspace->users()->whereKey($user->id)->exists()) {
            abort(404);
        }

        $this->validate($request, [
            'role' => 'required|in:' . implode(',', User::ROLES),
        ]);

        $this->mutateMembership($workspace, $user, $request->role, function () use ($workspace, $user, $request) {
            $workspace->users()->sync([
                $user->id => [
                    'role' => $request->role,
                ],
            ], false);
        });
        $workspace->flushWithOwners();
        $user->flush();
        app(\App\Service\LpForms\WorkspaceAuditTrail::class)
            ->record($workspace, $request->user(), 'member.role_updated', 'user', $user->id);

        return $this->success([
            'message' => 'User role changed successfully.'
        ]);
    }

    public function removeUser(Request $request, Workspace $workspace, User $user)
    {
        $this->authorize('adminAction', $workspace);
        if (!$workspace->users()->whereKey($user->id)->exists()) {
            abort(404);
        }

        $this->mutateMembership($workspace, $user, null, fn () => $workspace->users()->detach($user->id));
        $workspace->flushWithOwners();
        $user->flush();
        $this->ensureUserHasWorkspace($user);
        WorkspaceUsersUpdated::dispatch($workspace);
        app(\App\Service\LpForms\WorkspaceAuditTrail::class)
            ->record($workspace, $request->user(), 'member.removed', 'user', $user->id);

        return $this->success([
            'message' => 'User removed from workspace successfully.'
        ]);
    }

    public function leaveWorkspace(Request $request, Workspace $workspace)
    {
        $this->authorize('view', $workspace);

        $user = $request->user();
        $this->mutateMembership($workspace, $user, null, fn () => $workspace->users()->detach($user->id));
        $workspace->flushWithOwners();
        $user->flush();
        $this->ensureUserHasWorkspace($user);
        app(\App\Service\LpForms\WorkspaceAuditTrail::class)
            ->record($workspace, $user, 'member.left', 'user', $user->id);

        return $this->success([
            'message' => 'You have left the workspace successfully.'
        ]);
    }
    private function mutateMembership(Workspace $workspace, User $user, ?string $role, callable $mutation): void
    {
        DB::transaction(function () use ($workspace, $user, $role, $mutation) {
            Workspace::whereKey($workspace->id)->lockForUpdate()->firstOrFail();
            $isAdmin = $workspace->users()->whereKey($user->id)->wherePivot('role', User::ROLE_ADMIN)->exists();
            if ($isAdmin && $role !== User::ROLE_ADMIN) {
                abort_if(
                    $workspace->users()->wherePivot('role', User::ROLE_ADMIN)->count() <= 1,
                    422,
                    'Assign another workspace administrator before removing the last administrator.'
                );
            }
            $mutation();
        });
    }

}
