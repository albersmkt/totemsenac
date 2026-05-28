<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'nome',
        'cidade',
        'image',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(IntegratorProject::class);
    }

    public function entrepreneurs(): HasMany
    {
        return $this->hasMany(Entrepreneur::class);
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }
}
