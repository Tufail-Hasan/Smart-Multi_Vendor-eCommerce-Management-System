<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $table = 'return_requests';

    protected $fillable = [
        'order_id',
        'customer_id',
        'product_id',

        'return_number',
        'quantity',
        'reason',
        'description',

        'status',
        'item_condition',

        'refund_amount',
        'refund_status',
        'refund_method',
        'refund_transaction_id',

        'return_tracking_number',
        'return_shipping_cost',

        'reviewed_by',
        'admin_note',
        'rejection_reason',

        'requested_at',
        'approved_at',
        'received_at',
        'refunded_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',

            'refund_amount' => 'decimal:2',
            'return_shipping_cost' => 'decimal:2',

            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'received_at' => 'datetime',
            'refunded_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Return belongs to an Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Return belongs to a Customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Return belongs to a Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Admin who reviewed the return request.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
