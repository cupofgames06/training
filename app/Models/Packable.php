<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Packable extends Model
{
    protected $table = 'packables';

    public $timestamps = false;

    protected $fillable = [
        'pack_id',
        'position'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }

}
