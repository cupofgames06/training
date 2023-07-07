<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $appends = ['charge'];

    protected $casts = [
        'options' => 'json'
    ];

    protected $fillable = [
        'price_level_id',
        'price_ht',
        'price_ttc',
        'vat_rate',
        'vat_amount',
        'charge',
        'type',
        'options'
    ];

    public function getChargeAttribute($value): float
    {
        //dd('go');
        return 25.32;
    }

    public function priceable()
    {
        return $this->morphTo();
    }
}
