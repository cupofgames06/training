<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Knowledge
 * 
 * @property int $id
 * @property int $project_id
 * @property string $text
 * 
 * @property Project $project
 *
 * @package App\Models
 */
class Knowledge extends Model
{
	protected $table = 'knowledges';
	public $timestamps = false;

	protected $casts = [
		'project_id' => 'int'
	];

	protected $fillable = [
		'project_id',
		'text'
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
