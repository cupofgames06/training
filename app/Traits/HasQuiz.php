<?php

namespace App\Traits;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasQuiz
{

    public function quizzes(): MorphToMany
    {
        return $this->morphToMany(Quiz::class, 'quizzesable', 'quizzesables');
    }

    public function getPreRequisiteQuiz()
    {
        return $this->getQuiz('pre_requisite');
    }

    public function getEvaluationQuiz()
    {
        return $this->getQuiz('evaluation');
    }

    public function getModuleQuiz()
    {
        return $this->getQuiz('module');
    }

    public function getQuiz($type)
    {

        $quiz = $this->quizzes()->where('type', $type)->first();
        if (empty($quiz)) {
            $quiz = $this->quizzes()->create(['type' => $type]);
            $version = $quiz->versions()->create(['version' => 1]);
            $version->pages()->create(['name' => trans('of.quiz.first_page')]);
        }

        return $quiz;
    }
}
