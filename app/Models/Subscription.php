<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 *
 * @property int $id
 * @property int $mandate_id
 * @property Carbon $d_first
 * @property Carbon $d_start
 * @property Carbon $d_end
 * @property Carbon|null $d_cancel
 *
 * @property Mandate $mandate
 * @property Collection|Company[] $companies
 * @property Collection|Of[] $ofs
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscriptions';

	protected $casts = [
		'mandate_id' => 'int'
	];

	protected $dates = [
		'date_first',
		'date_start',
		'date_end',
		'date_cancel'
	];

	protected $fillable = [
		'mandate_id',
		'date_first',
		'date_start',
		'date_end',
		'date_cancel'
	];

	public function mandate()
	{
		return $this->belongsTo(Mandate::class);
	}

	public function company()
	{
		return $this->hasOne(Company::class);
	}

	public function ofs()
	{
		return $this->hasMany(Of::class);
	}
}
