<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'discount_type',
        'discount_value',
        'maximum_discount',
        'minimum_order_amount',
        'usage_limit',
        'usage_limit_per_customer',
        'used_count',
        'applies_to',
        'product_ids',
        'category_ids',
        'vendor_ids',
        'starts_at',
        'expires_at',
        'is_active',
        'currency',
        'created_by',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',

            'usage_limit' => 'integer',
            'usage_limit_per_customer' => 'integer',
            'used_count' => 'integer',

            'product_ids' => 'array',
            'category_ids' => 'array',
            'vendor_ids' => 'array',

            'starts_at' => 'datetime',
            'expires_at' => 'datetime',

            'is_active' => 'boolean',
        ];
    }

    /**
     * User who created the coupon.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check whether the coupon is currently valid.
     */
    public function isValid(): bool
    {
        $now = now();

        if (! $this->is_active) {
            return false;
        }

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if (
            $this->usage_limit !== null &&
            $this->used_count >= $this->usage_limit
        ) {
            return false;
        }

        return true;
    }
}
