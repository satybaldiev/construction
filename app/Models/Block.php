<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'project_id', 'id');
    }
    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class, 'project_id', 'id');
    }
    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class, 'project_id', 'id');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
