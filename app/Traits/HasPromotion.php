<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\ModelAccessRule;
use App\Models\ModelHasPromotion;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasPromotion {

    public function promotions()
    {
        return $this->morphMany(ModelHasPromotion::class,'model');
    }

}
