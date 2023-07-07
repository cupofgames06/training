<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 * 
 * @property int $id
 * @property int $actionnable_id
 * @property int $actionnable_type
 * @property array|null $cancel_conditions
 * @property array|null $required_conditions
 * @property array|null $remove_conditions
 * @property array|null $new_conditions
 * @property int|null $required_money_amount
 *
 * @package App\Models
 */
class Action extends Model
{
	protected $table = 'actions';
	public $timestamps = false;

	protected $casts = [
		'actionnable_id' => 'int',
		'actionnable_type' => 'int',
		'cancel_conditions' => 'json',
		'required_conditions' => 'json',
		'remove_conditions' => 'json',
		'new_conditions' => 'json',
		'required_money_amount' => 'int'
	];

	protected $fillable = [
		'actionnable_id',
		'actionnable_type',
		'cancel_conditions',
		'required_conditions',
		'remove_conditions',
		'new_conditions',
		'required_money_amount'
	];
}
