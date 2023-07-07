<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property Carbon|null $birth_date
 * @property string|null $birth_zipcode
 * @property int|null $birth_country_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 * @property Collection|Company[] $companies
 * @property Collection|Of[] $ofs
 *
 * @package App\Models
 */
class Profile extends Model
{
    protected $table = 'profiles';

    protected $dates = [
        'birth_date'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'last_name',
        'phone_1',
        'phone_2',
        'birth_date',
        'birth_zipcode',
        'birth_country_id',
        'full_name'
    ];

    public function setBirthDateAttribute($value)
    {
        if (is_string($value)) {
            if (strpos($value, '/') !== false) {
                $this->attributes['birth_date'] = Carbon::createFromFormat(custom('date_format'), $value);
            }
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'birth_country_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => ucfirst($this->last_name) . ' ' . ucfirst($this->first_name) ,
        );
    }

    protected function badgeLetter(): Attribute
    {
        return Attribute::make(
            get: fn() => str($this->last_name)->substr(0, 1),
        );
    }
}
