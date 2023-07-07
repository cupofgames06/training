<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\IntraTraining;
use App\Models\Quiz;
use App\Models\Support;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasSupport {

    public function supports(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Support::class, 'supportable');
    }
}
