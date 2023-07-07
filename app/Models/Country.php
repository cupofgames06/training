<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'countries';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
    ];

    public array $translatable = ['name'];

    static function getSelectList($key = 'id', $value = 'name')
    {
        $countries = self::get()->sortBy('name')->pluck($value, $key)->toArray();
        $countries = ['' => ''] + $countries;
        return $countries;
    }

}
