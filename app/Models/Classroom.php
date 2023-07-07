<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Interfaces\HasAddress;
use App\Traits\InteractWithAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model implements HasAddress
{
    use HasFactory;
    use InteractWithAddress;
    use HasTranslations;

    protected $table = 'classrooms';

    protected $fillable = [
        'of_id',
        'name',
        'url',
        'max_learners',
        'pmr'
    ];

    public $translatable = ['name'];

    static function getList($exclude = [])
    {
        $return = [];
        Classroom::whereNotIn('id',$exclude)->get()->map(function ($item, $index) use (&$return) {
            $return[$item->id] = $item->name.' - '.$item->address->street_number.', '.$item->address->street_name.' - '.$item->address->postal_code.' '.$item->address->city.' - '.$item->max_learners.' places max';
        });

        return $return;
    }

}
