<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class TrainerDescription extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'trainer_descriptions';

    public $timestamps = false;

    protected $fillable = [
        'cv',
        'is_person',
    ];

    public $translatable = ['cv'];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }


}
