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
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            // Basic Information
            $table->string('first_name');
            $table->string('last_name')->nullable();

            // Contact Information
            $table->string('email')->unique();
            $table->string('phone', 30)->nullable()->unique();

            // Authentication
            $table->string('password');

            // Profile
            $table->string('profile_photo')->nullable();
            $table->enum('gender', [
                'male',
                'female',
                'other'
            ])->nullable();

            $table->date('date_of_birth')->nullable();

            // Account Status
            $table->enum('status', [
                'active',
                'inactive',
                'blocked'
            ])->default('active');

            // Email Verification
            $table->timestamp('email_verified_at')->nullable();

            // Customer Statistics
            $table->unsignedInteger('total_orders')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);

            $table->timestamp('last_order_at')->nullable();

            // Admin Notes
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('phone');
            $table->index('last_order_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
