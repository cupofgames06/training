<div class="row">
    <div class="col mb-3 pb-3">
        <x-form.translated-textarea data-css="http://[::1]:5173/resources/sass/kwu.scss" data-body-class="quote" label="contenu" id="module-text--{{ $module->id }}" name="module[{{$module->id}}][content][text]"
                                    :values="!empty($module->content['text'])?$module->content['text']:[]" :module="true">
        </x-form.translated-textarea>
    </div>
</div>

