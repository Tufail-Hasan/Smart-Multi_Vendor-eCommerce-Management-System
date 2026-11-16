<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Setting identification
            $table->string('key')->unique();
            $table->string('group')->default('general');
            $table->string('label');

            // Setting value and input type
            $table->longText('value')->nullable();
            $table->string('type')->default('text');

            // Additional information
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_sensitive')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            // Indexes
            $table->index('group');
            $table->index(['group', 'is_active']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
