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
        // Drop user_video_progress if it exists
        if (Schema::hasTable('user_video_progress')) {
            Schema::dropIfExists('user_video_progress');
        }

        // Drop user_discourses if it exists
        if (Schema::hasTable('user_discourses')) {
            Schema::dropIfExists('user_discourses');
        }

        // Drop discourse_videos if it exists
        if (Schema::hasTable('discourse_videos')) {
            Schema::dropIfExists('discourse_videos');
        }

        // Drop discourses if it exists
        if (Schema::hasTable('discourses')) {
            Schema::dropIfExists('discourses');
        }
    }

    /**
     * Reverse the migrations.
     * Note: This is intentionally empty as we're rebuilding from scratch
     */
    public function down(): void
    {
        // No down migration as we're rebuilding from scratch
    }
};
