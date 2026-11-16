<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Transaction Number
            $table->string('transaction_number')->unique();

            // Related Payment
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete();

            // Related Order
            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            // Vendor Relationship
            $table->foreignId('vendor_id')
                ->nullable()
                ->constrained('vendors')
                ->nullOnDelete();

            // Transaction Type
            $table->enum('type', [
                'payment',
                'refund',
                'payout',
                'commission',
                'adjustment',
            ]);

            // Transaction Information
            $table->decimal('amount', 12, 2);

            $table->string('currency', 3)->default('BDT');

            $table->string('payment_method')->nullable();

            $table->string('gateway_name')->nullable();

            // External Transaction References
            $table->string('gateway_transaction_id')
                ->nullable()
                ->index();

            $table->string('reference_number')->nullable();

            // Transaction Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'reversed',
            ])->default('pending');

            // Additional Details
            $table->text('description')->nullable();

            $table->text('failure_reason')->nullable();

            $table->json('gateway_response')->nullable();

            // Processing Information
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['type', 'status']);

            $table->index(['order_id', 'type']);

            $table->index(['vendor_id', 'type']);

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
