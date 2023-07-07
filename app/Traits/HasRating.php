<?php

namespace App\Traits;

use App\Exceptions\InvalidDate;
use App\Models\Company;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRating
{

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class,'model','model_type','model_id')->latest('id');
    }
    public function latestRating()
    {
        return $this->ratings()->first();
    }
    /**
     * @param Carbon|null $from
     * @param Carbon|null $to
     * @return int
     * @throws InvalidDate
     */
    public function numberOfRatings(?Model $course = null,?Carbon $from = null, ?Carbon $to = null): int
    {

        if (isset($from) && isset($to) && $from->greaterThan($to)) {
            throw InvalidDate::from();
        }

        return $this->ratings()
            ->whereNotNull('rating')
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            })
            ->when($course,function($query)use($course){
                $query->where('course_id',$course->id);
            })
            ->count();
    }

    public function averageRating(?Model $course = null,?int $round = 0, ?Carbon $from = null, ?Carbon $to = null): ?float
    {
        return $this->ratings()
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
            })
            ->when($course,function($query)use($course){
                $query->where('course_id',$course->id);
            })
            ->when($round, function ($query) use ($round) {
                $query->selectRaw("ROUND(AVG(rating), $round) as rating")->groupBy('id');
            }, function ($query) {
                $query->selectRaw("AVG(rating) as rating")->groupBy('id');
            })
            ->value('rating');
    }
}
