<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('food_post_id')->nullable()->constrained('food_posts')->onDelete('cascade');
            $table->foreignId('skill_post_id')->nullable()->constrained('skill_posts')->onDelete('cascade');
            $table->string('reason');
            $table->text('details')->nullable();
            $table->enum('status', ['open', 'dismissed', 'actioned'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
