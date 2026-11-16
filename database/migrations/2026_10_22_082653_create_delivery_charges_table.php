<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id();

            // Shipping zone and method
            $table->foreignId('shipping_zone_id')
                ->constrained('shipping_zones')
                ->cascadeOnDelete();

            $table->foreignId('shipping_method_id')
                ->constrained('shipping_methods')
                ->cascadeOnDelete();

            // Charge information
            $table->string('name');
            $table->string('code')->unique();
            $table->string('delivery_type')->default('standard');

            $table->decimal('charge', 10, 2)->default(0);
            $table->decimal('additional_charge', 10, 2)->default(0);
            $table->decimal('free_shipping_minimum', 10, 2)->nullable();

            // Optional weight-based charges
            $table->decimal('included_weight', 8, 2)->nullable();
            $table->decimal('additional_weight_charge', 10, 2)->default(0);

            // Estimated delivery time
            $table->unsignedSmallInteger('estimated_min_days')->default(1);
            $table->unsignedSmallInteger('estimated_max_days')->default(3);

            // Charge settings
            $table->string('currency', 3)->default('BDT');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['shipping_zone_id', 'is_active']);
            $table->index(['shipping_method_id', 'is_active']);
            $table->index('delivery_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
