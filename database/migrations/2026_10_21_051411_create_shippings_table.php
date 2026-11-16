<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();

            // Order Relationship
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // Shipping Information
            $table->string('shipping_number')->unique();

            $table->string('courier_name')->nullable();

            $table->string('tracking_number')->nullable()->index();

            $table->string('shipping_method')->nullable();

            // Shipping Cost
            $table->decimal('shipping_cost', 12, 2)->default(0);

            // Shipping Status
            $table->enum('status', [
                'pending',
                'ready_to_ship',
                'shipped',
                'in_transit',
                'out_for_delivery',
                'delivered',
                'failed',
                'returned',
                'cancelled',
            ])->default('pending');

            // Delivery Address
            $table->string('recipient_name');

            $table->string('recipient_phone', 20);

            $table->string('recipient_email')->nullable();

            $table->string('address');

            $table->string('city');

            $table->string('state')->nullable();

            $table->string('postal_code', 20)->nullable();

            $table->string('country')->default('Bangladesh');

            // Shipping Dates
            $table->timestamp('shipped_at')->nullable();

            $table->timestamp('estimated_delivery_at')->nullable();

            $table->timestamp('delivered_at')->nullable();

            // Additional Information
            $table->text('notes')->nullable();

            // Admin/User who manages shipping
            $table->foreignId('managed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index('estimated_delivery_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
