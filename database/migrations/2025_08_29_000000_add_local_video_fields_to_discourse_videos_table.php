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
            $table->string('video_path')->nullable()->after('youtube_video_id');
            $table->string('video_filename')->nullable()->after('video_path');
            $table->string('thumbnail_path')->nullable()->after('video_filename');
            $table->string('mime_type')->nullable()->after('thumbnail_path');
            $table->bigInteger('file_size')->nullable()->after('mime_type');
            $table->boolean('is_processed')->default(false)->after('file_size');
            $table->string('youtube_video_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discourse_videos', function (Blueprint $table) {
            $table->dropColumn([
                'video_path',
                'video_filename',
                'thumbnail_path',
                'mime_type',
                'file_size',
                'is_processed'
            ]);
            $table->string('youtube_video_id')->nullable(false)->change();
        });
    }
};

