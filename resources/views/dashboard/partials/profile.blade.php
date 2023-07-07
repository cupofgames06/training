<div class="card  mb-4">

    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-user-circle text-primary"></i>
        {{ __('common.profile_title') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="profile[title]">
                    {{ __('common.profile.title') }}
                </label>
                <x-form-select :default="!empty($profile)?$profile->title:''"
                               name="profile[title]"
                               :options="trans('common.profile.titles')"
                               class="form-control" data-type="select2"/>
            </div>

            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('common.profile.first_name') }}"
                                   name="profile[first_name]"
                                   :value="!empty($profile)?$profile->first_name:''">
                </x-form.text-field>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('common.profile.last_name') }}"
                                   name="profile[last_name]"
                                   :value="!empty($profile)?$profile->last_name:''">
                </x-form.text-field>
            </div>

            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('common.profile.phone_1') }}"
                                   name="profile[phone_1]"
                                   :value="!empty($profile)?$profile->phone_1:''">
                </x-form.text-field>
            </div>
        </div>

    </div>
</div>
