<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Context
 * 
 * @property int $id
 * @property int $project_id
 * @property Carbon $date_start
 * @property Carbon $date_end
 * @property array $geo_description
 * @property array $story_description
 * @property array $user_description
 * 
 * @property Project $project
 *
 * @package App\Models
 */
class Context extends Model
{
	protected $table = 'contexts';
	public $timestamps = false;

	protected $casts = [
		'project_id' => 'int',
		'date_start' => 'datetime',
		'date_end' => 'datetime',
		'geo_description' => 'json',
		'story_description' => 'json',
		'user_description' => 'json'
	];

	protected $fillable = [
		'project_id',
		'date_start',
		'date_end',
		'geo_description',
		'story_description',
		'user_description'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
