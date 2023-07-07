<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Guard;
use \Spatie\Translatable\HasTranslations;
/**
 * Class Indicator
 *
 * @property int $id
 * @property bool $main
 * @property int $objective
 * @property array $t_label
 * @property array $t_unit
 *
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class Indicator extends Model
{
    use HasTranslations;

    protected $table = 'indicators';

	protected $casts = [
		'objective' => 'int',
		'name' => 'json',
		'unit' => 'json'
	];

	protected $fillable = [
		'objective',
		'name',
		'unit'
	];

    public $translatable = ['name','unit'];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_indicator')->withPivot('value');
    }

    public function getNameAttribute($value): string
    {
        return mb_strtoupper($value);
    }
}
