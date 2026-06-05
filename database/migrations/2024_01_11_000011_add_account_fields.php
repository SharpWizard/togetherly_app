<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('total_ratings');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('account_type')->default('individual')->after('neighborhood'); // individual | business | restaurant
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('account_type');
        });
    }
};
