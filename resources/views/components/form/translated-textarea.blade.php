<div class="translated-container">
    <label class="form-label align-items-baseline w-100 d-flex justify-content-between" for="course_{{ $name }}">
        <div class="float-start">{{ $label }}</div>
        <div class="float-end">
            <x-form-select
                id="{{ $id }}"
                name="toggle{{ $id }}"
                :options="$locales"
                class="form-control"
            />
        </div>
    </label>
    <div class="translated-textarea-container">
        @foreach( config('app.supported_locales') as $locale)
            @php
                $class = '';
            @endphp
            @if($locale != app()->getLocale())
                @php
                    $class = 'd-none';
                @endphp
            @endif
            <div class="{{$class }}">
                <x-form.tinyMceEditor id="{{ $id }}_{{ $locale }}"
                                      name="{{ $name }}[{{$locale}}]"
                                      value="{{ !empty($values[$locale])?$values[$locale]:'' }}"
                                      :module="$is_module"
                                      data-css="{{ !empty($attributes['data-css'])?$attributes['data-css']:'' }}"
                                      data-body-class="{{ !empty($attributes['data-body-class'])?$attributes['data-body-class']:'' }}"
                                      data-locale="{{ $locale }}"></x-form.tinyMceEditor>
            </div>
        @endforeach
    </div>
</div>
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {
            window.initLanguageInput('#{{ $id }}');
        });
    </script>
@endpush
