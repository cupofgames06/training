<div class="card mb-4 intra-training">
    <div class="card-header">
        <i class="icon far fa-calendar-check text-primary"></i>
        @empty($day)
            {{ __('of.session_days.title') }}
        @else
            {{ $slot }}
            <div class="float-end">

                <a href="#collapse{{ $day->id }}" type="button" class="pe-2 fas fa-chevron-up text-decoration-none"
                   data-bs-toggle="collapse"
                   data-bs-target="#collapse{{ $day->id }}"
                   aria-expanded="true" aria-controls="collapse{{ $day->id }}">
                </a>

                <a href="#"
                   data-type="delete"
                   data-title="Supprimer cette journée?"
                   data-url="{{ route('of.sessions.delete_day',[$session->id,$day->id]) }}"
                   class="delete fas fa-close text-decoration-none" id="{{ $day->id }}">
                </a>
            </div>
        @endif
    </div>
    <div class="collapse show" id="collapse{{ !empty($day)?$day->id:'' }}">
        <div class="card-body">
            @empty($day)
                <div class="text-muted mb-4">{!! __('of.session_days.sub_title') !!}</div>
            @endempty

            <div class="row">
                <div class="col mb-3 pb-3">
                    <label for="birth_date" class="form-label">{{ __('of.session_days.date') }}</label>
                    <x-form-input :id="!empty($day)?'day_date_'.$day->id:'day_date'" name="day[date]"
                                  :value="!empty($day->date)?$day->calendar_date:''"
                                  data-date-format="dd/mm/yyyy"
                                  data-type="datepicker"
                                  data-dates-disabled="{{ !empty($day)?implode(',', $session->calendar_days([$day->id])->toArray() ):implode(',', $session->calendar_days()->toArray())  }}"
                                  class="form-control"></x-form-input>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <x-form.text-field type="text"
                                       label="{{  trans('of.session_days.am_start') }}"
                                       name="day[am_start]"
                                       data-type="mask"
                                       data-inputmask-regex='^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'
                                       placeholder="HH:MM"
                                       :value="!empty($day->am_start)?$day->am_start:''">
                    </x-form.text-field>
                </div>
                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <x-form.text-field type="text"
                                       label="{{  trans('of.session_days.am_end') }}"
                                       name="day[am_end]"
                                       data-type="mask"
                                       data-inputmask-regex='^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'
                                       placeholder="HH:MM"
                                       :value="!empty($day->am_end)?$day->am_end:''">
                    </x-form.text-field>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <x-form.text-field type="text"
                                       id="day_pm_start"
                                       label="{{  trans('of.session_days.pm_start') }}"
                                       name="day[pm_start]"
                                       data-type="mask"
                                       data-inputmask-regex='^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'
                                       placeholder="HH:MM"
                                       :value="!empty($day->pm_start)?$day->pm_start:''">
                    </x-form.text-field>
                </div>
                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <x-form.text-field type="text"
                                       label="{{  trans('of.session_days.pm_end') }}"
                                       name="day[pm_end]"
                                       data-type="mask"
                                       data-inputmask-regex='^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$'
                                       placeholder="HH:MM"
                                       :value="!empty($day->pm_end)?$day->pm_end:''">
                    </x-form.text-field>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3 pb-3">
                    <x-form.translated-textarea label="{{ __('of.session_days.description') }}"
                                                :id="!empty($day)?'day_description_'.$day->id:'day_description'"
                                                name="day[description]"
                                                :values="!empty($day)?$day->getTranslations('description'):[]">
                    </x-form.translated-textarea>
                </div>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-end">
            @if(empty($day))

                <x-form-submit id="create_day" ajax="1">{{ __('of.session_days.btn') }}
                </x-form-submit>

            @else

                <x-form-submit id="update_day{{ $day->id }}" ajax="1">{{ __('common.update') }}
                </x-form-submit>

            @endif
        </div>
    </div>
</div>
