<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['complete_quiz', 'perfect_score', 'streak', 'category_master']);
            $table->integer('target_count')->default(1); // Jumlah yang harus dicapai
            $table->integer('xp_reward');
            $table->date('date'); // Tanggal challenge aktif
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('daily_challenge_id')->constrained()->onDelete('cascade');
            $table->integer('progress')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_challenges');
        Schema::dropIfExists('daily_challenges');
    }
};