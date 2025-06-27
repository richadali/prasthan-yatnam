<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Make last_watched_at column nullable and update existing records
     */
    public function up(): void
    {
        Schema::table('user_video_progress', function (Blueprint $table) {
            $table->timestamp('last_watched_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_video_progress', function (Blueprint $table) {
            $table->timestamp('last_watched_at')->nullable(false)->change();
        });
    }
};
