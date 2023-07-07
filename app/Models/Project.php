<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Actor[] $actors
 * @property Collection|Context[] $contexts
 * @property Collection|Knowledge[] $knowledge
 * @property Collection|Topic[] $topics
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'projects';

	protected $fillable = [
		'name'
	];

	public function actors()
	{
		return $this->hasMany(Actor::class);
	}

	public function contexts()
	{
		return $this->hasMany(Context::class);
	}

	public function knowledge()
	{
		return $this->hasMany(Knowledge::class);
	}

	public function topics()
	{
		return $this->hasMany(Topic::class);
	}
}
