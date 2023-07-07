<?php

namespace App\Interfaces;

use App\Models\Address;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface HasAddress {

    public function address(): MorphOne;

    public function address_number(): string;
    public function address_street():string;
    public function address_complement():string;
    public function get_address(): string;
    public function address_city(): string;
    public function address_country(): string;
    public function address_postal_code(): string;
    public function address_position(): object;
}
