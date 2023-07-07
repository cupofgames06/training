<div class="card mb-4">

    <div class="card-header">
        <i class="icon fa-sharp far fa-person-chalkboard  text-primary"></i>
        {{ __('of.trainers.info_title') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <x-form.text-field label="{{ __('of.trainers.city') }}"
                                   name="address[city]"
                                   :value="!empty($trainer)?$trainer->address->city:''">
                </x-form.text-field>
            </div>

            <div class="col-lg-6 col-md-12 mb-3 pb-3">
                <label class="form-label w-100" for="country_iso">
                    {{ __('of.trainers.type') }}
                </label>
                <x-form-select :default="!empty($trainer->description)?$trainer->description->is_person:1"
                               name="description[is_person]"
                               id="is_person"
                               :options="\App\Models\Trainer::getTypeList()" class="form-control"
                               data-type="select2"
                />
            </div>
        </div>
        <div id="type_company" class="d-none">
            <div class="row">
                <div class="col mb-3 pb-3">
                    <x-form.text-field label="{{ __('N° d’identification') }}"
                                       name="entity[reg_number]"

                                       :value="!empty($trainer->entity)?$trainer->entity->reg_number:''">
                    </x-form.text-field>
                </div>
            </div>
        </div>

        <div id="type_person" class="d-none">

            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <label for="birth_date" class="form-label">{{ __('common.profile.birth_date') }}</label>
                    <x-form-input id="birth_date" name="profile[birth_date]"
                                  :value="!empty($trainer->profile->birth_date)?$trainer->profile->birth_date->format('d/m/Y'):''"
                                  data-date-format="dd/mm/yyyy"
                                  data-type="datepicker"
                                  class="form-control"></x-form-input>
                </div>

                <div class="col-lg-6 col-md-12 mb-3 pb-3">
                    <x-form.text-field label="{{ __('common.profile.birth_zipcode') }}"
                                       name="profile[birth_zipcode]"
                                       :value="!empty($trainer)?$trainer->profile->birth_zipcode:''">
                    </x-form.text-field>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3 pb-3">
                    <label class="form-label w-100" for="country_iso">
                        {{ __('common.profile.birth_country') }}
                    </label>
                    <x-form-select
                        :default="!empty($trainer)?$trainer->profile->birth_country_id:$of->address->country_id"
                        name="profile[birth_country_id]"
                        id="birth_country_id"
                        :options="\App\Models\Country::getSelectList()" class="form-control"
                        data-type="select2"
                        style="width:100%"
                    />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mb-3 pb-3">
                <div class="form-group">
                    <x-form-label class="form-label"
                                  label="image de la signature (facultatif)"></x-form-label>
                    @component('components.form.file-upload')
                        @slot('id','trainer_signature')
                        @slot('url',  !empty($route)?$route:route('of.trainers.upload_signature') )
                        @slot('file', !empty($trainer)?$trainer->getFirstMedia('signature'):'' )
                        @slot('text','Format : PNG avec fond transparent (max. 800x600px).<br>La signature s’affichera uniquement sur les documents concernés.')
                        @slot('accepted_files',['png'])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            let is_person = $("#is_person");
            let person = $("#type_person");
            let company = $("#type_company");
            is_person.on('change', toggleTrainerType);

            function toggleTrainerType() {

                if (is_person.val() == 0) {
                    person.addClass('d-none');
                    company.removeClass('d-none');
                } else {
                    person.removeClass('d-none');
                    company.addClass('d-none');
                }
            }

            toggleTrainerType();
        });
    </script>
@endpush
