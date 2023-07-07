<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyCategory
 * 
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * 
 * @property Category $category
 * @property Company $company
 *
 * @package App\Models
 */
class CompanyCategory extends Model
{
	protected $table = 'company_category';
	public $timestamps = false;

	protected $casts = [
		'company_id' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'company_id',
		'category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
