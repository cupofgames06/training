<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Actor
 * 
 * @property int $id
 * @property int|null $project_id
 * @property array $name
 * @property array $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Project|null $project
 * @property Collection|Answer[] $answers
 * @property Collection|Place[] $places
 * @property Collection|Question[] $questions
 *
 * @package App\Models
 */
class Actor extends Model
{
	protected $table = 'actors';

	protected $casts = [
		'project_id' => 'int',
		'name' => 'json',
		'description' => 'json'
	];

	protected $fillable = [
		'project_id',
		'name',
		'description'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function answers()
	{
		return $this->hasMany(Answer::class, 'question_id');
	}

	public function places()
	{
		return $this->hasMany(Place::class);
	}

	public function questions()
	{
		return $this->hasMany(Question::class);
	}
}
