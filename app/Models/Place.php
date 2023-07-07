<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Place
 * 
 * @property int $id
 * @property int|null $actor_id
 * @property array $name
 * @property array $description
 * 
 * @property Actor|null $actor
 *
 * @package App\Models
 */
class Place extends Model
{
	protected $table = 'places';
	public $timestamps = false;

	protected $casts = [
		'actor_id' => 'int',
		'name' => 'json',
		'description' => 'json'
	];

	protected $fillable = [
		'actor_id',
		'name',
		'description'
	];

	public function actor()
	{
		return $this->belongsTo(Actor::class);
	}
}
