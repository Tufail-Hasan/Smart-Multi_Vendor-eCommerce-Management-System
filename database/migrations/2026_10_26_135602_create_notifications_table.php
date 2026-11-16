<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Notification recipient
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Notification information
            $table->string('title');
            $table->text('message');

            $table->string('type')->default('info');
            $table->string('category')->default('general');

            // Optional link to a related record or page
            $table->string('action_url')->nullable();

            // Read status
            $table->timestamp('read_at')->nullable();

            // Additional notification information
            $table->json('data')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'read_at']);
            $table->index(['category', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
