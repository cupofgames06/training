<textarea id="{{ $id }}" name="{{ $name }}" data-type="tinyMce"
          {{ $attributes->merge(['data-body-class', 'data-css']) }}
>{!!  $value !!}</textarea>
@push('scripts')
    <script type="module">
        @empty($is_module)
        window.initTinyMceInput('textarea#{{ $id }}');
        @else
        window.initTinyMceModuleInput('textarea#{{ $id }}');
        @endempty
    </script>
@endpush
