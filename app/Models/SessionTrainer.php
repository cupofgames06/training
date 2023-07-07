<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TrainerSession
 *
 * @property int $id
 * @property int $session_id
 * @property int $trainer_id
 * @property Session $session
 *
 * @package App\Models
 */
class SessionTrainer extends Model
{
    protected $table = 'session_trainer';

    public $timestamps = false;

    protected $fillable = [
        'trainer_id',
        'session_id',
        'via_of'
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->BelongsTo(Trainer::class);
    }
}
