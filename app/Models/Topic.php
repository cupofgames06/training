<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 * 
 * @property int $id
 * @property array $name
 * @property array $description
 * @property int|null $project_id
 * 
 * @property Project|null $project
 *
 * @package App\Models
 */
class Topic extends Model
{
	protected $table = 'topics';
	public $timestamps = false;

	protected $casts = [
		'name' => 'json',
		'description' => 'json',
		'project_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'project_id'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
