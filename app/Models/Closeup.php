<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Closeup
 * 
 * @property int $id
 * @property array $name
 * @property bool $active
 * 
 * @property Collection|Item[] $items
 *
 * @package App\Models
 */
class Closeup extends Model
{
	protected $table = 'closeups';
	public $timestamps = false;

	protected $casts = [
		'name' => 'json',
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'active'
	];

	public function items()
	{
		return $this->hasMany(Item::class);
	}
}
