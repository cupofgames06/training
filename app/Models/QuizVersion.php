<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuizVersion
 *
 * @property int $id
 * @property int $quiz_id
 * @property bool $b_online
 *
 * @property Quiz $quiz
 * @property Collection|ModuleProgress[] $module_progresses
 * @property Collection|QuizPage[] $quiz_pages
 *
 * @package App\Models
 */
class QuizVersion extends Model
{
    protected $table = 'quiz_versions';
    public $timestamps = false;

    protected $casts = [
        'quiz_id' => 'int',
        'online' => 'bool'
    ];

    protected $fillable = [
        'quiz_id',
        'version',
        'online'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function pages()
    {
        return $this->hasMany(QuizPage::class, 'version_id', 'id');
    }

    public function getEditorPageList()
    {
        $this->pages->sortBy('position')->map(function ($item) use (&$list) {
            $list[$item->getEditorUrl()] = $item->name;
        });

        return $list;
    }

    public function getEditorUrl()
    {
        $params = array_replace(request()->route()->parameters, ['version' => $this->id]);
        unset($params['page']);
        return route(request()->route()->getName(), $params);
    }
}
