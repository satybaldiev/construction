<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    protected $guarded = ['id'];
    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class, 'floor_id', 'id');
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
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
