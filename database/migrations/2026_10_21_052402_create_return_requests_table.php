<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();

            // Order Relationship
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Customer and Product Information
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Return Information
            $table->string('return_number')->unique();

            $table->unsignedInteger('quantity')->default(1);

            $table->string('reason');

            $table->text('description')->nullable();

            // Return Request Status
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'item_shipped',
                'item_received',
                'inspecting',
                'completed',
                'cancelled',
            ])->default('pending');

            // Returned Product Condition
            $table->enum('item_condition', [
                'unopened',
                'unused',
                'used',
                'damaged',
                'defective',
            ])->nullable();

            // Refund Information
            $table->decimal('refund_amount', 12, 2)->default(0);

            $table->enum('refund_status', [
                'pending',
                'approved',
                'processing',
                'completed',
                'rejected',
            ])->default('pending');

            $table->string('refund_method')->nullable();

            $table->string('refund_transaction_id')->nullable();

            // Return Shipping Information
            $table->string('return_tracking_number')->nullable();

            $table->decimal('return_shipping_cost', 12, 2)->default(0);

            // Admin Review
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('admin_note')->nullable();

            $table->text('rejection_reason')->nullable();

            // Important Dates
            $table->timestamp('requested_at')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('received_at')->nullable();

            $table->timestamp('refunded_at')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'status']);
            $table->index(['customer_id', 'status']);
            $table->index('refund_status');
            $table->index('requested_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
