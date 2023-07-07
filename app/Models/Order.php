<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property int $id
 * @property int|null $promotion_id
 * @property int $user_id
 * @property int $payment_id
 * @property float $licence_amount
 * @property float $charge_amount
 * @property float $promo_amount
 * @property float $total_amount
 * @property string $status
 *
 * @property Payment $payment
 * @property Promotion|null $promotion
 * @property Collection|Enrollment[] $enrollments
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'promotion_id' => 'int',
		'user_id' => 'int',
		'payment_id' => 'int',
		'licence_amount' => 'float',
		'charge_amount' => 'float',
		'promo_amount' => 'float',
		'total_amount' => 'float'
	];

	protected $fillable = [
		'promotion_id',
		'user_id',
		'payment_id',
		'licence_amount',
		'charge_amount',
		'promo_amount',
		'total_amount',
		'status'
	];

	public function payment()
	{
		return $this->belongsTo(Payment::class);
	}

	public function promotion()
	{
		return $this->belongsTo(Promotion::class);
	}

	public function enrollments()
	{
		return $this->hasMany(Enrollment::class);
	}
}
