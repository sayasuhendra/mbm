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
        Schema::table('archery_participants', function (Blueprint $table) {
            $table->decimal('equipment_contribution_amount', 12, 2)->nullable()->after('equipment_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archery_participants', function (Blueprint $table) {
            $table->dropColumn('equipment_contribution_amount');
        });
    }
};
