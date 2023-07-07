<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\Status;
use App\Traits\HasEnrollment;
use App\Traits\HasIntraTraining;
use App\Traits\HasSupport;
use App\Traits\IsOffer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Translatable\HasTranslations;

class Session extends Model
{
    use HasEnrollment;
    use HasFactory;
    use HasIntraTraining;
    use HasSupport;
    use IsOffer;

    public const STATUS = array(
        Status::ACTIVE,
        Status::INACTIVE,
        Status::VALIDATED,
        Status::DELETED
    );

    protected $table = 'sessions';

    protected $fillable = [
        'course_id',
        'classroom_url',
        'classroom_id',
        'max_learners', //conservé au cas ou ajustement pour session
        'cost',
        'status',
        'date_start'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function days()
    {
        return $this->hasMany(SessionDay::class);
    }

    public function calendar_days($excludes = [])
    {
        return $this->days->whereNotIn('id', $excludes)->sortBy('date')->map(
            function ($item) {
                return $item->calendar_date;
            }
        );
    }

    public function packables()
    {
        return $this->morphMany(Packable::class,'packable');
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class, 'session_trainer', 'session_id', 'trainer_id')
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['trainer']);
            })->withPivot(['id', 'via_of']);
    }


    public function title()
    {
        return $this->course->title();
    }

    public function subtitle()
    {
        $subtitle = "";
        if ($this->days->count() > 0) {
            $subtitle .= $this->date_start == $this->date_end ? $this->first_day->calendar_date : $this->first_day->calendar_date . ' - ' . $this->last_day->calendar_date;
            $subtitle .= ' - ';
        }

        $subtitle .= $this->course->type == 'physical' ? $this->classroom->address->postal_code.' '. $this->classroom->address->city : custom('course-type.' . $this->course->type)['name'];

        return $subtitle;
    }

    static function getList($exclude = [], $type = null): array
    {
        $return = [];
        $query = Session::where('status','!=', 'deleted')->with('description')->whereNotIn('id', $exclude);
        if (!empty($type)) {
            $type = is_array($type) ? $type : [$type];
            $query->whereHas('course',function($query) use($type) {
                return $query->whereIn('type', $type);
            });
        }
        $query->get()->sortBy('course.description.reference')->map(function ($item, $index) use (&$return) {
            $return[$item->id] = $item->course->description->reference . ' - ' . $item->subtitle();
        });

        return $return;
    }

    public function getPlaceAttribute()
    {
        return !empty($this->classroom)?$this->classroom->address_city():'-';
    }

    public function getFirstDayAttribute()
    {
        if ($this->days->count() == 0) {
            return null;
        }

        $arr = $this->days->sortByDesc('date');
        $keys = array_keys($arr->toarray());
        $key = array_pop($keys);

        return $arr[$key];
    }

    public function getLastDayAttribute()
    {
        $arr = $this->days->sortByDesc('date');
        $keys = array_keys($arr->toarray());
        $key = array_shift($keys);

        return $arr[$key];
    }

    public function dateStart() : Attribute
    {
        $first_day = $this->getFirstDayAttribute();
        $v = !empty($first_day->am_start)?
            Carbon::createFromFormat('Y-m-d H:i:s',$first_day->date. ' ' . $first_day->am_start)
            :Carbon::createFromFormat('Y-m-d', $first_day->date);

        return Attribute::make(get: fn() => $v);
    }

    public function dateEnd() : Attribute
    {
        $last_day = $this->getLastDayAttribute();
        $v = !empty($last_day->am_start)?
            Carbon::createFromFormat('Y-m-d H:i:s',$last_day->date. ' ' . $last_day->am_start)
            :Carbon::createFromFormat('Y-m-d', $last_day->date);

        return Attribute::make(get: fn() => $v);
    }

    /**
     * Compte la durée total d'une session
     * @return Attribute
     */
    protected function duration(): Attribute
    {
        $count = 0;
        foreach ($this->days as $day)
        {

            if (isset($day->am_start)) {
                $date_start_morning = Carbon::createFromFormat('Y-m-d H:i:s', $day->date . ' ' . $day->am_start);
                $date_end_morning = Carbon::createFromFormat('Y-m-d H:i:s', $day->date . ' ' . $day->am_end);
                $count += $date_end_morning->diffInSeconds($date_start_morning);
            }
            if (isset($day->pm_start)) {
                $date_start_afternoon = Carbon::createFromFormat('Y-m-d H:i:s', $day->date . ' ' . $day->pm_start);
                $date_end_afternoon = Carbon::createFromFormat('Y-m-d H:i:s', $day->date . ' ' . $day->pm_end);
                $count += $date_end_afternoon->diffInSeconds($date_start_afternoon);
            }
        }

        return Attribute::make(
            get: fn() => $count,
        );

    }
}
