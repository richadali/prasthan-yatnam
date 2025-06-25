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
        Schema::table('users', function (Blueprint $table) {
            // Drop the name column
            $table->dropColumn('name');

            // Add new fields
            $table->string('first_name')->after('id');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->after('middle_name');
            $table->enum('gender', ['male', 'female', 'other'])->after('last_name');
            $table->enum('age_group', [
                'below_20',
                '20_to_32',
                '32_to_45',
                '45_to_60',
                '60_to_70',
                'above_70'
            ])->after('gender');
            $table->string('phone')->unique()->after('email');
            $table->string('country_code')->default('+91')->after('email');
            $table->string('organization')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the added columns
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'age_group',
                'country_code',
                'phone',
                'organization'
            ]);

            // Add back the name column
            $table->string('name')->after('id');
        });
    }
};
