<div class="row">

    @foreach($tags as $k => $v)
        <div class="{{ count($tags) == 1?'col':'col-lg-6 col-md-12' }} mb-3 pb-3">
            <label class="form-label w-100" for="country_iso">
                @lang('custom/mespapilles.tags.'.$k)
            </label>

            <x-form-select name="tag[{{ $k }}][]"
                           id="{{ $k }}"
                           :options="$v"
                           class="form-control"
                           :$multiple
                           :default="$selected"
                           data-type="select2"/>
        </div>

    @endforeach
</div>

