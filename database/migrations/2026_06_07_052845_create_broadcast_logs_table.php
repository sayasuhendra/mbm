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
        Schema::create('broadcast_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('whatsapp_broadcast_id')->constrained()->cascadeOnDelete();
            $table->foreignId('archery_participant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('recipient_name');
            $table->string('recipient_whatsapp', 30);
            $table->string('status')->default('pending')->index();
            $table->text('response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['whatsapp_broadcast_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_logs');
    }
};
