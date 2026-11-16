<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportSnapshot extends Model
{
    protected $fillable = [
        'report_type',
        'title',
        'filters',
        'report_data',
        'format',
        'generated_at',
        'generated_by',
    ];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'report_data' => 'array',
            'generated_at' => 'datetime',
        ];
    }

    public function generatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function scopeOfType(
        Builder $query,
        string $type
    ): Builder {
        return $query->where('report_type', $type);
    }
}
