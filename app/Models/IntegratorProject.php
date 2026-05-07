<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntegratorProject extends Model
{
    protected $fillable = [
        'title',
        'description',
        'course',
        'class_group',
        'area_id',
        'member_names',
        'cover_image',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(IntegratorProjectImage::class)->orderBy('sort_order');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'integrator_project_user')
            ->withPivot('role_in_project')
            ->withTimestamps();
    }

    public function memberNamesFromText(): array
    {
        if (empty($this->member_names)) {
            return [];
        }

        $raw = str_replace(["\r\n", "\r"], "\n", $this->member_names);
        $parts = preg_split('/[\n,;]+/', $raw) ?: [];

        $names = [];
        foreach ($parts as $part) {
            $name = trim($part);
            if ($name !== '') {
                $names[] = $name;
            }
        }

        $creatorName = $this->creator?->name;
        if ($creatorName) {
            $names[] = $creatorName;
        }

        $unique = [];
        foreach ($names as $name) {
            $key = mb_strtolower($name);
            if (! array_key_exists($key, $unique)) {
                $unique[$key] = $name;
            }
        }

        return array_values($unique);
    }
}
