<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Attributes
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'vendor_id',
        'category_id',
        'brand_id',

        'name',
        'slug',
        'sku',

        'short_description',
        'description',

        'price',
        'discount_price',
        'cost_price',

        'stock',
        'low_stock_threshold',

        'weight',
        'weight_unit',

        'thumbnail',
        'gallery',

        'color',
        'size',

        'status',
        'is_featured',
        'is_approved',

        'meta_title',
        'meta_description',

        'published_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'cost_price' => 'decimal:2',

            'weight' => 'decimal:2',

            'stock' => 'integer',
            'low_stock_threshold' => 'integer',

            'gallery' => 'array',

            'is_featured' => 'boolean',
            'is_approved' => 'boolean',

            'published_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Vendor Relationship
    |--------------------------------------------------------------------------
    */


    /*
|--------------------------------------------------------------------------
| Vendor Relationship
|--------------------------------------------------------------------------
*/

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /*
|--------------------------------------------------------------------------
| Category Relationship
|--------------------------------------------------------------------------
*/

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /*
|--------------------------------------------------------------------------
| Brand Relationship
|--------------------------------------------------------------------------
*/

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getEffectivePriceAttribute(): string
    {
        if (
            $this->discount_price !== null
            && (float) $this->discount_price < (float) $this->price
            && (float) $this->discount_price >= 0
        ) {
            return $this->discount_price;
        }

        return $this->price;
    }


    public function isInStock(): bool
    {
        return $this->stock > 0;
    }


    public function isLowStock(): bool
    {
        return $this->stock <= $this->low_stock_threshold;
    }

    /**
     * Get all images for this product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->where('is_primary', true);
    }

    /**
     * Get all variants of this product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get all reviews for this product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getCurrentPriceAttribute(): float
    {
        if ($this->discount_price !== null && $this->discount_price > 0) {
            return (float) $this->discount_price;
        }

        return (float) $this->price;
    }
}
