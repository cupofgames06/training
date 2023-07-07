<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CompanyActivityLog extends Model
{
    use HasFactory;

    protected $table = 'company_activity_logs';

    protected $fillable = [
        'company_id',
        'properties'
    ];

    public function loggable()
    {
        return $this->morphTo();
    }
    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }
}
