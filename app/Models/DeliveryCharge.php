<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryCharge extends Model
{
    protected $fillable = [
        'shipping_zone_id',
        'shipping_method_id',
        'name',
        'code',
        'delivery_type',
        'charge',
        'additional_charge',
        'free_shipping_minimum',
        'included_weight',
        'additional_weight_charge',
        'estimated_min_days',
        'estimated_max_days',
        'currency',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'charge' => 'decimal:2',
            'additional_charge' => 'decimal:2',
            'free_shipping_minimum' => 'decimal:2',
            'included_weight' => 'decimal:2',
            'additional_weight_charge' => 'decimal:2',
            'estimated_min_days' => 'integer',
            'estimated_max_days' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')
            ->orderBy('name');
    }
}
