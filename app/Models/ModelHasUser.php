<?php



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
class ModelHasUser extends Model
{
    protected $table = 'model_has_users';

    public $timestamps = false;

    protected $fillable = [
        'model_id',
        'user_id'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
