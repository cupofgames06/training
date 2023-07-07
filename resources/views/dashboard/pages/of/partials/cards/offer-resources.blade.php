<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-images text-primary"></i>
        {{ __('of.courses.resources.title') }}</div>
    <div class="card-body">
        <div class="text-muted mb-4">{{ __('of.courses.resources.sub_title') }}</div>
        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <x-form-label class="form-label"
                                  label="Image illustrative"></x-form-label>
                    @component('components.form.file-upload')
                        @slot('id','offer_image')
                        @slot('url',  $url )
                        @slot('text',trans('of.courses.resources.text'))
                        @slot('accepted_files',['png','jpg','jpeg'])
                        @slot('file', !empty($description)?$description->getFirstMedia('image'):null )
                    @endcomponent
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3 pb-3">
                <x-form.text-field label="{{ __('course.video') }}" :value="!empty($description)?$description->video:''"
                                   name="description[video]">
                </x-form.text-field>
            </div>
        </div>
    </div>
</div>
