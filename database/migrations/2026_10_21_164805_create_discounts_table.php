<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->nullable()->unique();
            $table->text('description')->nullable();

            // Discount Type
            $table->enum('discount_type', [
                'percentage',
                'fixed',
            ])->default('percentage');

            $table->decimal('discount_value', 12, 2);

            // Optional discount limit
            $table->decimal('maximum_discount', 12, 2)
                ->nullable();

            // Applicable Scope
            $table->enum('applies_to', [
                'all_products',
                'specific_products',
                'specific_categories',
                'specific_brands',
                'specific_vendors',
            ])->default('all_products');

            // Optional related records
            $table->json('product_ids')->nullable();
            $table->json('category_ids')->nullable();
            $table->json('brand_ids')->nullable();
            $table->json('vendor_ids')->nullable();

            // Campaign Period
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            // Campaign Priority
            $table->unsignedInteger('priority')->default(0);

            // Discount Status
            $table->boolean('is_active')->default(true);

            // Discount Stacking
            $table->boolean('is_combinable')->default(false);

            // Admin Information
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('admin_note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'starts_at', 'ends_at']);
            $table->index(['applies_to', 'is_active']);
            $table->index('discount_type');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
