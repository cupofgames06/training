<div class="base-module draggable" data-module="{{$module->id}}">
    <div class="card mb-4" data-module="{{$module->id}}">
        <div class="card-header  align-items-baseline justify-content-between d-flex">
            <div class="float-start justify-content-start d-flex w-50 align-items-baseline">
                <i class="far {{ config('quiz.module.type.'.$module->type.'.'.$module->subtype.'.icon') }} {{ $module->type == 'question'?'text-primary':'text-secondary opacity-75' }} me-3"></i>
                <x-form.translated-inline-field label=""
                                                name="module[{{$module->id}}][name]"
                                                :id="'module-name-'.$module->id"
                                                :values="$module->getTranslations('name')">
                </x-form.translated-inline-field>
            </div>
            <div class="float-end d-flex align-items-baseline justify-content-end">

                @if($module->type == 'question' && $module->page->version->quiz->type != 'module')
                    <div class="form-check mb-0 me-3">
                        <label class="form-check-label fw-normal text-muted small" for="certificat_module[{{$module->id}}]">
                            inclus certif.
                        </label>
                        <input class="form-check-input" type="checkbox" value="" name="module[{{$module->id}}][content][certificate]" id="certificat_module[{{$module->id}}]">
                    </div>
                @endif
                <a href="#collapse{{ $module->id }}" type="button" class="pe-2 fas fa-chevron-up text-decoration-none"
                   data-bs-toggle="collapse"
                   data-bs-target="#collapse{{ $module->id }}"
                   aria-expanded="true" aria-controls="collapse{{ $module->id }}">
                </a>
                <a href="#" data-type="delete" data-title="Supprimer définitvement ce module?"
                   data-url="{{ route('of.quizzes.delete_module',['module'=>$module->id ]) }}"
                   class="fas fa-close text-decoration-none" id="{{ $module->id }}"></a>
            </div>
        </div>
        <div class="collapse show" id="collapse{{ $module->id }}">
            <div class="card-body">
                <form action="{{route('of.quizzes.update_module') }}" method="post" name="module[{{$module->id}}]"
                      id="form-module-{{$module->id}}">
                    @csrf
                    {!! $template !!}
                </form>
            </div>
        </div>
    </div>
</div>
