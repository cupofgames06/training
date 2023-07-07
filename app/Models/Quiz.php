<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Quiz extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'quizzes';

    public const QUIZ_TYPE = array(
        'pre_requisite',
        'evaluation',
        'module'
    );

    protected $fillable = [
        'type',
        //'name',
        //'description'
    ];

    public array $translatable = ['name', 'description'];

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'quizzesable', 'quizzesables', 'quiz_id', 'id');
    }
    public function packs(): MorphToMany
    {
        return $this->morphedByMany(Pack::class, 'quizzesable', 'quizzesables', 'quiz_id', 'id');
    }

    public function quizzesable(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Quizzesable::class);
    }

    public function versions()
    {
        return $this->hasMany(QuizVersion::class);
    }

    public function getEditorVersionList()
    {
        $this->versions->sortBy('version')->map(function ($item) use(&$list){
            $list[$item->getEditorUrl()] = trans('common.version').' '.$item->version;
        });

        return $list;
    }

    public function getPreviewPageUrl($page_id): mixed
    {
        return route('quiz.show', [$page_id, 'preview' => request()->url()]);
    }

}
