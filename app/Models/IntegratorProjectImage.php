<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegratorProjectImage extends Model
{
    protected $fillable = [
        'integrator_project_id',
        'path',
        'sort_order',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(IntegratorProject::class, 'integrator_project_id');
    }
}
