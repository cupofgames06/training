@php($answers = !empty($module->content['answers'])?$module->content['answers']:[])
<div data-type="quiz-qcm">

    <div class="row">
        <div class="col mb-3 pb-3">
            <x-form.translated-textfield label="Votre question" id="module-text--{{ $module->id }}"
                                         name="module[{{$module->id}}][content][question]"
                                         :values="!empty($module->content['question'])?$module->content['question']:[]"
                                         :is_module="true">
            </x-form.translated-textfield>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-label align-items-baseline">

                @if(!empty($answers))
                    @foreach($answers as $a)
                        @component('components.form.quiz.modules.question-qcm-answer')
                            @slot('module',$module)
                            @slot('position',$loop->index)
                            @slot('answer',$a)
                        @endcomponent
                    @endforeach
                @endif

                <div class="d-flex">
                    <button type="button" data-url="{{ route('of.quizzes.store_qcm_answer',[$module->id]) }}"
                            data-type="add-qcm-answer" data-module="{{$module->id}}" id="addQcmAnswer{{$module->id}}"
                            class="btn btn-round btn-outline-secondary opacity-75"><i
                            class="rounded-circle far fa-lg fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
