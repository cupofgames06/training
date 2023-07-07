<div class="inline-field" id="inline-field-{{ $id }}">
    <div class="d-block inline-field-static">{{ $values[app()->getLocale()] }}</div>
    <div class="translated-container d-flex d-none">
        <div class="flex-grow-1">
            @foreach( config('app.supported_locales') as $locale)
                @php
                    $class = '';
                @endphp
                @if($locale != app()->getLocale())
                    @php
                        $class = 'd-none';
                    @endphp
                @endif
                <div class="{{ $class }}">
                    <x-form-input id="{{ $id }}_{{ $locale }}" name="{{ $name }}[{{$locale}}]"
                                  value="{{ !empty($values[$locale])?$values[$locale]:'' }}"
                                  class="form-control"></x-form-input>
                </div>
            @endforeach
        </div>
        <div class="flex-grow-1">
            <div class="form-label">
                <x-form-select id="{{ $id }}" name="toggle{{ $id }}" :options="$locales" class="form-control"/>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {
            window.initLanguageInput(('#{{ $id }}'));
            $('#inline-field-{{ $id }}').find('.inline-field-static').on('click', window.toggleInlineFieldEditor);
        });
    </script>
@endpush
