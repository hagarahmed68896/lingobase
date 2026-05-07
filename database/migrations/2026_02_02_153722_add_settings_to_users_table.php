<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('language')->default('en')->after('email');
            $table->boolean('in_app_notifications')->default(true)->after('language');
            $table->boolean('email_notifications')->default(true)->after('in_app_notifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['language', 'in_app_notifications', 'email_notifications']);
        });
    }
};
