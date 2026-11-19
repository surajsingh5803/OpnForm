<?php

namespace App\Models\LpForms;

use Illuminate\Database\Eloquent\Model;

class WorkspaceAuditEvent extends Model
{
    protected $table = 'lp_forms_workspace_audit_events';

    public $timestamps = false;

    protected $fillable = [
        'workspace_id',
        'actor_user_id',
        'action',
        'subject_type',
        'subject_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'immutable_datetime'];
    }
}
