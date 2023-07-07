<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

class LearnerDescription extends Model
{
    use HasFactory;
    use HasTags;

    protected $table = 'learner_descriptions';

    public $timestamps = false;

    protected $fillable = [
        'learner_id','company_id','email','date_start','date_end','job_title','service',
    ];

    protected $dates = [
        'date_start',
        'date_end'
    ];

    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }
    public function setDateStartAttribute($value)
    {
        if (str_contains($value, '/')) {
            $this->attributes['date_start'] = Carbon::createFromFormat(custom('date_format'), $value);
        }
        else
        {
            $this->attributes['date_start'] = $value;
        }
    }
}
