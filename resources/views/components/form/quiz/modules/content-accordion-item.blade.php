<div class="mb-3">
    <div class="row">
        <div class="col mb-3">
            <x-form.translated-textfield label="Titre {{ $position+1 }}"
                                         id="module-accordion-title-{{ $module->id }}-{{ $position }}"
                                         name="module[{{$module->id}}][content][items][{{ $position }}][title]"
                                         :values="!empty($item['title'])?$item['title']:[]"
                                         :module="true">
            </x-form.translated-textfield>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <x-form.translated-textarea label="Contenu {{ $position+1 }}"
                                        id="module-accordion-text-{{ $module->id }}-{{ $position }}"
                                        name="module[{{$module->id}}][content][items][{{ $position }}][text]"
                                        :values="!empty($item['text'])?$item['text']:[]"
                                        :module="true">
            </x-form.translated-textarea>
        </div>
    </div>
    <hr class="border-muted my-5">
</div>



