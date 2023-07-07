<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;


class Category extends Model
{
    use HasTranslations;

	protected $table = 'categories';

    protected $fillable = [
        'name',
        'type'
    ];

    public $translatable = ['name'];

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function hasParent() : bool
    {
        return $this->parent_id !== null;
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class,'category_id');
    }

    /**
     * Fonction qui retourne les catégories pour les formations
     * @param $query
     * @return mixed
     */
    public function scopeGetCourses($query): mixed
    {
        return $query->where('type', Course::class);
    }

    /**
     * Fonction qui retourne les catégories pour les quiz
     * @param $query
     * @return mixed
     */
    public function scopeGetQuizzes($query): mixed
    {
        return $query->where('type', Quiz::class);
    }

    /**
     * Fonction qui retourne les catégories pour les quiz
     * @param $query
     * @return mixed
     */
    public function scopeGetCompanies($query): mixed
    {
        return $query->where('type', Company::class);
    }

    static function getSelectList($type, $key = 'id', $value = 'name')
    {
        return self::get()->where('type', $type)->sortBy('name')->pluck($value, $key)->toArray();
    }
}
