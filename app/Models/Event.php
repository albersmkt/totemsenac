<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'location',
        'cover_image',
        'status',
        'created_by',
        'unidade_id',
        'published_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(EventImage::class)->orderBy('sort_order');
    }

    public function scopeVisibleOnTotem(Builder $query): Builder
    {
        $today = today()->toDateString();

        return $query
            ->where('status', 'published')
            ->where(function (Builder $query) use ($today) {
                $query
                    ->whereDate('end_at', '>=', $today)
                    ->orWhere(function (Builder $query) use ($today) {
                        $query
                            ->whereNull('end_at')
                            ->whereDate('start_at', '>=', $today);
                    });
            });
    }

    public function isVisibleOnTotem(): bool
    {
        $expiresAt = $this->end_at ?? $this->start_at;

        return $this->status === 'published'
            && $expiresAt !== null
            && $expiresAt->toDateString() >= today()->toDateString();
    }
}
