<div class="card mb-4 session-trainer">
    <div class="card-header">
        @empty($session_trainer)
            <i class="icon far fa-person-chalkboard text-primary"></i>
            {{ __('of.session_trainers.title') }}
        @else

            {{  $session_trainer->profile->fullName }}
            <div class="float-end">
                <a href="#"
                   data-type="delete"
                   data-url="{{ route('of.sessions.delete_trainer',['session'=>$item->id ,'trainer'=>$session_trainer->pivot->id]) }}"
                   class="delete fas fa-close text-decoration-none" id="{{ $session_trainer->pivot->id }}">
                </a>

            </div>
        @endif
    </div>
    <div class="card-body">
        @empty($session_trainer)
            <div class="text-muted mb-4">{!! __('of.session_trainers.sub_title') !!}</div>
            <div class="row">
                <div class="col mb-3 pb-3">
                    <div class="form-group">
                        <label class="form-label w-100" for="session_trainer_trainer_id">
                            {{ __('of.session_trainers.trainer') }}
                        </label>
                        <x-form-select
                            id="session_trainer_choose"
                            name="session_trainer[trainer_id]"
                            :options="[''=>trans('common.select')]+$of->trainers->whereNotIn('id',$item->trainers->pluck('id'))->pluck('profile.full_name','id')->toArray()"
                            :default="!empty($session_trainer)?$session_trainer->pivot->trainer_id:null"
                            class="form-control" data-type="select2"/>
                    </div>
                </div>
            </div>
        @endempty
        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <x-form.text-field label="{{ __('of.session_trainers.via_of') }}"
                                       :value="!empty($session_trainer)?$session_trainer->pivot->via_of:''"
                                       name="session_trainer[via_of]">
                    </x-form.text-field>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        @if(empty($session_trainer))
            <div class="float-end">
                <x-form-submit id="create_session_trainer" ajax="1">{{ __('of.session_trainers.btn') }}
                </x-form-submit>
            </div>
        @else
            <div class="float-end">
                <x-form-submit id="update_session_trainer{{ $session_trainer->id }}" ajax="1">{{ __('common.update') }}
                </x-form-submit>
            </div>
        @endif
    </div>
</div>
