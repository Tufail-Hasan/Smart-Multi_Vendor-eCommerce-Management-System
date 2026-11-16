<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'country',
        'division',
        'district',
        'areas',
        'shipping_cost',
        'free_shipping_minimum',
        'estimated_min_days',
        'estimated_max_days',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'areas' => 'array',
            'shipping_cost' => 'decimal:2',
            'free_shipping_minimum' => 'decimal:2',
            'estimated_min_days' => 'integer',
            'estimated_max_days' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Show only active shipping zones
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Sort shipping zones
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')
            ->orderBy('name');
    }
};
