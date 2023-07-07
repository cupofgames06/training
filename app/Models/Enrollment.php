<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Enrollment extends Model
{
    use HasFactory;

	protected $table = 'enrollments';

    public const STATUS = array(
        Status::REQUESTED,
        Status::ACTIVE,
        Status::CANCELLED,
        Status::DELETED
    );

    public function enrollmentable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'enrollmentable_type', 'enrollmentable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * User qui a fait l'inscription
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    public function pack() : BelongsTo
    {
        return $this->belongsTo(Pack::class,'pack_id');
    }
}
