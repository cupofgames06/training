<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\HasAddress;
use App\Traits\HasRating;
use App\Traits\HasUser;
use App\Traits\InteractWithAddress;
use App\Traits\HasEntity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Of extends Model implements HasAddress,HasMedia
{
    use HasFactory;
    use InteractWithAddress;
    use HasEntity;
    use HasRating;
    use InteractsWithMedia;
    use HasUser;

    protected $table = 'ofs';

    protected $fillable = [
        'mandate_id',
        'subscription_id',
        'agreement_number',
        'licence_percent',
        'charge_percent'
    ];

    public function contact(): MorphOne
    {
        return $this->MorphOne(Contact::class, 'contactable');
    }



    public function trainers(): Builder|HasManyThrough
    {
        return $this->hasManyThrough(Trainer::class, ModelHasUser::class,'model_id','id','id','user_id')
            ->where(
                [ 'model_type' => Of::class]
            )->whereHas('roles', function ($query) {
                $query->whereIn('name', ['trainer']);
            });
    }

    public function courses(): HasMany
    {
        return $this->HasMany(Course::class, 'of_id', 'id');
    }


}
