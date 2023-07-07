<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property string|null $type
 * @property int|null $order_column
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Taggable[] $taggables
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tags';

	protected $casts = [
		'name' => 'json',
		'slug' => 'json',
		'order_column' => 'int'
	];

	protected $fillable = [
		'name',
		'slug',
		'type',
		'order_column'
	];

	public function taggables()
	{
		return $this->hasMany(Taggable::class);
	}
}
