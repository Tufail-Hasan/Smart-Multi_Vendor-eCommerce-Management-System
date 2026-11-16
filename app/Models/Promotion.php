<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'type',
        'description',
        'discount_value',
        'maximum_discount',
        'minimum_order_amount',
        'usage_limit',
        'usage_per_customer',
        'used_count',
        'start_date',
        'end_date',
        'banner_image',
        'button_text',
        'button_url',
        'sort_order',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'usage_per_customer' => 'integer',
            'used_count' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Admin who created the promotion.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    /**
     * Scope: Active promotions within their scheduled dates.
     */
    public function scopeCurrentlyActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function (Builder $q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->where(function (Builder $q) {
                $q->whereNull('usage_limit')
                    ->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }

    /**
     * Check whether the promotion is currently available.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();

        return $this->is_active
            && (
                $this->start_date === null
                || $this->start_date <= $now
            )
            && (
                $this->end_date === null
                || $this->end_date >= $now
            )
            && (
                $this->usage_limit === null
                || $this->used_count < $this->usage_limit
            );
    }
}
