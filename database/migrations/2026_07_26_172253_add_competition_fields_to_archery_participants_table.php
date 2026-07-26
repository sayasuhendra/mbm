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
            $table->string('rt', 20)->nullable()->after('parent_address');
            $table->string('competition_category')->nullable()->after('child_school_class');
            $table->string('event_name')->nullable()->after('competition_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archery_participants', function (Blueprint $table) {
            $table->dropColumn(['rt', 'competition_category', 'event_name']);
        });
    }
};
