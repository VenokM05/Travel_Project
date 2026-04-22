<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add missing performance indexes to optimize common queries
     * Note: Many indexes already exist in original migrations
     */
    public function up(): void
    {
        // Itineraries - add missing indexes
        Schema::table('itineraries', function (Blueprint $table) {
            $table->index('status'); // Filter by status (missing)
            $table->index('destination'); // Destination search (missing)
        });

        // Todos - add missing indexes
        Schema::table('todos', function (Blueprint $table) {
            $table->index('priority'); // Filter by priority (missing)
            $table->index('due_date'); // Sort by due date (missing)
        });

        // Memories - add missing index
        Schema::table('memories', function (Blueprint $table) {
            $table->index('itinerary_id'); // Memories for itinerary (missing)
        });

        // Comments - add missing index
        Schema::table('comments', function (Blueprint $table) {
            $table->index('user_id'); // User's comments (missing)
        });

        // Stories - add missing index
        Schema::table('stories', function (Blueprint $table) {
            $table->index('expires_at'); // Expired stories cleanup (missing)
        });

        // Travel groups - add missing index
        Schema::table('travel_groups', function (Blueprint $table) {
            $table->index('created_by'); // User's groups (missing)
        });

        // Budgets - add missing single-column indexes
        Schema::table('budgets', function (Blueprint $table) {
            $table->index('itinerary_id'); // Budgets for itinerary (missing)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['destination']);
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->dropIndex(['priority']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('memories', function (Blueprint $table) {
            $table->dropIndex(['itinerary_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('stories', function (Blueprint $table) {
            $table->dropIndex(['expires_at']);
        });

        Schema::table('travel_groups', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropIndex(['itinerary_id']);
        });
    }
};
