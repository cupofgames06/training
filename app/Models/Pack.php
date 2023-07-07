<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Casts\Status;
use App\Core\Traits\SpatieLogsActivity;
use App\Traits\HasEnrollment;
use App\Traits\HasIntraTraining;
use App\Traits\HasPrice;
use App\Traits\HasQuiz;
use App\Traits\HasSession;
use App\Traits\HasSupport;
use App\Traits\IsOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use mysql_xdevapi\Collection;

/**
 * Class Pack
 *
 * @property int $id
 * @property int $course_id
 * @property int $position
 *
 * @package App\Models
 */
class Pack extends Model
{
    use HasEnrollment;
    use IsOffer;
    use SpatieLogsActivity;
    use HasQuiz;
    use HasIntraTraining;
    use HasPrice;
    use HasSupport;
    use HasSession;

    protected $table = 'packs';

    public $timestamps = false;

    protected $casts = [
        'of_id' => 'int',
    ];

    protected $fillable = [
        'of_id',
        'type',
        'status'
    ];

    public const STATUS = array(
        Status::ACTIVE,
        Status::INACTIVE,
        Status::DELETED
    );

    public const PACK_TYPE = array(
        'pack',
        'blended'
    );

    public function packables(): HasMany
    {
        return $this->hasMany(Packable::class, 'pack_id');
    }

    static function getTypeList(): array
    {
        $r = [];
        foreach (self::PACK_TYPE as $c) {
            $r[$c] = custom('pack-type.' . $c)['name'];
        }

        return $r;
    }

    public function elearnings()
    {
        return $this->hasManyThrough(
            Course::class,
            Packable::class,
            'pack_id',
            'id',
            'id',
            'packable_id'
        )->where(
            'pack_id', $this->id
        )->where(
            'packable_type', Course::class
        );

    }

    public function sessions(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(
            Session::class,
            Packable::class,
            'pack_id',
            'id',
            'id',
            'packable_id'
        )->where(
            'pack_id', $this->id
        )->where(
            'packable_type', Session::class
        );

    }

}
