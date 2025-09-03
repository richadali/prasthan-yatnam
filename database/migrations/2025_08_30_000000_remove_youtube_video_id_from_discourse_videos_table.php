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
        Schema::table('discourse_videos', function (Blueprint $table) {
            $table->dropColumn('youtube_video_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discourse_videos', function (Blueprint $table) {
            $table->string('youtube_video_id')->nullable()->after('title');
        });
    }
};

