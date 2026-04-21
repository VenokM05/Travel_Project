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
            $table->boolean('notification_email')->default(true)->after('storage_used');
            $table->boolean('notification_push')->default(false)->after('notification_email');
            $table->enum('profile_privacy', ['public', 'private'])->default('public')->after('notification_push');
            $table->enum('default_post_privacy', ['public', 'followers', 'private'])->default('public')->after('profile_privacy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notification_email', 'notification_push', 'profile_privacy', 'default_post_privacy']);
        });
    }
};
