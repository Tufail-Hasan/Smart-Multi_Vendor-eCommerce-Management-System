<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewRating extends Model
{
    protected $table = 'review_ratings';

    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'title',
        'review',
        'images',
        'is_verified_purchase',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
        'helpful_count',
        'report_count',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'images' => 'array',
            'is_verified_purchase' => 'boolean',
            'replied_at' => 'datetime',
            'helpful_count' => 'integer',
            'report_count' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'replied_by'
        );
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeWithRating(
        Builder $query,
        int $rating
    ): Builder {
        return $query->where('rating', $rating);
    }
}
