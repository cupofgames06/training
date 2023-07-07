<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Theme
 *
 * @property int $id
 * @property int|null $parent_id
 * @property array $t_label
 *
 * @property Theme|null $theme
 * @property Collection|Course[] $courses
 * @property Collection|Theme[] $themes
 *
 * @package App\Models
 */
class Theme extends Model
{
	protected $table = 'themes';

	protected $casts = [
		'parent_id' => 'int',
		't_label' => 'json'
	];

	protected $fillable = [
		'parent_id',
		't_label'
	];

	public function theme()
	{
		return $this->belongsTo(Theme::class, 'parent_id');
	}

	public function courses()
	{
		return $this->belongsToMany(Course::class);
	}

	public function themes()
	{
		return $this->hasMany(Theme::class, 'parent_id');
	}
}
