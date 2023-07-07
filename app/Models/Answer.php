<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * 
 * @property int $id
 * @property int $actor_id
 * @property int $question_id
 * @property array $text
 * @property array $audio_filename
 * 
 * @property Actor $actor
 *
 * @package App\Models
 */
class Answer extends Model
{
	protected $table = 'answers';
	public $timestamps = false;

	protected $casts = [
		'actor_id' => 'int',
		'question_id' => 'int',
		'text' => 'json',
		'audio_filename' => 'json'
	];

	protected $fillable = [
		'actor_id',
		'question_id',
		'text',
		'audio_filename'
	];

	public function actor()
	{
		return $this->belongsTo(Actor::class, 'question_id');
	}
}
