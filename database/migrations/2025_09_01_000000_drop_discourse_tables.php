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
        // Drop tables in reverse order of creation
        Schema::dropIfExists('user_discourses');
        Schema::dropIfExists('discourse_videos');
        Schema::dropIfExists('discourses');

        // Create discourses table
        Schema::create('discourses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_upcoming')->default(false);
            $table->date('expected_release_date')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Create discourse_videos table
        Schema::create('discourse_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discourse_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('video_path')->nullable();
            $table->string('video_filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->integer('sequence')->default(0);
            $table->integer('duration_seconds')->nullable();
            $table->timestamps();
        });

        // Create user_discourses table
        Schema::create('user_discourses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discourse_id')->constrained()->onDelete('cascade');
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->timestamps();

            // Ensure a user can only enroll once in a discourse
            $table->unique(['user_id', 'discourse_id']);
        });
    }

    /**
     * Reverse the migrations.
     * Note: This is intentionally empty as we're rebuilding from scratch
     */
    public function down(): void
    {
        Schema::dropIfExists('user_discourses');
        Schema::dropIfExists('discourse_videos');
        Schema::dropIfExists('discourses');
    }
};
