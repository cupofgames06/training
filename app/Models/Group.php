<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\GroupScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Group extends User
{
    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope(new GroupScope());
    }

    public function entity(): MorphOne
    {
        return $this->morphOne(Entity::class, 'modelable');
    }

}
