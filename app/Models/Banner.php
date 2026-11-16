<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'description',
        'image',
        'mobile_image',
        'button_text',
        'button_url',
        'position',
        'sort_order',
        'start_date',
        'end_date',
        'is_active',
        'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Check whether the banner is currently active.
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();

        return $this->is_active
            && (
                $this->start_date === null
                || $this->start_date <= $now
            )
            && (
                $this->end_date === null
                || $this->end_date >= $now
            );
    }

    /**
     * Scope active banners.
     */
    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Scope banners by position.
     */
    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }
}
