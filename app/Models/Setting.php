<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'label',
        'value',
        'type',
        'description',
        'is_public',
        'is_sensitive',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_sensitive' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Get settings belonging to a particular group.
     */
    public function scopeOfGroup(
        Builder $query,
        string $group
    ): Builder {
        return $query->where('group', $group);
    }

    /**
     * Get active settings only.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get public settings only.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Get the value of a setting by key.
     */
    public static function getValue(
        string $key,
        mixed $default = null
    ): mixed {
        $setting = static::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        return $setting?->value ?? $default;
    }

    /**
     * Create or update a setting.
     */
    public static function setValue(
        string $key,
        mixed $value,
        string $group = 'general',
        string $label = 'Setting',
        string $type = 'text'
    ): self {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'label' => $label,
                'value' => $value === null
                    ? null
                    : (string) $value,
                'type' => $type,
            ]
        );
    }
}
