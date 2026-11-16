<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();

            // Zone information
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // Bangladesh location information
            $table->string('country')->default('Bangladesh');
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->json('areas')->nullable();

            // Shipping charges
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('free_shipping_minimum', 10, 2)->nullable();

            // Estimated delivery time
            $table->unsignedSmallInteger('estimated_min_days')->default(1);
            $table->unsignedSmallInteger('estimated_max_days')->default(3);

            // Zone status
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['division', 'district']);
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_zones');
    }
};
