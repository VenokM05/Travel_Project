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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('itinerary_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('total_budget', 10, 2)->default(0);
            $table->decimal('total_spent', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->enum('type', ['solo', 'group'])->default('solo');
            $table->enum('status', ['active', 'completed', 'archived'])->default('active');
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
