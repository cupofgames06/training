<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mandate
 *
 * @property int $id
 * @property int $number
 *
 * @property Collection|Company[] $companies
 * @property Collection|Of[] $ofs
 * @property Collection|Payment[] $payments
 * @property Collection|Subscription[] $subscriptions
 *
 * @package App\Models
 */
class Mandate extends Model
{
	protected $table = 'mandates';
	public $timestamps = false;

	protected $casts = [
		'number' => 'int'
	];

	protected $fillable = [
		'number'
	];

	public function company()
	{
		return $this->hasOne(Company::class);
	}

	public function ofs()
	{
		return $this->hasMany(Of::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
