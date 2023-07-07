<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clue
 * 
 * @property int $id
 * @property int|null $parent_id
 * @property array $name
 * @property array $short_description
 * @property array $description
 *
 * @package App\Models
 */
class Clue extends Model
{
	protected $table = 'clues';
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'name' => 'json',
		'short_description' => 'json',
		'description' => 'json'
	];

	protected $fillable = [
		'parent_id',
		'name',
		'short_description',
		'description'
	];
}
