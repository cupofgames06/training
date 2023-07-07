<div class="row">

    <div class="col-md-12 col-lg-6 mb-4">
        @include('dashboard.partials.profile',['profile'=>!empty($trainer)?$trainer->profile:null])
        <div class="card">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-pen-alt text-primary"></i>
                {{ __('of.trainers.description_title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <x-form.translated-textarea label="{{ __('of.trainers.cv') }}"
                                                    name="description[cv]"
                                                    :values="!empty($trainer->description)?$trainer->description->getTranslations('cv'):[]">
                        </x-form.translated-textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-6">
        @include('dashboard.partials.trainer-infos',['trainer'=>!empty($trainer)?$trainer:null])
        <div class="card  mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-lock text-primary"></i>
                {{ __('common.user_title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <x-form.text-field label="{{ __('common.user.email') }}"
                                           name="user[email]"
                                           :value="!empty($trainer)?$trainer->email:''">
                        </x-form.text-field>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
