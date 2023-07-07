<?php

namespace App\Traits;

use App\Models\Price;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
trait HasPrice {
    public function price(): MorphOne
    {
        return $this->morphOne(Price::class, 'priceable');
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'priceable');
    }

    public function getPrice($price_level_id = 1): object|null
    {
        return $this->prices()->where('price_level_id',$price_level_id)->first();
    }

    public function setPrices($prices): void
    {
        foreach ($prices as $k => $v) {
            $price = $v;
            $price['price_level_id'] = $k;
            $price['charge'] = $price['price_ht'] * (custom('charge') / 100);
            $price['vat_amount'] = $price['price_ttc'] - $price['price_ht'];
            $this->prices()->updateOrCreate(['price_level_id' => $k], $price);
        }
    }

}
