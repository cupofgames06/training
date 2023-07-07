<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemLabel
 * 
 * @property int $id
 * @property int $item_id
 * @property array $name
 * @property array $description
 * 
 * @property Item $item
 *
 * @package App\Models
 */
class ItemLabel extends Model
{
	protected $table = 'item_labels';
	public $timestamps = false;

	protected $casts = [
		'item_id' => 'int',
		'name' => 'json',
		'description' => 'json'
	];

	protected $fillable = [
		'item_id',
		'name',
		'description'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}
}
