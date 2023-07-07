<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Entity extends Model
{
    use HasFactory;

	protected $table = 'entities';

	public $timestamps = false;

	protected $fillable = [
		'type',
		'reg_number',
		'vat_number',
		'name'
	];

    /**
     * Get the parent modelable model (company, of).
     */
    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }
    public function getNameAttribute($value): string
    {
        return mb_strtoupper($value);
    }

}
