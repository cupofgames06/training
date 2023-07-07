<div class="card mb-4">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-comment text-primary"></i>
        {{ __('of.courses.promo_message.title') }}</div>
    <div class="card-body">
        <div class="text-muted mb-4">{!!  __('of.courses.promo_message.sub_title')  !!}</div>
        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <div class="row">
                        <div class="col mb-3 pb-3">
                            <x-form.translated-textarea label="{{ __('course.promo_message') }}"
                                                        name="description[promo_message]"
                                                        :values="!empty($description)?$description->getTranslations('promo_message'):[]">
                            </x-form.translated-textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
