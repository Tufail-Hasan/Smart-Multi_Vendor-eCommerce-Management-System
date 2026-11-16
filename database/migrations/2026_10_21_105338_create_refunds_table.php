<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();

            // Related Order
            $table->foreignId('order_id')
                ->constrained('orders')
                ->restrictOnDelete();

            // Related Payment
            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete();

            // Customer Information
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            // Refund Information
            $table->string('refund_number')->unique();

            $table->decimal('refund_amount', 12, 2);

            $table->string('currency', 3)->default('BDT');

            $table->enum('refund_type', [
                'full',
                'partial',
            ])->default('full');

            // Refund Reason
            $table->string('reason');

            $table->text('description')->nullable();

            // Refund Method
            $table->enum('refund_method', [
                'original_payment',
                'bkash',
                'nagad',
                'rocket',
                'bank_transfer',
                'cash',
                'other',
            ])->default('original_payment');

            $table->string('refund_account')->nullable();

            $table->string('transaction_id')
                ->nullable()
                ->index();

            $table->string('gateway_reference')->nullable();

            // Refund Status
            $table->enum('status', [
                'pending',
                'approved',
                'processing',
                'completed',
                'failed',
                'rejected',
                'cancelled',
            ])->default('pending');

            // Refund Processing
            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('admin_note')->nullable();

            $table->text('failure_reason')->nullable();

            // Important Dates
            $table->timestamp('requested_at')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('processed_at')->nullable();

            $table->timestamp('completed_at')->nullable();

            // Additional Gateway Information
            $table->json('gateway_response')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'status']);

            $table->index(['customer_id', 'status']);

            $table->index(['payment_id', 'status']);

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
