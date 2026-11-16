<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            // Discount Information
            $table->enum('discount_type', [
                'percentage',
                'fixed',
            ])->default('percentage');

            $table->decimal('discount_value', 12, 2);

            $table->decimal('maximum_discount', 12, 2)
                ->nullable();

            $table->decimal('minimum_order_amount', 12, 2)
                ->default(0);

            // Usage Limits
            $table->unsignedInteger('usage_limit')
                ->nullable();

            $table->unsignedInteger('usage_limit_per_customer')
                ->nullable();

            $table->unsignedInteger('used_count')
                ->default(0);

            // Applicable Scope
            $table->enum('applies_to', [
                'all',
                'specific_products',
                'specific_categories',
                'specific_vendors',
            ])->default('all');

            // Related Records
            $table->json('product_ids')->nullable();
            $table->json('category_ids')->nullable();
            $table->json('vendor_ids')->nullable();

            // Validity Period
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // Currency
            $table->string('currency', 3)->default('BDT');

            // Admin who created the coupon
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Additional Notes
            $table->text('admin_note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'starts_at', 'expires_at']);
            $table->index('discount_type');
            $table->index('applies_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
