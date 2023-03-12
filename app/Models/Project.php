<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'address',
        'start_date',
        'estimated_finish_date',
        'project_details',
    ];

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

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class, 'project_id', 'id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
