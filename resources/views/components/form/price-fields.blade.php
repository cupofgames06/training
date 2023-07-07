<div id="{{ $id }}">
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-3 pb-3">
            <label class="form-label w-100" for="price_type">
                {{ __('common.price.type') }}
            </label>
            <x-form-select
                id="price_type_{{ $id }}"
                name="price[{{ $price_level_id }}][type]"
                :default="!empty($price)?$price['type']:''"
                :options="trans('common.price.types')"
                class="form-control" data-type="select2"/>
        </div>
        <div class="col-lg-6 col-md-12 mb-3 pb-3">
            <label class="form-label w-100" for="price_vat">
                {{ __('common.price.vat_rate') }}
            </label>
            <x-form-select
                id="price_vat_{{ $id }}"
                name="price[{{ $price_level_id }}][vat_rate]"
                :default="!empty($price)?$price['vat_rate']:''"
                :options="config('custom.mespapilles.vat_rates')"
                class="form-control" data-type="select2"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 mb-3 pb-3">
            <x-form.text-field type="text" pattern="^\d*(\.\d{0,2})?$"
                               label="{{  trans('common.price.price_ht') }}"
                               name="price[{{ $price_level_id }}][price_ht]" min="0"
                               :value="!empty($price)?$price['price_ht']:''">
            </x-form.text-field>
        </div>
        <div class="col-lg-6 col-md-12 mb-3 pb-3">
            <x-form.text-field type="text"
                               pattern="^\d*(\.\d{0,2})?$"
                               label="{{  trans('common.price.price_ttc') }}"
                               name="price[{{ $price_level_id }}][price_ttc]" min="0"
                               :value="!empty($price)?$price['price_ttc']:''">
            </x-form.text-field>
        </div>
    </div>
    @if( !empty(custom('payment-options')))
        <div class="row">
            <div class="col-12 mb-3 pb-3">
                <label class="form-label w-100" for="price_options">
                    {{ __('common.price.options') }}
                </label>
                <x-form-select
                    name="price[{{ $price_level_id }}][options][]"
                    :options="custom('payment-options')"
                    multiple="true"
                    :default="!empty($price) && !empty($price['options'])?$price['options']:null"
                    class="form-control" data-type="select2"/>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script type="module">

        let price_ht;
        let price_ttc;
        let price_vat;
        let price_container;

        document.addEventListener("DOMContentLoaded", function (event) {

            price_container = $("#{{ $id }}");

            price_vat = price_container.find("select[name='price[{{ $price_level_id }}][vat_rate]']");
            price_vat.change(update_from_vat);

            price_ht = price_container.find("input[name='price[{{ $price_level_id }}][price_ht]']");
            price_ht.blur(update_from_ht);

            price_ttc = price_container.find("input[name='price[{{ $price_level_id }}][price_ttc]']");
            price_ttc.blur(update_from_ttc);
        });

        function update_from_vat(e) {
            if (e.target.value > 0) {
                const vat = parseFloat(e.target.value) / 100;
                const ht = parseFloat(price_ht.val());
                const ttc = ht * (1 + vat);
                price_ttc.val(ttc.toFixed(2));
                price_ht.val((ttc / (1 + vat)).toFixed(2));
            } else {
                price_ht.val(0);
                price_ttc.val(0);
            }
        }

        function update_from_ht(e) {
            if (e.target.value > 0) {
                const ht = parseFloat(e.target.value);
                const vat = parseFloat(price_vat.val()) / 100;
                const ttc = ht * (1 + vat);
                price_ttc.val(ttc.toFixed(2));
            } else {
                price_ttc.val(0);
            }
        }

        function update_from_ttc(e) {
            if (e.target.value > 0) {
                const ttc = parseFloat(e.target.value);
                const vat = parseFloat(price_vat.val()) / 100;
                price_ht.val((ttc / (1 + vat)).toFixed(2));
            } else {
                price_ht.val(0);
            }
        }
    </script>
@endpush
