<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'discount_type',
        'discount_value',
        'maximum_discount',
        'applies_to',
        'product_ids',
        'category_ids',
        'brand_ids',
        'vendor_ids',
        'starts_at',
        'ends_at',
        'priority',
        'is_active',
        'is_combinable',
        'created_by',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'maximum_discount' => 'decimal:2',

            'product_ids' => 'array',
            'category_ids' => 'array',
            'brand_ids' => 'array',
            'vendor_ids' => 'array',

            'starts_at' => 'datetime',
            'ends_at' => 'datetime',

            'priority' => 'integer',

            'is_active' => 'boolean',
            'is_combinable' => 'boolean',
        ];
    }

    /**
     * Admin who created this discount.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check whether the discount is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();

        if (! $this->is_active) {
            return false;
        }

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $now->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for a given price.
     */
    public function calculateDiscount(float $price): float
    {
        if (! $this->isCurrentlyActive() || $price <= 0) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $amount = $price * ((float) $this->discount_value / 100);
        } else {
            $amount = (float) $this->discount_value;
        }

        if ($this->maximum_discount !== null) {
            $amount = min(
                $amount,
                (float) $this->maximum_discount
            );
        }

        // Discount must not exceed the product price.
        return round(min($amount, $price), 2);
    }
}
