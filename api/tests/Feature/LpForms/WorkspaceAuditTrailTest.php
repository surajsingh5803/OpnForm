<?php

use App\Models\LpForms\WorkspaceAuditEvent;
use App\Models\User;
use App\Service\LpForms\WorkspaceAuditTrail;

it('records workspace changes and exposes them to the workspace administrator', function () {
    config(['lpforms.audit_enabled' => true]);

    $owner = $this->actingAsUser();
    $workspace = $this->createUserWorkspace($owner);

    $this->putJson(route('open.workspaces.update', $workspace), [
        'name' => 'Renamed Workspace',
    ])->assertSuccessful();

    $this->assertDatabaseHas('lp_forms_workspace_audit_events', [
        'workspace_id' => $workspace->id,
        'actor_user_id' => $owner->id,
        'action' => 'workspace.updated',
        'subject_type' => 'workspace',
        'subject_id' => $workspace->id,
    ]);

    $this->getJson(route('open.workspaces.audit-events.index', $workspace))
        ->assertSuccessful()
        ->assertJsonPath('data.0.action', 'workspace.updated');
});

it('keeps audit history scoped to administrators of the requested workspace', function () {
    config(['lpforms.audit_enabled' => true]);

    $owner = $this->actingAsUser();
    $workspace = $this->createUserWorkspace($owner);
    app(WorkspaceAuditTrail::class)->record($workspace, $owner, 'workspace.updated', 'workspace', $workspace->id);

    $stranger = User::factory()->create();
    $this->actingAs($stranger);
    $this->getJson(route('open.workspaces.audit-events.index', $workspace))->assertForbidden();
});

it('leaves audit capture and the read API disabled by default', function () {
    config(['lpforms.audit_enabled' => false]);

    $owner = $this->actingAsUser();
    $workspace = $this->createUserWorkspace($owner);
    app(WorkspaceAuditTrail::class)->record($workspace, $owner, 'workspace.updated', 'workspace', $workspace->id);

    expect(WorkspaceAuditEvent::count())->toBe(0);
    $this->getJson(route('open.workspaces.audit-events.index', $workspace))->assertNotFound();
});

it('paginates activity without leaking form answers or invitation secrets', function () {
    config(['lpforms.audit_enabled' => true]);

    $owner = $this->actingAsUser();
    $workspace = $this->createUserWorkspace($owner);
    app(WorkspaceAuditTrail::class)->record($workspace, $owner, 'form.created', 'form', 1001);
    app(WorkspaceAuditTrail::class)->record($workspace, $owner, 'form.updated', 'form', 1001);

    $response = $this->getJson(route('open.workspaces.audit-events.index', $workspace).'?per_page=1')
        ->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.action', 'form.updated');

    expect($response->getContent())->not->toContain('token', 'password', 'submission_data');
});
