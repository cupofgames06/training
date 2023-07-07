<div class="card mb-4 access-rule">
    <div class="card-header">
        @empty($name)
            <i class="icon far fa-shield-halved text-primary"></i>
            {{ __('of.courses.access_rules.title') }}
        @else
            {{ $name }}
        @endempty

            @if(!empty($access_rule))

                <div class="float-end">
                    <a href="#"
                       data-type="delete"
                       data-method="delete"
                       data-url="{{ route('of.access-rules.delete',[$access_rule->id]) }}"
                       class="delete fas fa-close text-decoration-none" id="{{ $access_rule->id }}">
                    </a>
                </div>

            @endif
    </div>
    <div class="card-body">
        @if(empty($access_rule))
            <div class="text-muted mb-4">{!! __('of.courses.access_rules.sub_title') !!}</div>
        @endif
        <label class="form-label w-100" for="course_intra">
            {{ __('of.courses.access_rules.required_courses') }}
        </label>
        <x-form-select
            name="access_rules[rule][required_courses][]"
            :options="\App\Models\Course::getList([$item::class == 'App\Models\Course'?$item->id:''])"
            multiple="true"
            :default="!empty($access_rule) && !empty($access_rule->rule['required_courses'])?$access_rule->rule['required_courses']:null"
            class="form-control" data-type="select2"/>

        <div class="text-muted my-4">{{ __('of.courses.access_rules.indicators_sub_title') }}</div>
        <div class="row">
            @foreach(\App\Models\Indicator::get() as $indicator)
                <div
                    class="{{ \App\Models\Indicator::count() == 1?'col':'col-lg-6 col-md-12' }} mb-3 pb-3">
                    <x-form.text-field type="number"
                                       label="{{  trans('common.min').' '. $indicator->getTranslation('name', app()->getLocale()).' ('.$indicator->unit.')' }}"
                                       name="access_rules[rule][indicators][{{ $indicator->id }}]"
                                       value="{{ !empty($access_rule)?$access_rule->rule['indicators'][$indicator->id]:null }}"
                                       min="0"
                                       max="{{ $indicator->objective }}">
                    </x-form.text-field>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-footer">
        @if(empty($access_rule))
            <div class="float-end">
                <x-form-submit id="create_rule" ajax="1">{{ __('of.courses.access_rules.btn') }}
                </x-form-submit>
            </div>
        @else
            <div class="float-end">
                <x-form-submit id="update_rule{{ $access_rule->id }}" ajax="1">{{ __('common.update') }}
                </x-form-submit>
            </div>
        @endif
    </div>
</div>
