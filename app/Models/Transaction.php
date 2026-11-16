<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',

        'payment_id',
        'order_id',
        'vendor_id',

        'type',
        'amount',
        'currency',

        'payment_method',
        'gateway_name',

        'gateway_transaction_id',
        'reference_number',

        'status',

        'description',
        'failure_reason',
        'gateway_response',

        'processed_by',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',

            'gateway_response' => 'array',

            'processed_at' => 'datetime',
        ];
    }

    /**
     * Transaction belongs to a Payment.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Transaction belongs to an Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Transaction belongs to a Vendor.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * User who processed the transaction.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
