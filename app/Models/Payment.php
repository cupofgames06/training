<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $mandate_id
 * @property int $invoice_number
 * @property float $amount
 * @property string $status
 * @property Carbon $d_due
 * @property Carbon $d_paid
 * 
 * @property Mandate $mandate
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';
	public $timestamps = false;

	protected $casts = [
		'mandate_id' => 'int',
		'invoice_number' => 'int',
		'amount' => 'float'
	];

	protected $dates = [
		'd_due',
		'd_paid'
	];

	protected $fillable = [
		'mandate_id',
		'invoice_number',
		'amount',
		'status',
		'd_due',
		'd_paid'
	];

	public function mandate()
	{
		return $this->belongsTo(Mandate::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
