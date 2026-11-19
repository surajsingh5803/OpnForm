<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('lp_product_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160);
            $table->text('details');
            $table->string('category', 32)->default('feature');
            $table->string('status', 32)->default('review');
            $table->string('contact_email', 255)->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lp_product_feedback');
    }
};
