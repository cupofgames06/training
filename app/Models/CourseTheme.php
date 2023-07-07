<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CourseTheme
 * 
 * @property int $course_id
 * @property int $theme_id
 * 
 * @property Course $course
 * @property Theme $theme
 *
 * @package App\Models
 */
class CourseTheme extends Model
{
	protected $table = 'course_theme';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'course_id' => 'int',
		'theme_id' => 'int'
	];

	protected $fillable = [
		'course_id',
		'theme_id'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function theme()
	{
		return $this->belongsTo(Theme::class);
	}
}
