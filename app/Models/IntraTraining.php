<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class IntraTraining extends Model
{
    use HasFactory;
    use HasPrice;

    protected $table = 'intra_trainings';

    protected $casts = [
        'companies' => 'json'
    ];

    protected $fillable = [
        'companies',
        'trainable_type',
        'trainable_id'
    ];

}
