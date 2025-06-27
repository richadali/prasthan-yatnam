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
        Schema::table('discourses', function (Blueprint $table) {
            $table->boolean('is_upcoming')->default(false)->after('is_active');
            $table->date('expected_release_date')->nullable()->after('is_upcoming');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discourses', function (Blueprint $table) {
            $table->dropColumn('is_upcoming');
            $table->dropColumn('expected_release_date');
        });
    }
};
