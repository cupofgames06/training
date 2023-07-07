<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    public function model() : MorphTo
    {
        return $this->morphTo();
    }
    public function author() : MorphTo
    {
        return $this->morphTo();
    }

}
