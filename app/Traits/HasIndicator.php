<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\Indicator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasIndicator {

    public function indicators(): MorphToMany
    {
        return $this->morphToMany(
            Indicator::class,
            'modelable',
            'model_has_course_indicator'
        )->withPivot('value','course_id','created_at');

    }

    public function addIndicatorCourse($indicator,$course,$value)
    {
        if (is_int($indicator)) {
            $indicator = Indicator::find($indicator);
        }

        if (is_string($indicator)) {
            $indicator = Indicator::where('name',$indicator)->first();
        }
        if (is_int($course)) {
            $course = Course::find($course);
        }

        $this->indicators()->attach($indicator->id,[
            'course_id' => $course->id,
            'value' => $value,
            'created_at' => Carbon::now()
        ]);

    }

    public function indicators_pourcent($from = null,$to = null)
    {
        $indicators = array();
        foreach (Indicator::all() as $indicator)
        {
            $indicators[$indicator->id] = 0;
        }

        foreach ($this->indicators->groupBy('id') as $k => $v)
        {
            if(isset($from))
            {
                $v = $v->filter(function ($item) use ($from) {
                    $itemDate = Carbon::parse($item->pivot->created_at)->format('Y-m-d');
                    return $itemDate >= $from;
                });
            }
            if(isset($to))
            {
                $v = $v->filter(function ($item) use ($to) {
                    $itemDate = Carbon::parse($item->pivot->created_at)->format('Y-m-d');
                    return $itemDate <= $to;
                });
            }
            $indicators[$k] += $v->sum('pivot.value');
        }

        foreach ($indicators as $k => $v)
        {
            $indicators[$k] = $v / Indicator::find($k)->objective * 100;
        }
        return $indicators;
    }

    public function getIndicatorList()
    {
      return  $this->indicators->pluck('value', 'indicator_id')->toArray();
    }
}

