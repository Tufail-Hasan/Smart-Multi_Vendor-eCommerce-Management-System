<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Order Relationship
            $table->foreignId('order_id')
                ->constrained('orders')
                ->restrictOnDelete();

            // Payment Information
            $table->string('payment_number')->unique();

            $table->decimal('amount', 12, 2);

            $table->string('currency', 3)->default('BDT');

            // Payment Method
            $table->enum('payment_method', [
                'cash_on_delivery',
                'bkash',
                'nagad',
                'rocket',
                'bank_transfer',
                'card',
                'paypal',
                'other',
            ]);

            // Payment Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded',
                'partially_refunded',
            ])->default('pending');

            // Gateway Information
            $table->string('transaction_id')->nullable();

            $table->string('gateway_name')->nullable();

            $table->string('gateway_reference')->nullable();

            // Additional Payment Details
            $table->text('description')->nullable();

            $table->text('failure_reason')->nullable();

            $table->json('gateway_response')->nullable();

            // Refund Information
            $table->decimal('refunded_amount', 12, 2)->default(0);

            $table->timestamp('paid_at')->nullable();

            $table->timestamp('failed_at')->nullable();

            $table->timestamp('refunded_at')->nullable();

            // Admin/User who manages the payment
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'status']);

            $table->index('payment_method');

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
