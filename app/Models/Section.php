<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $guarded = ['id'];
    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class, 'project_id', 'id');
    }
    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class, 'project_id', 'id');
    }
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class, 'block_id', 'id');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
