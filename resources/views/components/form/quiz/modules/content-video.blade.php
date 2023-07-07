<div class="row">
    <div class="col mb-3 pb-3" data-type="quiz-video">
        <x-form.translated-textfield label="url Youtube" id="module-text--{{ $module->id }}" name="module[{{$module->id}}][content][text]"
                                    data-body-class="tiny-mce-text"
                                    :values="!empty($module->content['text'])?$module->content['text']:[]" :module="true">
        </x-form.translated-textfield>
    </div>
</div>
