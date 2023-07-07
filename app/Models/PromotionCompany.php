<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PromotionCompany
 * 
 * @property int $promotion_id
 * @property int $company_id
 * 
 * @property Company $company
 * @property Promotion $promotion
 *
 * @package App\Models
 */
class PromotionCompany extends Model
{
	protected $table = 'promotion_company';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'promotion_id' => 'int',
		'company_id' => 'int'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function promotion()
	{
		return $this->belongsTo(Promotion::class);
	}
}
