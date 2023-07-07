<?php

namespace App\Traits;

use App\Models\OfferDescription;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasOfferDescription {

    public function description() :MorphOne
    {
        return $this->morphOne(OfferDescription::class, 'describable');
    }

}
