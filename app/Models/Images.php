<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Images extends Model
{
    protected $guarded = ['id'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
