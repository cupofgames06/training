<div class="row">
    <div class="col mb-3 pb-3">
        <div class="form-group">
            <x-form-label class="form-label" label="Image illustrative"></x-form-label>
            @component('components.form.file-upload')
                @slot('id','module_image_'.$module->id)
                @slot('url',  route('of.quizzes.store_image',[$module->id] ))
                @slot('text',trans('of.quiz.image.text'))
                @slot('accepted_files',['png','jpg','jpeg'])
                @slot('module',$module)
                @slot('file', $module->getFirstMedia('image') )
            @endcomponent
        </div>
    </div>
</div>
