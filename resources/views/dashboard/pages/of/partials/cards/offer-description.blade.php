<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp far fa-pen-alt text-primary"></i>
        {!!  __('of.courses.content.title')  !!}</div>
    <div class="card-body">
        <div class="row">
            <div class="col mb-3 pb-3">
                <x-form.translated-textfield label="{{ __('course.name') }}"
                                             name="description[name]"
                                             :id="!empty($description)?'name_'.$description->id:'description_name'"
                                             :values="!empty($description)?$description->getTranslations('name'):[]">
                </x-form.translated-textfield>
            </div>
        </div>
        @foreach(['objectives','program','public','pedago','eval','pre_requisite','equipment'] as $v)
            <div class="row">
                <div class="col mb-3 pb-3">
                    <x-form.translated-textarea label="{!!   __('course.'.$v) !!}" name="description[{{ $v }}]"
                                                :values="!empty($description)?$description->getTranslations($v):[]">
                    </x-form.translated-textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>
