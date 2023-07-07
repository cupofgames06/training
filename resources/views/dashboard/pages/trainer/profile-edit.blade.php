<x-auth-layout>


        <x-content.header title="{{ $trainer->name }}" :subTitle="$trainer->name"></x-content.header>
        <x-form :action="route('trainer.profile.update')" id="trainer_edit_form"
                v-on:submit="checkForm">
            @method('patch')
            @csrf

            <div class="row">

                <div class="col-md-12 col-lg-6 mb-4">
                    @include('dashboard.partials.profile',['profile'=>!empty($trainer)?$trainer->profile:null])
                    <div class="card">
                        <div class="card-header">
                            <i class="icon fa-sharp fa-regular fa-pen-alt text-primary"></i>
                            {{ __('trainer.description_title') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col mb-3 pb-3">

                                    <x-form.translated-textarea label="{{ __('trainer.cv') }}"
                                                                name="description[cv]"
                                                                :values="!empty($trainer->description)?$trainer->description->getTranslations('cv'):[]">
                                    </x-form.translated-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">

                    @include('dashboard.partials.trainer-infos',['route'=>route('trainer.profile.upload_signature'), 'trainer'=>!empty($trainer)?$trainer:null])

                    <div class="card  mb-4">

                        <div class="card-header">
                            <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
                            {{ __('trainer.user_title') }}</div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                    <x-form.text-field label="{{ __('common.user.email') }}"
                                                       name="user[email]" :value="!empty($trainer)?$trainer->email:''">
                                    </x-form.text-field>
                                </div>

                                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                    @component('components.form.password-field')
                                    @endcomponent
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </x-form>

        @push('sticky-footer')
            @component('components.content._sticky-footer')
                <x-form-submit id="edit_trainer" ajax="1" form_id="trainer_edit_form">
                    {{ __('of.trainers.edit.btn') }}
                </x-form-submit>
            @endcomponent
        @endpush


</x-auth-layout>
