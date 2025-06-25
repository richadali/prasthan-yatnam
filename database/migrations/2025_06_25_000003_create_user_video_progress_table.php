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
        Schema::create('user_video_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discourse_video_id')->constrained()->onDelete('cascade');
            $table->integer('current_position_seconds')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamp('last_watched_at');
            $table->timestamps();

            // Unique constraint to prevent duplicate progress records
            $table->unique(['user_id', 'discourse_video_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_video_progress');
    }
};
