<?php

namespace App\Service\LpForms;

use App\Models\LpForms\WorkspaceAuditEvent;
use App\Models\User;
use App\Models\Workspace;
use App\Service\License\LicenseService;

class WorkspaceAuditTrail
{
    /**
     * This prototype never unlocks a vendor-gated production feature.
     * The independent implementation is available for local evaluation;
     * production access requires an existing valid entitlement AND opt-in.
     */
    public function enabled(): bool
    {
        if (! (bool) config('lpforms.audit_enabled', false)) {
            return false;
        }

        if (app()->environment(['local', 'testing'])) {
            return true;
        }

        return app(LicenseService::class)->checkLicense()->isActive();
    }

    /**
     * Store identifiers and the event kind only: never form answers,
     * invitation tokens, email addresses, passwords, or request payloads.
     */
    public function record(
        Workspace $workspace,
        ?User $actor,
        string $action,
        string $subjectType,
        ?int $subjectId = null
    ): void {
        if (! $this->enabled()) {
            return;
        }

        WorkspaceAuditEvent::query()->create([
            'workspace_id' => $workspace->getKey(),
            'actor_user_id' => $actor?->getKey(),
            'action' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'created_at' => now(),
        ]);
    }
}
