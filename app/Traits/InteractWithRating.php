<?php

namespace App\Traits;

use App\Exceptions\InvalidDate;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractWithRating
{

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class,'author','author_type','author_id')->latest('id');
    }
    public function latestRating()
    {
        return $this->ratings()->first();
    }
    public function rating(Model $model, Model $author,Model $course, ?float $rating = null, ?string $comment = null) : self
    {
        return $this->createRating($model, $author, $course,$rating, $comment);
    }

    private function createRating($model, $author, $course ,$rating, $comment)
    {

        $createdReview = $this->ratings()->create([
            'author_id' => $author->getKeyName(),
            'author_type' => $author->getMorphClass(),
            'model_id' => $model->getKeyName(),
            'model_type' =>  $model->getMorphClass(),
            'course_id' => $course->id,
            'rating' => $rating,
            'comment' => $comment,
        ]);

        return $this;
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
        $from = $from?->format("Y-m-d");
        $to = $to?->format("Y-m-d");

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

