<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Plan extends Model
{
    protected $guarded = ['id'];
    public function images(): MorphMany
    {
        return $this->morphMany(Images::class, 'imageable');
    }
}
