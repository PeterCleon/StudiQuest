<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_challenges', function (Blueprint $table) {
            $table->boolean('is_auto_generated')->default(false);
            $table->boolean('is_daily_pool')->default(true); // Masuk pool harian
            $table->integer('weight')->default(1); // Bobot kemunculan
        });
    }

    public function down(): void
    {
        Schema::table('daily_challenges', function (Blueprint $table) {
            $table->dropColumn(['is_auto_generated', 'is_daily_pool', 'weight']);
        });
    }
};