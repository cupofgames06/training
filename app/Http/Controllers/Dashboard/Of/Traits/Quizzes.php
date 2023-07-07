<?php

namespace App\Http\Controllers\Dashboard\Of\Traits;

use App\Models\Quiz;
use App\Models\QuizModule;
use App\Models\QuizPage;
use App\Models\QuizVersion;
use App\View\Components\Form\Quiz\Accordion;
use App\View\Components\Form\Quiz\AccordionItem;
use App\View\Components\Form\Quiz\BaseModule;
use App\View\Components\Form\Quiz\QcmAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

trait Quizzes
{
    public function load_quiz($page_id, $breadcrumbs, $tab_nav, $title = "", $subtitle = "")
    {
        $page = QuizPage::find($page_id);
        $version = $page->version;
        $quiz = $version->quiz;

        return response()->view('dashboard.pages.of.quizzes', [
            'title' => $title,
            'subtitle' => $subtitle,
            'quiz' => $quiz,
            'version' => $version,
            'page' => $page,
            'breadcrumbs' => $breadcrumbs,
            'tab_nav' => $tab_nav
        ]);
    }

    public function store_module()
    {
        $datas = request()->except('_token', '_method');
        $page = QuizPage::find($datas['page_id']);
        $datas['name'] = 'Module ' . $page->modules()->count() + 1;
        $page->modules()->where('position', '>=', $datas['position'])->update(['position' => DB::raw('position+1')]);
        $module = $page->modules()->create($datas);
        $template = new BaseModule($module);

        return response()->json(['template' => $template->html(), 'success' => 'Création effectuée']);
    }

