<div class="row">
    <div class="col mb-3 pb-3">
        <x-form.translated-textarea label="contenu" id="module-text--{{ $module->id }}" name="module[{{$module->id}}][content][text]"
                                    data-body-class="tiny-mce-text"
                                    :values="!empty($module->content['text'])?$module->content['text']:[]" :module="true">
        </x-form.translated-textarea>
    </div>
</div>

