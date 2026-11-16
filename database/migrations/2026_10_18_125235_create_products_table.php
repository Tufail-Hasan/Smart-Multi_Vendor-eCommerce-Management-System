<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        if (Schema::hasTable('products')) {
            return;
        }
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            // Product belongs to a Vendor
            $table->foreignId('vendor_id')
                ->constrained('vendors')
                ->restrictOnDelete();

            // Product belongs to a Category
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            // Product belongs to a Brand
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Basic Product Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->unique();

            $table->string('short_description', 500)
                ->nullable();

            $table->longText('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('price', 12, 2);

            $table->decimal('discount_price', 12, 2)
                ->nullable();

            $table->decimal('cost_price', 12, 2)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('stock')
                ->default(0);

            $table->unsignedInteger('low_stock_threshold')
                ->default(5);

            $table->decimal('weight', 10, 2)
                ->nullable();

            $table->string('weight_unit', 10)
                ->default('kg');


            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            */

            $table->string('thumbnail')
                ->nullable();

            // JSON array of additional image paths
            $table->json('gallery')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Product Attributes
            |--------------------------------------------------------------------------
            */

            $table->string('color')
                ->nullable();

            $table->string('size')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Product Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'pending_review',
                'published',
                'rejected',
                'inactive',
            ])->default('pending_review');

            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('is_approved')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | SEO Information
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')
                ->nullable();

            $table->text('meta_description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Publication
            |--------------------------------------------------------------------------
            */

            $table->timestamp('published_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index(['vendor_id', 'status']);

            $table->index(['category_id', 'status']);

            $table->index(['brand_id', 'status']);

            $table->index(['is_featured', 'status']);

            $table->index('price');

            $table->index('stock');

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
