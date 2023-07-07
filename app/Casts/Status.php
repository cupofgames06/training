<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Status implements CastsAttributes
{
    public const CONFIRMED = 'confirmed';
    public const PENDING = 'pending';
    public const CANCELLED = 'cancelled';
    public const REFUSED = 'refused';
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';
    public const DELETED = 'deleted';
    public const VALIDATED = 'validated';
    public const REQUESTED = 'requested';
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return object
     */
    public function get($model, string $key, $value, array $attributes): object
    {
        $color = null;
        if(self::is($value,self::CANCELLED))
        {
            $color = 'info';
        }
        if(self::is($value,self::CONFIRMED) || self::is($value,self::ACTIVE) || self::is($value,self::VALIDATED))
        {
            $color = 'success';
        }
        if(self::is($value,self::REFUSED) || self::is($value,self::DELETED))
        {
            $color = 'danger';
        }
        if(self::is($value,self::PENDING) || self::is($value,self::INACTIVE)|| self::is($value,self::REQUESTED))
        {
            $color = 'warning';
        }

        return (object) array(
            'color' => $color,
            'value' => $value
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        return $value;
    }

    public static function is($value,$constante): bool
    {
        return $value === $constante;
    }
}
