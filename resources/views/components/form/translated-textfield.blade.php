<div class="translated-container">
    <div class="form-label align-items-baseline w-100 d-flex justify-content-between">
        @if($label)
            <div>
                {{ $label }}
            </div>
        @endif
        @if($label)
            <div class="align-items-baseline d-flex">
                @endif
                <x-form-select id="{{ $id }}" name="toggle{{ $id }}" :options="$locales" class="form-control"/>
                @if($label)
            </div>
        @endif
    </div>
    <div class="translated-textfield-container">
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
                <x-form-input id="{{ $id }}_{{ $locale }}" name="{{ $name }}[{{$locale}}]" data-type="tinymce"
                              value="{{ !empty($values[$locale])?$values[$locale]:'' }}"
                              class="form-control"></x-form-input>
            </div>
        @endforeach
    </div>
</div>
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {
            window.initLanguageInput(('#{{ $id }}'));
        });

    </script>
@endpush
