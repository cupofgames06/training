<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\ModelAccessRule;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAccessRule {

    public function access_rules(): MorphMany
    {
        return $this->morphMany(ModelAccessRule::class, 'model');
    }

}
