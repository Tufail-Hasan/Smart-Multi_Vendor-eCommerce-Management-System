<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Order Information
            $table->string('order_number')->unique();

            // Customer Relationship
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();

            // Order Amounts
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('shipping_charge', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            // Payment Information
            $table->string('payment_method')->nullable();

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded',
                'partially_refunded',
            ])->default('pending');

            $table->string('transaction_id')->nullable();

            // Order Status
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'returned',
            ])->default('pending');

            // Shipping Information
            $table->string('shipping_name');
            $table->string('shipping_phone', 20);
            $table->string('shipping_email')->nullable();

            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->string('shipping_country')->default('Bangladesh');

            // Billing Information
            $table->string('billing_name')->nullable();
            $table->string('billing_phone', 20)->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();

            // Additional Information
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();

            // Order Dates
            $table->timestamp('placed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('payment_status');
            $table->index('placed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
