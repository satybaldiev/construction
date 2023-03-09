<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    protected $guarded = ['id'];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class, 'project_id', 'id');
    }
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
    public function images(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

}
