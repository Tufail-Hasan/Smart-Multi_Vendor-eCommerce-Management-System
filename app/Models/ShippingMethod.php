<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'shipping_cost',
        'free_shipping_minimum',
        'estimated_min_days',
        'estimated_max_days',
        'description',
        'logo',
        'available_areas',
        'supports_cod',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
            'free_shipping_minimum' => 'decimal:2',
            'estimated_min_days' => 'integer',
            'estimated_max_days' => 'integer',
            'available_areas' => 'array',
            'supports_cod' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Only active shipping methods
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Order shipping methods by display order
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')
            ->orderBy('name');
    }
};
