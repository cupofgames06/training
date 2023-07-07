<div id="geocode-field-container-{!! $id !!}">

    <div class="form-group">
        <x-form-label class="form-label"
                      label="{!! $label !!}"></x-form-label>
        <div class="input-group mb-3">
                                                    <span class="input-group-text bg-white border-end-0  ps-3 pe-2"
                                                          id="basic-addon1"><i class="fa fa-lg fa-search"></i></span>
            <x-form-input class="border-start-0" name="geocode_address"
                          id="{!! $id !!}"
                          placeholder="{!! !empty($placeholder)?$placeholder:'Recherchez votre adresse pour compléter les champs' !!}"></x-form-input>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= config('services.google.key') ?>&libraries=places"></script>
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            let country = $("{{ $inputs['country'] }}");
            let street_number = $("{{ $inputs['street_number'] }}");
            let street_name = $("{{ $inputs['street_name'] }}");
            let city = $("{{ $inputs['city'] }}");
            let postal_code = $("{{ $inputs['postal_code'] }}");

            let autocomplete = new google.maps.places.Autocomplete(document.getElementById('{!! $id !!}'), {types: ['geocode']});
            let addressComponent = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                country: 'short_name',
                postal_code: 'short_name'
            };

            let selected_country = country.val();
            if (selected_country) {
                setRestrictions();
            }

            autocomplete.addListener('place_changed', fillInAddress);
            country.on('change', setRestrictions);

            function setRestrictions() {
                let selected_country = country.val();
                if (selected_country) {
                    autocomplete.setComponentRestrictions({
                        country: [selected_country],
                    });
                }
            }

            function fillInAddress() {

                let place = autocomplete.getPlace();
                let results = Array();
                results['street_number'] = results['route'] = results['locality'] = results['postal_code'] = results['country'] = '';

                for (let i = 0; i < place.address_components.length; i++) {
                    let addressType = place.address_components[i].types[0];
                    if (addressComponent[addressType]) {
                        results[addressType] = place.address_components[i][addressComponent[addressType]];
                    }
                }

                //$("input[name='address[latitude]']").val(place.geometry.location.lat());
                //$("input[name='address[longitude]']").val(place.geometry.location.lng());
                street_number.val(results['street_number']);
                street_name.val(results['route']);
                city.val(results['locality']);
                postal_code.val(results['postal_code']);
                country.val(results['country']);

            }
        });
    </script>
@endpush
