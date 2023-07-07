<?php

namespace App\Models;

use App\Casts\Status;
use App\Core\Traits\SpatieLogsActivity;
use App\Traits\HasAccessRule;
use App\Traits\HasEnrollment;
use App\Traits\HasIntraTraining;
use App\Traits\HasPrice;
use App\Traits\HasQuiz;
use App\Traits\HasSession;
use App\Traits\HasSupport;
use App\Traits\IsOffer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Tags\HasTags;

class Course extends Model
{
    use HasFactory;
    use IsOffer;
    use HasEnrollment;
    use SpatieLogsActivity;
    use HasQuiz;
    use HasIntraTraining;
    use HasPrice;
    use HasSupport;
    use HasTags;
    use HasSession;
    use HasAccessRule;


    public const STATUS = array(
        Status::ACTIVE,
        Status::INACTIVE,
        Status::DELETED
    );

    public const COURSE_TYPE = array(
        'elearning',
        'virtual',
        'physical'
    );

    protected $table = 'courses';

    protected $fillable = [
        'of_id',
        'type',
        'duration',
        'status'
    ];

    public function packables()
    {
        return $this->morphMany(Packable::class,'packable');
    }



    public function of(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Of::class);
    }
    public function title()
    {
        return $this->description->reference.' - '.$this->description->name;
    }

    public function indicators(): BelongsToMany
    {
        return $this->belongsToMany(Indicator::class, 'course_indicator')->withPivot('value');
    }

    static function getList($exclude = [], $type = null): array
    {
        $return = [];
        $query = Course::where('status','!=', 'deleted')->with('description')->whereNotIn('id', $exclude);
        if (!empty($type)) {
            $type = is_array($type) ? $type : [$type];
            $query->whereIn('type', $type);
        }
        $query->get()->sortBy('description.reference')->map(function ($item, $index) use (&$return) {
            $return[$item->id] = $item->description->reference . ' - ' . $item->description->name;
        });

        return $return;
    }

    static function getTypeList(): array
    {
        $r = [];
        foreach (self::COURSE_TYPE as $c) {
            $r[$c] = custom('course-type.' . $c)['name'];
        }

        return $r;
    }

    public function getTimeDurationAttribute(): string
    {

        $created = \Carbon\Carbon::createFromTimeStamp($this->duration * 60);

        return $created->format('H:i');
    }


}
