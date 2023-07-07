<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Pack;
use App\Models\Quiz;
use App\Models\QuizPage;
use App\Models\QuizVersion;
use App\Models\Session;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function start($locale, $quiz_id)
    {

    }

    public function show($locale, $page_id)
    {
        $preview = [];
        if (!empty(request()->get('preview'))) {
            $preview['editor_url'] = request()->get('preview');
        }

        $page = QuizPage::find($page_id);
        $quiz = $page->quiz;
        $version = $page->version;

        return view('quiz.pages.show', compact('quiz', 'version', 'page','preview'));
    }

    public function finish($locale, $quiz_version_id)
    {

    }

}
