<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;


use App\Casts\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Translatable\HasTranslations;

class Promotion extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'promotions';

    protected $dates = [
        'date_start',
        'date_end'
    ];

    public const STATUS = array(
        Status::ACTIVE,
        Status::INACTIVE,
        Status::DELETED
    );

    protected $casts = [
        'status' => Status::class
    ];

    protected $fillable = [
        'of_id',
        'code',
        'amount',
        'percent',
        'date_start',
        'date_end',
        'name',
        'status'
    ];

    public array $translatable = ['name'];

    public function of(): BelongsTo
    {
        return $this->belongsTo(Of::class);
    }

    public function promotables(): HasMany
    {
        return $this->hasMany(ModelHasPromotion::class);
    }

    public function companies(): Collection
    {
        return Company::whereHas('promotions', function ($query) {
            return $query->where('promotion_id', $this->id);
        })->get();
    }

    public function setCompanies($companies): void
    {
        $type = Company::class;

        ModelHasPromotion::where('model_type', $type)->where('promotion_id', $this->id)->delete();
        foreach ($companies as $id) {
            $m = new ModelHasPromotion();
            $m->model_type = Company::class;
            $m->model_id = $id;
            $this->promotables()->save($m);
        }
    }
}
