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
 *
 * @package App\Models
 */
class ModelHasPromotion extends Model
{
    protected $table = 'model_has_promotions';

    public $timestamps = false;

    protected $fillable = [
        'model_id',
        'promotion_id'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }


}
