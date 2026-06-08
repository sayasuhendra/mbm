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
        Schema::create('weekly_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('archery_participant_id')->constrained()->cascadeOnDelete();
            $table->date('week_start_date')->index();
            $table->unsignedInteger('amount');
            $table->string('status')->default('unpaid')->index();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['archery_participant_id', 'week_start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_donations');
    }
};
