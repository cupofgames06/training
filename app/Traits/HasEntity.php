<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasEntity {
    public function entity(): MorphOne
    {
        return $this->morphOne(Entity::class, 'modelable');
    }
}
