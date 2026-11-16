<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'customer_id',
        'refund_number',
        'refund_amount',
        'currency',
        'refund_type',
        'reason',
        'description',
        'refund_method',
        'refund_account',
        'transaction_id',
        'gateway_reference',
        'status',
        'processed_by',
        'admin_note',
        'failure_reason',
        'requested_at',
        'approved_at',
        'processed_at',
        'completed_at',
        'gateway_response',
    ];

    protected function casts(): array
    {
        return [
            'refund_amount' => 'decimal:2',

            'gateway_response' => 'array',

            'requested_at' => 'datetime',
            'approved_at' => 'datetime',
            'processed_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Refund belongs to an order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Refund belongs to a payment.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Refund belongs to a customer.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Admin/user who processed the refund.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
