<x-auth-layout>


        <x-content.header title="{{ $of->name }}" :subTitle="$of->name"></x-content.header>

        <x-form :action="route('of.profile.update',['of'=>$of])" id="profile_form"
                v-on:submit="checkForm">
            @method('patch')
            @csrf

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header"><i class="icon far fa-buildings text-primary"></i>
                                    {{ __('Informations principales') }}</div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('Dénomination') }}"
                                                               name="entity[name]"
                                                               :value="$of->entity->name">
                                            </x-form.text-field>
                                        </div>

                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <label class="form-label w-100" for="country_iso">
                                                {{ __('Pays') }}
                                            </label>
                                            <x-form-select :default="$of->address->country->code"
                                                           name="address[country_iso]"
                                                           id="country_iso"
                                                           :options="\App\Models\Country::getSelectList('code')"
                                                           class="form-control"
                                                           data-type="select2"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            <x-form.text-field label="{{ __('N° d’identification') }}"
                                                               name="entity[reg_number]"

                                                               :value="$of->entity->reg_number">
                                            </x-form.text-field>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            <x-form.text-field label="{{ __('N° d’agrément') }}"
                                                               name="of[agreement_number]"

                                                               :value="$of->agreement_number">
                                            </x-form.text-field>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            @component('components.form.geocode-field')
                                                @slot('id','geocode_address')
                                                @slot('label','Adresse de l\'organisme')
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
                                                               :value="$of->address->street_number">
                                            </x-form.text-field>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('rue') }}"
                                                               name="address[street_name]"
                                                               id="street_name"
                                                               :value="$of->address->street_name">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('Complément d\'adresse') }}"
                                                               name="address[complement]"
                                                               id="complement"
                                                               :value="!empty($of)?$of->address->complement:''">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('code postal') }}"
                                                               name="address[postal_code]"
                                                               id="postal_code"
                                                               :value="$of->address->postal_code">
                                            </x-form.text-field>
                                        </div>

                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('ville') }}"
                                                               name="address[city]"
                                                               id="city"
                                                               :value="$of->address->city">
                                            </x-form.text-field>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            <div class="form-group">
                                                <x-form-label class="form-label"
                                                              label="tampon de l'organisme (facultatif)"></x-form-label>

                                                @component('components.form.file-upload')
                                                    @slot('id','tampon')
                                                    @slot('url',  route('of.profile.upload_tampon') )
                                                    @slot('file', $of->getFirstMedia('tampon') )
                                                    @slot('text','Format : PNG avec fond transparent (max. 800x600px).<br>Le tampon s’affichera uniquement sur les documents concernés.')
                                                    @slot('accepted_files',['png','zip'])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="card">

                                <div class="card-header">
                                    <i class="icon fa-sharp fa-regular fa-user-circle text-primary"></i>
                                    {{ __('Représentant') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <label class="form-label w-100" for="country_id">
                                                {{  __('common.profile.title') }}
                                            </label>
                                            <x-form-select :default="$of->contact->title"
                                                           name="contact[title]"
                                                           :options="trans('common.profile.titles')"
                                                           class="form-control" data-type="select2"/>
                                        </div>

                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.first_name') }}"
                                                               name="contact[first_name]"
                                                               :value="$of->contact->first_name">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.last_name') }}"
                                                               name="contact[last_name]"
                                                               :value="$of->contact->last_name">
                                            </x-form.text-field>
                                        </div>

                                        <div class="col-lg-6 col-md-12 mb-3 pb-3">
                                            <x-form.text-field label="{{ __('common.profile.function') }}"
                                                               name="contact[function]"
                                                               :value="$of->contact->function">
                                            </x-form.text-field>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-3 pb-3">
                                            <div class="form-group">
                                                <x-form-label class="form-label"
                                                              label="image de la signature (facultatif)"></x-form-label>

                                                @component('components.form.file-upload')
                                                    @slot('id','signature')
                                                    @slot('url',  route('of.profile.upload_signature') )
                                                    @slot('file', $of->getFirstMedia('signature') )
                                                    @slot('text','Format : PNG avec fond transparent (max. 800x600px).<br>La signature s’affichera uniquement sur les documents concernés.')
                                                    @slot('accepted_files',['png','zip'])
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


        </x-form>

        @push('sticky-footer')
            @component('components.content._sticky-footer')
                <x-form-submit id="edit_classroom" ajax="1" form_id="profile_form">
                    {{ __('of.profile.edit.btn') }}
                </x-form-submit>
            @endcomponent
        @endpush


</x-auth-layout>
