<?php

namespace App\Traits;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasEnrollment {
    use CountEnrollment;

    public function enrollments(): MorphMany
    {
        return $this->morphMany(Enrollment::class, 'enrollmentable');

    }
}
