<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Class SessionDay
 *
 * @property int $id
 * @property int $session_id
 * @property Carbon $date
 * @property Carbon $am_start
 * @property Carbon $am_end
 * @property Carbon $pm_start
 * @property Carbon $pm_end
 * @property array $t_description
 *
 * @property Session $session
 *
 * @package App\Models
 */
class SessionDay extends Model
{
    use HasTranslations;
    use HasFactory;

    protected $table = 'session_days';
    public $timestamps = false;

    protected $casts = [
        'session_id' => 'int',
        'description' => 'json'
    ];

    protected $fillable = [
        'session_id',
        'date',
        'am_start',
        'am_end',
        'pm_start',
        'pm_end',
        'description'
    ];

    public $translatable = ['description'];


    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function getCalendarDateAttribute($value): string
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }

    public function getStartAttribute($value): string
    {
        return !empty($this->am_start)?Carbon::parse($this->am_start)->format('H:i'):(!empty($this->pm_start)?Carbon::parse($this->pm_start)->format('H:i'):'-');
    }

    public function getEndAttribute($value): string
    {
        return !empty($this->pm_end)?Carbon::parse($this->pm_end)->format('H:i'):(!empty($this->am_end)?Carbon::parse($this->am_end)->format('H:i'):'-');
    }
}
