<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Class QuizPage
 *
 * @property int $id
 * @property int $quiz_version_id
 * @property int $position
 *
 * @property QuizVersion $quiz_version
 * @property Collection|QuizModule[] $quiz_modules
 *
 * @package App\Models
 */
class QuizPage extends Model
{
    use HasTranslations;

    protected $table = 'quiz_pages';

    protected $casts = [
        'version_id' => 'int',
        'position' => 'int'
    ];

    protected $fillable = [
        'version_id',
        'position',
        'name'
    ];

    public $translatable = ['name'];


    public function version()
    {
        return $this->belongsTo(QuizVersion::class, 'version_id', 'id');
    }

    public function modules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuizModule::class, 'page_id');
    }

    public function getEditorUrl()
    {
        $params = array_replace(request()->route()->parameters, ['version' => $this->quiz_version_id, 'page' => $this->id]);
        $params['version'] = $this->version->id;

        return route(request()->route()->getName(), $params);

    }

}
