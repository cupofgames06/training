<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * 
 * @property int $id
 * @property string $reference
 * @property int|null $closeup_id
 * @property int|null $money
 * @property bool $revealable
 * @property bool $readable
 * @property bool $takable
 * @property bool $examinable
 * @property bool $crypted
 * @property array|null $use_with
 * @property bool $active
 * @property array|null $readable_content
 * 
 * @property Closeup|null $closeup
 * @property Collection|ItemLabel[] $item_labels
 *
 * @package App\Models
 */
class Item extends Model
{
	protected $table = 'items';
	public $timestamps = false;

	protected $casts = [
		'closeup_id' => 'int',
		'money' => 'int',
		'revealable' => 'bool',
		'readable' => 'bool',
		'takable' => 'bool',
		'examinable' => 'bool',
		'crypted' => 'bool',
		'use_with' => 'json',
		'active' => 'bool',
		'readable_content' => 'json'
	];

	protected $fillable = [
		'reference',
		'closeup_id',
		'money',
		'revealable',
		'readable',
		'takable',
		'examinable',
		'crypted',
		'use_with',
		'active',
		'readable_content'
	];

	public function closeup()
	{
		return $this->belongsTo(Closeup::class);
	}

	public function item_labels()
	{
		return $this->hasMany(ItemLabel::class);
	}
}
