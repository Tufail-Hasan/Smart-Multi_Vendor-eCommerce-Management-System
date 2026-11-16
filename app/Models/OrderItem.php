<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'product_name',
        'product_sku',
        'quantity',
        'price',
        'discount',
        'tax',
        'total',
        'commission_rate',
        'commission_amount',
        'vendor_earning',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'commission_amount' => 'decimal:2',
            'vendor_earning' => 'decimal:2',
        ];
    }

    // Order Relationship
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Product Relationship
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Vendor Relationship
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
