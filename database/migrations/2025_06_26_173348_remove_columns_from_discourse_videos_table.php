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
            $table->dropColumn(['description', 'is_free_preview', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discourse_videos', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->boolean('is_free_preview')->default(false)->after('sequence');
            $table->boolean('is_active')->default(true)->after('is_free_preview');
        });
    }
};
