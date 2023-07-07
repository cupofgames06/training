<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $id
 * @property int $actor_id
 * @property string $question
 * 
 * @property Actor $actor
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';
	public $timestamps = false;

	protected $casts = [
		'actor_id' => 'int'
	];

	protected $fillable = [
		'actor_id',
		'question'
	];

	public function actor()
	{
		return $this->belongsTo(Actor::class);
	}
}
