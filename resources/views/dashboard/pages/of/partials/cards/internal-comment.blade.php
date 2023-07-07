<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
        {{ __('of.courses.internal_comment.title') }}</div>
    <div class="card-body">
        <div class="text-muted mb-4">{{ __('of.courses.internal_comment.sub_title') }}</div>
        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <x-form-label class="form-label"
                                  label="{{ __('course.internal_comment') }}"></x-form-label>
                    <x-form-textarea id="description_internal_comment"
                                     name="description[internal_comment]"
                                     :default="!empty($description)?$description->internal_comment:''"></x-form-textarea>
                </div>
            </div>
        </div>
    </div>
</div>
