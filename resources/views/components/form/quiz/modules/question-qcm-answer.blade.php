<div class="d-flex justify-content-between mb-3">
    <div class="flex-grow-1">
        <x-form.translated-textfield label="Réponse {{ $position+1 }}"
                                     id="module-answer-{{ $module->id }}-{{ $position }}"
                                     name="module[{{$module->id}}][content][answers][{{ $position }}][text]"
                                     :values="!empty($answer['text'])?$answer['text']:[]"
                                     :is_module="true">
        </x-form.translated-textfield>
    </div>

    <div class="d-flex justify-content-between align-self-end px-4">
        <input type="checkbox" class="btn-check"
               name="module[{{$module->id}}][content][answers][{{ $position }}][correct]" value="1"
               @if(!empty($answer['correct']))
                   checked
               @endif
               id="module-answer-correct-{{ $module->id }}-{{ $position }}" autocomplete="off">
        <label class="btn btn-round btn-outline-success d-flex justify-content-center align-items-center opacity-75"
               for="module-answer-correct-{{ $module->id }}-{{ $position }}"><i
                class="rounded-circle far fa-lg fa-check"></i></label>
    </div>

    <div class="d-flex justify-content-between align-self-end">
        <button data-type="delete" data-url="{{ route('of.quizzes.delete_qcm_answer',[$module->id,$position]) }}" type="button" class="btn btn-round btn-outline-danger"><i class="rounded-circle far fa-close fa-lg"></i>
        </button>
    </div>
</div>



