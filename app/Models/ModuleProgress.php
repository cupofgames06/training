<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModuleProgress
 * 
 * @property int $id
 * @property int $quiz_version_id
 * @property array $datas
 * @property Carbon $first_login
 * @property Carbon $last_login
 * @property int $score
 * @property int $status
 * @property string|null $last_token
 * 
 * @property QuizVersion $quiz_version
 *
 * @package App\Models
 */
class ModuleProgress extends Model
{
	protected $table = 'module_progress';
	public $timestamps = false;

	protected $casts = [
		'quiz_version_id' => 'int',
		'datas' => 'json',
		'score' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'first_login',
		'last_login'
	];

	protected $hidden = [
		'last_token'
	];

	protected $fillable = [
		'quiz_version_id',
		'datas',
		'first_login',
		'last_login',
		'score',
		'status',
		'last_token'
	];

	public function quiz_version()
	{
		return $this->belongsTo(QuizVersion::class);
	}
}
