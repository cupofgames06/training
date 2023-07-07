<div class="row">
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
                {{ __('common.profile_title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label class="form-label w-100" for="profile[title]">
                            {{ __('common.profile.title') }}
                        </label>
                        <x-form-select :default="!empty($learner)?$learner->profile->title:''"
                                       name="profile[title]"
                                       :options="trans('common.profile.titles')"
                                       class="form-control" data-type="select2"/>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('common.profile.first_name') }}"
                                           name="profile[first_name]"
                                           :value="!empty($learner)?$learner->profile->first_name:''">
                        </x-form.text-field>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('common.profile.last_name') }}"
                                           name="profile[last_name]"
                                           :value="!empty($learner)?$learner->profile->last_name:''">
                        </x-form.text-field>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('common.profile.phone_1') }}"
                                           name="profile[phone_1]"
                                           :value="!empty($learner)?$learner->profile->phone_1:''">
                        </x-form.text-field>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label for="birth_date"
                               class="form-label">{{ __('common.profile.birth_date') }}</label>
                        <x-form-input id="birth_date" name="profile[birth_date]"
                                      :value="!empty($learner->profile->birth_date)?$learner->profile->birth_date->format('d/m/Y'):''"
                                      data-date-format="dd/mm/yyyy"
                                      data-type="datepicker"
                                      class="form-control"></x-form-input>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('common.profile.birth_zipcode') }}"
                                           name="profile[birth_zipcode]"
                                           :value="!empty($learner)?$learner->profile->birth_zipcode:''">
                        </x-form.text-field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label class="form-label w-100" for="country_iso">
                            {{ __('common.profile.birth_country') }}
                        </label>
                        <x-form-select :default="!empty($learner)?$learner->profile->birth_country_id:''"
                                       name="profile[birth_country_id]"
                                       id="birth_country_id"
                                       :options="\App\Models\Country::getSelectList()"
                                       class="form-control"
                                       data-type="select2"
                        />
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="col-md-12 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp far fa-buildings text-primary"></i>
                {{ __('company.learners.pro_info_title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label for="date_start"
                               class="form-label">{{ __('company.learners.date_start') }}</label>
                        <x-form-input id="date_start" name="description[date_start]"
                                      :value="!empty($learner->description->date_start)?$learner->description->date_start->format('d/m/Y'):''"
                                      data-type="datepicker"
                                      class="form-control"></x-form-input>

                    </div>

                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('company.learners.email') }}"
                                           name="description[email]"
                                           :value="!empty($learner)?$learner->description->email:''">
                        </x-form.text-field>
                    </div>
                </div>

                <x-form.tags-field group="learner"
                                   :selected="!empty($learner)?$learner->description->tags()->get()->pluck('id')->toArray():[]"></x-form.tags-field>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
                {{ __('common.user_title') }}</div>
            <div class="card-body">

                <div class="row">

                    @if( empty($learner) || $learner->id != Auth::id())

                        <div class="col mb-3 pb-3">
                            <x-form.text-field label="{{ __('common.user.email') }}"
                                               name="user[email]"
                                               :value="!empty($learner)?$learner->email:''">
                            </x-form.text-field>
                        </div>

                    @else

                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                            <x-form.text-field label="{{ __('common.user.email') }}"
                                               name="user[email]" :value="!empty($learner)?$learner->email:''">
                            </x-form.text-field>
                        </div>

                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                            @component('components.form.password-field')
                            @endcomponent
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


