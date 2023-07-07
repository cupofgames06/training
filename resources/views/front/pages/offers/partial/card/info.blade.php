<div class="card mb-4">
    <div class="card-header">
        {{ __('front.courses.show.info_title') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Type</div>
                <div>
                    @lang('custom/'.get_domain().'.course.type.'.$course->type.'.description')
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Pré-requis</div>
                <div>
                    {!! $course->description->pre_requisite !!}
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Public</div>
                {!! $course->description->public !!}
            </div>
        </div>
    </div>
</div>