    public function update_module(): JsonResponse
    {
        $datas = request()->except('_token', '_method');
        $module = QuizModule::find($datas['module_id']);
        unset($datas['module_id']);
        $datas = array_pop($datas['module']);
        if (!empty($datas)) {
            $module->update($datas);
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function store_qcm_answer($locale, $module_id)
    {
        $module = QuizModule::find($module_id);
        $content = $module->content;
        $answers = !empty($content['answers']) ? $content['answers'] : [];
        $answers[] = '';
        $content['answers'] = $answers;
        $module->content = $content;
        $module->save();
        $template = new QcmAnswer($module, count($answers) - 1);
        return response()->json(['template' => $template->html(), 'success' => 'Création effectuée']);
    }

    public function delete_qcm_answer($locale, $module_id, $position)
    {
        $module = QuizModule::find($module_id);
        $content = $module->content;
        $answers = !empty($content['answers']) ? $content['answers'] : [];

        for ($i = 0; $i < count($answers); $i++) {
            if ($i == $position) {
                unset($answers[$i]);
            }
        }

        $content['answers'] = $answers;
        $module->content = $content;
        $module->save();
        $template = new QcmAnswer($module, count($answers));
        return response()->json(['template' => $template->html(), 'success' => 'Suppression effectuée']);
    }

    public function store_accordion_item($locale, $module_id): JsonResponse
    {
        $module = QuizModule::find($module_id);
        $content = $module->content;
        $content['items'][] = ['title' => '', 'text' => ''];
        $module->content = $content;
        $module->save();
        $template = new AccordionItem($module, count($content['items']) - 1);
        return response()->json(['template' => $template->html(), 'success' => 'Création effectuée']);
    }

    public function delete_accordion_item($locale, $module_id, $position): JsonResponse
    {
        $module = QuizModule::find($module_id);
        $content = $module->content;
        for ($i = 0; $i < count($content['items']); $i++) {
            if ($i == $position) {
                unset($content['items'][$i]);
            }
        }
        $module->content = $content;
        $module->save();
        $template = new AccordionItem($module, count($content['items']));

        return response()->json(['template' => $template->html(), 'success' => 'Suppression effectuée']);
    }

    public function store_image($locale, $module_id)
    {
        $name = 'module_image_' . $module_id;
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $module = QuizModule::find($module_id);
            $module->clearMediaCollection('image');
            $module->addMediaFromRequest($name)->usingName($name)->toMediaCollection('image');
        }
    }

    public function delete_image($locale, $module_id)
    {
        $module = QuizModule::find($module_id);
        $module->clearMediaCollection('image');
    }

    public function update_modules_position(): void
    {
        $datas = request()->except('_token', '_method');
        $positions = $datas['position'];
        foreach ($positions as $v) {
            QuizModule::where('id', $v['id'])->update(['position' => $v['position']]);
        }

    }

    public function delete_module($locale, $module_id): JsonResponse
    {
        $module = QuizModule::find($module_id);
        $pos = $module->position;
        $module->delete();

        $module->page->modules()
            ->where('position', '>', $pos)
            ->update(['position' => DB::raw('position-1')]);

        return response()->json(['success' => 'Suppression effectuée']);
    }

    public function store_page($locale, $version_id): JsonResponse
    {
        //todo : order/auto rank
        //todo : page_id, et position au sein de la page
        $version = QuizVersion::find($version_id);
        $datas['position'] = $version->pages()->count();
        $datas['name'] = 'Page  ' . $datas['position'] + 1;
        $page = $version->pages()->create($datas);

        $quiz = $version->quiz;
        $type = $quiz->quizzesable->quizzesable_type == 'App\Models\Course' ? 'course' : 'pack';
        $url = 'of.' . $type . 's.' . $quiz->type . '_quiz';
        $redirect = route($url, ['course' => $quiz->quizzesable->quizzesable_id, 'version' => $version, 'page' => $page]);

        return response()->json(['id' => $page->id, 'success' => 'Création effectuée', 'redirect' => $redirect]);
    }

    public function update_page($page_id): JsonResponse
    {
        $datas = request()->except('_token', '_method');
        $page = QuizPage::find($page_id);
        $page->update($datas);

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    //Suppression page
    public function delete_page($locale, $page_id): JsonResponse
    {

        $page = QuizPage::find($page_id);
        $version = $page->version;
        $quiz = $version->quiz;

        QuizPage::where('id', $page_id)->delete();

        $version->pages()
            ->where('position', '>', $page->position)
            ->update(['position' => DB::raw('position-1')]);

        $pos = $page->position == 0 ? $pos = 0 : $page->position - 1;
        $redirect_page = QuizPage::where(['version_id' => $version->id, 'position' => $pos])->first();

        $type = $quiz->quizzesable->quizzesable_type == 'App\Models\Course' ? 'course' : 'pack';
        $url = 'of.' . $type . 's.' . $quiz->type . '_quiz';
        $redirect = route($url, ['course' => $quiz->quizzesable->quizzesable_id, 'version' => $version, 'page' => $redirect_page]);

        return response()->json(['redirect' => $redirect, 'success' => 'Suppression effectuée']);
    }

    public function store_version($locale, $quiz_id): JsonResponse
    {
        $quiz = Quiz::find($quiz_id);
        $datas['version'] = $quiz->versions->sortByDesc('version')->first()->version + 1;
        $version = $quiz->versions()->create($datas);
        $page = $this->store_page($locale, $version->id);
        $page = json_decode($page->content(), true);

        $type = $quiz->quizzesable->quizzesable_type == 'App\Models\Course' ? 'course' : 'pack';
        $url = 'of.' . $type . 's.' . $quiz->type . '_quiz';
        $redirect = route($url, ['course' => $quiz->quizzesable->quizzesable_id, 'version' => $version, 'page' => $page['id']]);

        return response()->json(['redirect' => $redirect, 'success' => 'Création effectuée']);

    }

    public function copy_version($locale, $version_id): JsonResponse
    {
        $version = QuizVersion::find($version_id);
        $new_version = $version->replicate();
        $new_version->version = $version->quiz->versions->sortByDesc('version')->first()->version + 1;
        $new_version->save();

        foreach ($version->pages as $page) {
            $new_page = $page->replicate();
            $new_page->version_id = $new_version->id;
            $new_page = $new_version->pages()->create($new_page->toArray());
            foreach ($page->modules as $module) {
                $new_module = $module->replicate();
                $new_module->page_id = $new_page->id;
                $new_page->modules()->create($new_module->toArray());
            }
        }

        $quiz = $version->quiz;
        $type = $quiz->quizzesable->quizzesable_type == 'App\Models\Course' ? 'course' : 'pack';
        $url = 'of.' . $type . 's.' . $quiz->type . '_quiz';
        $redirect = route($url, ['course' => $quiz->quizzesable->quizzesable_id, 'version' => $new_version, 'page' => $new_version->pages()->first()]);

        return response()->json(['redirect' => $redirect, 'title' => 'Duplication effectuée', 'id' => $new_version->id]);
    }

    public function update_version($version_id): JsonResponse
    {
        $datas = request()->except('_token', '_method');
        $version = QuizVersion::find($version_id);
        if (!empty($datas['version'])) {
            $version->update($datas['version']);
        }

        return response()->json(['success' => 'Mise à jour effectuée']);
    }

    public function delete_version($locale, $version_id): JsonResponse
    {
        $version = QuizVersion::find($version_id);
        $quiz = $version->quiz;

        QuizVersion::where('id', $version_id)->delete();

        $quiz->versions()
            ->where('version', '>', $version->version)
            ->update(['version' => DB::raw('version-1')]);

        $pos = $version->version == 0 ? $pos = 0 : $version->version - 1;
        $redirect_version = QuizVersion::where(['quiz_id' => $quiz->id, 'version' => $pos])->first();

        $type = $quiz->quizzesable->quizzesable_type == 'App\Models\Course' ? 'course' : 'pack';
        $url = 'of.' . $type . 's.' . $quiz->type . '_quiz';
        $redirect = route($url, ['course' => $quiz->quizzesable->quizzesable_id, 'version' => $redirect_version, 'page' => $redirect_version->pages()->first()]);

        return response()->json(['redirect' => $redirect, 'success' => 'Suppression effectuée']);
    }

    public function toggle_version_status($locale, $version_id, $status): JsonResponse
    {
        $version = QuizVersion::find($version_id);
        $version->update(['online'=>$status]);
        return response()->json(['reload' => true, 'success' => $status == 1?'Mise en ligne effectuée':'Retrait effectué']);
    }

}
