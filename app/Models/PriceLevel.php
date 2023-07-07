<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceLevel extends Model
{
    use HasFactory;
    use HasTranslations;

	protected $table = 'price_levels';
    public array $translatable = ['name'];
    public $timestamps = false;

	protected $fillable = [
		'name',
	];

    public function companies() : HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function prices() : HasMany
    {
        return $this->hasMany(Price::class);
    }
}
