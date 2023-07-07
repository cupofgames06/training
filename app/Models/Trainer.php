<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;


use App\Interfaces\HasAddress;
use App\Models\Scopes\TrainerScope;
use App\Traits\HasRating;
use App\Traits\InteractWithAddress;
use App\Traits\HasEntity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trainer extends User implements HasAddress
{
    use InteractWithAddress;
    use HasRating;
    use HasEntity;

    protected $table = 'users';
    public const TRAINER_TYPE = array(
       1 => 'person',
       0 => 'company'
    );

    protected static function booted()
    {
        static::addGlobalScope(new TrainerScope());
    }

    public function getMorphClass(): string
    {
        return 'App\Models\User';
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class,'session_trainer','trainer_id');
    }

    public function description()
    {
        return $this->hasOne(TrainerDescription::class);
    }

    static function getTypeList()
    {
        $r = [];
        foreach (self::TRAINER_TYPE as $k => $v) {
            $r[$k] = trans('of.trainers.type_' . $v);
        }

        return $r;
    }
}
