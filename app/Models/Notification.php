<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Notification extends Model
{
    use HasUuids;
    protected $table = 'notifications';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'message',
        'type',
        'category',
        'action_url',
        'read_at',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'data' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Unread notifications
    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    // Read notifications
    public function scopeRead(Builder $query): Builder
    {
        return $query->whereNotNull('read_at');
    }

    // Notifications by category
    public function scopeOfCategory(
        Builder $query,
        string $category
    ): Builder {
        return $query->where('category', $category);
    }

    // Mark a notification as read
    public function markAsRead(): void
    {
        if ($this->read_at === null) {
            $this->update([
                'read_at' => now(),
            ]);
        }
    }
}
