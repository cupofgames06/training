<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Taggable
 * 
 * @property int $tag_id
 * @property string $taggable_type
 * @property int $taggable_id
 * 
 * @property Tag $tag
 *
 * @package App\Models
 */
class Taggable extends Model
{
	protected $table = 'taggables';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tag_id' => 'int',
		'taggable_id' => 'int'
	];

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
