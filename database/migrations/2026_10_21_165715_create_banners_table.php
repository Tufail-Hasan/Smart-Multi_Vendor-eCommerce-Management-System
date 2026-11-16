<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();

            // Banner Content
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('mobile_image')->nullable();

            // Button Information
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // Display Settings
            $table->string('position')->default('home');
            $table->unsignedInteger('sort_order')->default(0);

            // Schedule
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('alt_text')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('is_active');
            $table->index('position');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
