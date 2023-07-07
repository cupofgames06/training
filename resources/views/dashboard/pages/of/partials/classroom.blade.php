<div class="row">
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-graduation-cap text-primary"></i>
                {{ __('of.classrooms.main.title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <x-form.translated-textfield label="{{ __('of.classrooms.name') }}"
                                                     name="classroom[name]"
                                                     :id="!empty($classroom)?'classroom_name_'.$classroom->id:'classroom_name'"
                                                     :values="!empty($classroom)?$classroom->getTranslations('name'):[]">
                        </x-form.translated-textfield>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field type="number" label="{{ __('of.classrooms.max_learners') }}"
                                           :value="!empty($classroom)?$classroom->max_learners:''"
                                           name="classroom[max_learners]" min="0">
                        </x-form.text-field>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <label class="form-label w-100" for="classroom_pmr">
                            {{ __('of.classrooms.pmr') }}
                        </label>
                        <x-form-select
                            id="classroom_pmr"
                            name="classroom[pmr]"
                            :options="trans('common.bool')"
                            :default="!empty($classroom)?$classroom->pmr:null"
                            class="form-control" data-type="select2"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="icon fa-sharp fa-regular fa-map-location-dot text-primary"></i>
                {{ __('of.classrooms.address.title') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col mb-3 pb-3">
                        <label class="form-label w-100" for="country_iso">
                            {{ __('Pays') }}
                        </label>
                        <x-form-select :default="!empty($classroom)?$classroom->address->country->code:$of->address->country->code"
                                       name="address[country_iso]"
                                       id="country_iso"
                                       :options="\App\Models\Country::getSelectList('code')" class="form-control"
                                       data-type="select2"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3 pb-3">
                        @component('components.form.geocode-field')
                            @slot('id','geocode_address')
                            @slot('label','Adresse de la salle')
                            @slot('inputs',[
                                'street_number' => '#street_number',
                                'street_name' => '#street_name',
                                'postal_code' => '#postal_code',
                                'city' => '#city',
                                'country' => '#country_iso'
                            ])
                        @endcomponent
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('numéro de voie') }}"
                                           name="address[street_number]"
                                           id="street_number"
                                           :value="!empty($classroom)?$classroom->address->street_number:''">
                        </x-form.text-field>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('rue') }}"
                                           name="address[street_name]"
                                           id="street_name"
                                           :value="!empty($classroom)?$classroom->address->street_name:''">
                        </x-form.text-field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('Complément d\'adresse') }}"
                                           name="address[complement]"
                                           id="complement"
                                           :value="!empty($classroom)?$classroom->address->complement:''">
                        </x-form.text-field>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('code postal') }}"
                                           name="address[postal_code]"
                                           id="postal_code"
                                           :value="!empty($classroom)?$classroom->address->postal_code:''">
                        </x-form.text-field>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3 pb-3">
                        <x-form.text-field label="{{ __('ville') }}"
                                           name="address[city]"
                                           id="city"
                                           :value="!empty($classroom)?$classroom->address->city:''">
                        </x-form.text-field>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
