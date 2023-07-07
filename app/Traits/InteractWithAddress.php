<?php

namespace App\Traits;

use App\Models\Address;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait InteractWithAddress {

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');

    }

    public function address_number():string
    {
        return (string) $this->address->street_number;
    }
    public function address_street():string
    {
        return (string) $this->address->street_name;
    }
    public function address_complement():string
    {
        return (string) $this->address->complement;
    }
    public function address_city(): string
    {
        return (string) $this->address->city;
    }
    public function address_country(): string
    {

        return (string) $this->address->country->name;
    }
    public function address_postal_code(): string
    {

        return (string) $this->address->postal_code;
    }
    public function get_address(): string{
        return ucfirst("{$this->address_number()} {$this->address_street()} {$this->address_complement()} - {$this->address_city()} ({$this->address_postal_code()}) ");
    }

    public function address_position(): object{
        return (object) array(
            'latitude' => $this->address->latitude,
            'longitude' => $this->address->longitude
        );
    }
}
