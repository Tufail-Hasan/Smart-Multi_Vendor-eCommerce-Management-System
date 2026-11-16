<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();

            // Payment Method Information
            $table->string('name');

            $table->string('code')->unique();

            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->string('logo')->nullable();

            // Payment Method Type
            $table->enum('type', [
                'manual',
                'gateway',
            ])->default('gateway');

            // Supported Payment Methods
            $table->enum('method_type', [
                'cash_on_delivery',
                'mobile_banking',
                'bank_transfer',
                'card',
                'digital_wallet',
                'other',
            ])->default('other');

            // Gateway Configuration
            $table->string('gateway_name')->nullable();

            $table->json('configuration')->nullable();

            // Transaction Fees
            $table->decimal('fixed_fee', 12, 2)->default(0);

            $table->decimal('percentage_fee', 5, 2)->default(0);

            // Payment Limits
            $table->decimal('minimum_amount', 12, 2)
                ->default(0);

            $table->decimal('maximum_amount', 12, 2)
                ->nullable();

            // Currency
            $table->string('currency', 3)->default('BDT');

            // Availability
            $table->boolean('is_active')->default(true);

            $table->boolean('is_test_mode')->default(false);

            $table->boolean('supports_refund')->default(false);

            // Display Order
            $table->unsignedInteger('sort_order')->default(0);

            // Admin/User Information
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'sort_order']);

            $table->index('method_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
