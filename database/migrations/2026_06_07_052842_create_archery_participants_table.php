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
        Schema::create('archery_participants', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique();
            $table->string('parent_name');
            $table->string('parent_whatsapp', 30);
            $table->text('parent_address');
            $table->string('child_name');
            $table->unsignedTinyInteger('child_age');
            $table->string('child_school_class');
            $table->boolean('training_permission')->default(true);
            $table->unsignedInteger('weekly_donation_amount')->default(5000);
            $table->string('equipment_option');
            $table->text('suggestion')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamp('registered_at')->nullable()->index();
            $table->timestamps();

            $table->index(['status', 'registered_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archery_participants');
    }
};
