<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class);
    }
    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class);
    }
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

}
