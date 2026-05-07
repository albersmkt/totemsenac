<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntrepreneurImage extends Model
{
    protected $fillable = [
        'entrepreneur_id',
        'path',
        'sort_order',
    ];

    public function entrepreneur(): BelongsTo
    {
        return $this->belongsTo(Entrepreneur::class);
    }
}
