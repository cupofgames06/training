<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vectorizable
 * 
 * @property string $vectorizable_type
 * @property int $vectorizable_id
 * @property int $vector_id
 *
 * @package App\Models
 */
class Vectorizable extends Model
{
	protected $table = 'vectorizables';
	protected $primaryKey = 'vector_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'vectorizable_id' => 'int',
		'vector_id' => 'int'
	];

	protected $fillable = [
		'vectorizable_type',
		'vectorizable_id'
	];
}
