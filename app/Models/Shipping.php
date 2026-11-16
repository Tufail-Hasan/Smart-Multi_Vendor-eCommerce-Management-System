<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shipping_number',
        'courier_name',
        'tracking_number',
        'shipping_method',
        'shipping_cost',
        'status',
        'recipient_name',
        'recipient_phone',
        'recipient_email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'shipped_at',
        'estimated_delivery_at',
        'delivered_at',
        'notes',
        'managed_by',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'decimal:2',
            'shipped_at' => 'datetime',
            'estimated_delivery_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    /**
     * Shipping belongs to an Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * User who manages the shipping.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'managed_by');
    }
}
