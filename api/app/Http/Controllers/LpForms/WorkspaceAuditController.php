<?php

namespace App\Http\Controllers\LpForms;

use App\Http\Controllers\Controller;
use App\Models\LpForms\WorkspaceAuditEvent;
use App\Models\Workspace;
use App\Service\LpForms\WorkspaceAuditTrail;
use Illuminate\Http\Request;

class WorkspaceAuditController extends Controller
{
    public function __invoke(Request $request, Workspace $workspace, WorkspaceAuditTrail $audit)
    {
        $this->authorize('adminAction', $workspace);
        abort_unless($audit->enabled(), 404);

        $perPage = min(max($request->integer('per_page', 25), 1), 100);

        return WorkspaceAuditEvent::query()
            ->select(['id', 'workspace_id', 'actor_user_id', 'action', 'subject_type', 'subject_id', 'created_at'])
            ->where('workspace_id', $workspace->id)
            ->orderByDesc('id')
            ->paginate($perPage);
    }
}
