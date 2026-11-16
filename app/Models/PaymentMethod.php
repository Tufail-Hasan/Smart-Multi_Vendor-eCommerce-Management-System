<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'description',
        'logo',
        'type',
        'method_type',
        'gateway_name',
        'configuration',
        'fixed_fee',
        'percentage_fee',
        'minimum_amount',
        'maximum_amount',
        'currency',
        'is_active',
        'is_test_mode',
        'supports_refund',
        'sort_order',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'configuration' => 'array',

            'fixed_fee' => 'decimal:2',
            'percentage_fee' => 'decimal:2',
            'minimum_amount' => 'decimal:2',
            'maximum_amount' => 'decimal:2',

            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'supports_refund' => 'boolean',

            'sort_order' => 'integer',
        ];
    }

    /**
     * User who created the payment method.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
