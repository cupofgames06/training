<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CompanyUser
 *
 * @property int $company_id
 * @property int $user_id
 *
 * @property Company $company
 * @property User $user
 *
 * @package App\Models
 */
class CompanyUser extends Model
{
	protected $table = 'company_user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'company_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'user_id'
	];

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}
