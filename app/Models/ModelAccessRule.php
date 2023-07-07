<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class CourseAccessRule
 *
 * @property int $id
 * @property array $rule
 *
 * @package App\Models
 */
class ModelAccessRule extends Model
{
    protected $table = 'model_access_rules';

    public $timestamps = false;

    protected $casts = [
        'rule' => 'json'
    ];

    protected $fillable = [
        'model_id',
        'rule'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getReadableAttribute()
    {
        $str = '';

        if (!empty($this->rule['required_courses'])) {
            $required_courses = $this->rule['required_courses'];
            $str .= ' effectué ';
            $str .= count($required_courses) == 1 ? 'la formation ' : 'les formations ';
            for ($i = 0; $i < count($required_courses); $i++) {
                $course = Course::find($required_courses[$i]);
                $str .= '<b>' . $course->description->reference . ' - ' . $course->description->name . '</b>';
                if (count($required_courses) > 1) {
                    if ($i != count($required_courses) - 1) {
                        $str .= ', ';
                    }
                }
            }
        }

        if (array_sum($this->rule['indicators']) > 0) {
            $indicators = array_filter($this->rule['indicators']);
            $str .= !empty($this->rule['required_courses']) ? ', et avoir obtenu au moins ' : ' obtenu au moins ';
            $i = 0;
            foreach ($indicators as $k => $v) {
                $i++;
                $indicator = Indicator::find($k);
                $str .= '<b>' . $v . ' ' . $indicator->unit . ' ' . $indicator->name . '</b>';
                if ($i != count($indicators)) {
                    $str .= ', ';
                }

            }
        }

        return $str;
    }

}
