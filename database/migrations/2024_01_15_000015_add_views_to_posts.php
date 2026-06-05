<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_posts', function (Blueprint $table) {
            $table->unsignedInteger('views')->default(0)->after('status');
        });
        Schema::table('skill_posts', function (Blueprint $table) {
            $table->unsignedInteger('views')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('food_posts', function (Blueprint $table) {
            $table->dropColumn('views');
        });
        Schema::table('skill_posts', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
