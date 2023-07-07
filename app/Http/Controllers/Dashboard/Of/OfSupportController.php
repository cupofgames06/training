<?php

namespace App\Http\Controllers\Dashboard\Of;

use App\Core\DataTableAPI;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Of\Traits\IntraTrainings;
use App\Http\Controllers\Dashboard\Of\Traits\Quizzes;
use App\Http\Controllers\Dashboard\Of\Traits\Supports;
use App\Http\Controllers\Dashboard\OfController;
use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\PriceRequest;
use App\Http\Requests\SupportRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\ModelAccessRule;
use App\Models\QuizVersion;
use App\Models\Support;
use App\View\Components\DataTable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Tags\Tag;

class OfSupportController extends OfController
{
    public function upload_document()
    {
        $name = !empty(request()->get('id')) ? 'support_document_' . request()->get('id') : 'support_document';
        if (request()->hasFile($name) && request()->file($name)->isValid()) {
            $user = Auth::user();
            $user->clearMediaCollection('tmp');
            $user->addMediaFromRequest($name)->usingName($name)->toMediaCollection('tmp');
        }
    }

    public function store(SupportRequest $request, $locale, $item_type, $item_id): JsonResponse
    {
        $datas = $request->except('_token', '_method');

        $model = "App\Models\\" . ucfirst($item_type);
        $model = new $model;

        $item = $model::find($item_id);

        $tmp = Auth::user()->getMedia('tmp')->where('name', 'support_document')->first();
        if (empty($tmp)) {
            return response()->json(['alert' => 'Vous n\'avez téléchargé aucun document'])->setStatusCode(422);
        }

        $datas['support']['supportable_id'] = $item->id;
        $datas['support']['supportable_type'] = $item::class;

        $support = $item->supports()->create($datas['support']);
        $support->copyMedia($tmp->getPath())->usingName($support->name)->toMediaCollection('documents');
        Auth::user()->clearMediaCollection('tmp');

        return response()->json(['reload' => true, 'success' => 'Création effectuée']);
    }

    public function update(SupportRequest $request, $locale, $support_id)
    {
        $datas = $request->except('_token', '_method');

        $item = Support::find($support_id);
        if (!empty($datas['support'])) {
            $item->update($datas['support']);
        }

        if (!empty($datas['delete']['support_document_' . $support_id])) {
            $item->clearMediaCollection('documents');
        } else {
            //Vérif upload image, suppression tmp le cas échéant
            $tmp = Auth::user()->getMedia('tmp')->where('name', 'support_document_' . $support_id)->first();
            if (!empty($tmp)) {
                $item->clearMediaCollection('documents');
                $item->copyMedia($tmp->getPath())->toMediaCollection('documents');
            }
        }

        Auth::user()->clearMediaCollection('tmp');

        return response()->json(['reload' => true,'success' => 'Mise à jour effectuée']);
    }

    public function delete($locale, $support_id): JsonResponse
    {
        $support = Support::find($support_id);
        $support->clearMediaCollection('documents');
        $support->delete();

        return response()->json(['reload' => true,  'success' => 'Suppression effectuée']);
    }

}
