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
        Schema::create('discourse_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discourse_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_video_id');
            $table->integer('sequence')->default(0);
            $table->boolean('is_free_preview')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('duration_seconds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discourse_videos');
    }
};
