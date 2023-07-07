<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasDate {

    public function getDates()
    {
       dd($this->dates);
    }
}
