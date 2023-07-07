<?php

namespace App\Models;

use App\Interfaces\HasAddress;
use App\Traits\CountEnrollment;
use App\Traits\HasPromotion;
use App\Traits\HasUser;
use App\Traits\InteractWithAddress;
use App\Traits\HasEntity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Company extends Model implements HasAddress, HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractWithAddress;
    use InteractsWithMedia;
    use HasEntity;
    use HasPromotion;
    use HasUser;
    use CountEnrollment;

    protected $table = 'companies';

    protected $fillable = [
        'group_id',
        'price_level_id',
        'mandate_id',
        'subscription_id',
    ];

    public function contact(): MorphOne
    {
        return $this->MorphOne(Contact::class, 'contactable');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }


    public function managers(): Builder|HasManyThrough
    {
        return $this->hasManyThrough(User::class, ModelHasUser::class, 'model_id', 'id', 'id', 'user_id')
            ->where(
                ['model_type' => Company::class]
            )->whereHas('roles', function ($query) {
                $query->whereIn('name', ['company']);
            });
    }

    public function learners(): Builder|HasManyThrough
    {
        return $this->hasManyThrough(Learner::class, ModelHasUser::class, 'model_id', 'id', 'id', 'user_id')
            ->where(
                ['model_type' => Company::class]
            )->whereHas('roles', function ($query) {
                $query->whereIn('name', ['learner']);
            })->with(['profile', 'description'])->whereHas('description');
    }
    public function learner($id)
    {
        return $this->learners->where('id',$id)->first();
    }

    public function leftLearners(): HasManyThrough
    {
        return $this->hasManyThrough(Learner::class,LearnerDescription::class,'company_id','id','id','learner_id')->whereNotNull('date_end');
    }

    public function leftLearner($id)
    {
        return $this->leftLearners->where('id',$id)->first();
    }

    public function learners_indicators_pourcent($from = null, $to = null): array
    {
        $learners = $this->learners;
        $indicators = array();
        foreach (Indicator::all() as $indicator) {
            $indicators[$indicator->id] = 0;
        }

        foreach ($learners as $learner) {
            foreach ($learner->indicators->groupBy('id') as $k => $v) {
                if (isset($from)) {
                    $v = $v->filter(function ($item) use ($from) {

                        $itemDate = Carbon::parse($item->pivot->created_at)->format('Y-m-d');
                        return $itemDate >= $from;
                    });
                }
                if (isset($to)) {
                    $v = $v->filter(function ($item) use ($to) {
                        $itemDate = Carbon::parse($item->pivot->created_at)->format('Y-m-d');
                        return $itemDate <= $to;
                    });
                }
                $indicators[$k] += $v->sum('pivot.value');

            }
        }
        foreach ($indicators as $k => $v) {
            $indicators[$k] = $v / $learners->count() / Indicator::find($k)->objective * 100;
        }
        return $indicators;
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'company_id');
    }

    public function mandate(): BelongsTo
    {
        return $this->belongsTo(Mandate::class, 'mandate_id');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'subscription_id');
    }

    static function getList($of_id = [])
    {
        $return = [];
        Company::get()->map(function ($item, $index) use (&$return) {
            $return[$item->id] = $item->entity->name;
        });

        return $return;
    }

    public function averageRating(?Model $course = null,?int $round = 0, ?Carbon $from = null, ?Carbon $to = null): ?float
    {
        $avg = collect();
        foreach ($this->learners as $learner)
        {
            $avg[] = $learner->averageRating($course,$round,$from,$to);
        }
        return round($avg->avg(), $round);
    }
}
