<x-auth-layout>


        <x-form :action="route('company.users.store')"
                v-on:submit="checkForm">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
                                    {{ __('company.learners.edit.public_info_title') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <label class="form-label w-100" for="country_id">
                                                {{ __('common.profile.title') }}
                                            </label>
                                            <x-form-select name="profile[title]"
                                                           :options="trans('common.profile.titles')"
                                                           class="form-control" data-type="select2"/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.first_name') }}"
                                                               name="profile[first_name]">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.last_name') }}"
                                                               name="profile[last_name]">
                                            </x-form.text-field>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.phone_1') }}"
                                                               name="profile[phone_1]">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
                                    {{ __('company.learners.edit.user_info_title') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.user.email') }}"
                                                               name="user[email]">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-end">
                                        <div class="btn btn-cancel fw-bold">{{ __('common.cancel') }}</div>
                                        <x-form-submit id="user_info" ajax="1">{{ __('common.update') }}
                                        </x-form-submit>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </x-form>


</x-auth-layout>
