<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lp_forms_workspace_audit_events', function (Blueprint $table) {
            $table->id();
            // Historical events survive workspace/user deletion for a later
            // documented retention policy; deliberately no cascading FKs.
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('actor_user_id')->nullable();
            $table->string('action', 80);
            $table->string('subject_type', 32);
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->timestampTz('created_at')->useCurrent();
            $table->index(['workspace_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lp_forms_workspace_audit_events');
    }
};
