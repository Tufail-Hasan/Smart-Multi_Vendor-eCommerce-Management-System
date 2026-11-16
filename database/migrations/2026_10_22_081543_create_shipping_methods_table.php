<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();

            // Shipping method information
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->default('courier');

            // Delivery charges
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('free_shipping_minimum', 10, 2)->nullable();

            // Estimated delivery time
            $table->unsignedSmallInteger('estimated_min_days')->default(1);
            $table->unsignedSmallInteger('estimated_max_days')->default(3);

            // Service availability
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->json('available_areas')->nullable();

            // COD and status
            $table->boolean('supports_cod')->default(true);
            $table->boolean('is_active')->default(true);

            // Display order
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('is_active');
            $table->index('type');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
