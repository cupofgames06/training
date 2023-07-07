<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Certificate
 *
 * @property int $id
 * @property int $learner_id
 * @property Carbon $date
 * @property string $place
 * @property string $person
 * @property int $score
 * @property string $code
 *
 * @property Collection|Enrollment[] $enrollments
 *
 * @package App\Models
 */
class Certificate extends Model
{
	protected $table = 'certificates';

	protected $casts = [
		'learner_id' => 'int',
		'score' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'learner_id',
		'date',
		'place',
		'person',
		'score',
		'code'
	];

	public function enrollments()
	{
		return $this->hasMany(Enrollment::class);
	}
}
