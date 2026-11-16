<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Order Relationship
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Product Relationship
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            // Vendor Relationship
            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->restrictOnDelete();

            // Product Information at Purchase Time
            $table->string('product_name');
            $table->string('product_sku')->nullable();

            // Order Item Details
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            // Vendor Commission
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->decimal('commission_amount', 12, 2)->default(0);
            $table->decimal('vendor_earning', 12, 2)->default(0);

            // Item Status
            $table->enum('status', [
                'pending',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
                'refunded',
            ])->default('pending');

            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index(['vendor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
