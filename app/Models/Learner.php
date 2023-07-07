<?php

namespace App\Models;

use App\Models\Scopes\LearnerScope;
use App\Traits\InteractWithRating;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Learner extends User
{
    use InteractWithRating;

    protected $guard_name = 'web';

    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope(new LearnerScope());
    }

    public function getMorphClass(): string
    {
        return 'App\Models\User';
    }

    public function history(): HasOne
    {
        return $this->hasOne(LearnerDescription::class)->whereNotNull('date_end');
    }

    public function description(): HasOne
    {
        return $this->hasOne(LearnerDescription::class)->whereNull('date_end');
    }

}
