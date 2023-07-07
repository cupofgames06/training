<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\IntraTraining;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasIntraTraining {

    public function intra_trainings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(IntraTraining::class, 'trainable');
    }
}
