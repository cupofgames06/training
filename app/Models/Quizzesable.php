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
class Quizzesable extends Model
{
    protected $table = 'quizzesables';

    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'quizzesable_id'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }


}
