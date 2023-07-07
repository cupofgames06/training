<select class="js-example-basic-single" name="state">
    <option>Choisir un type </option>
    <option value="{{ route('of.courses.index') }}">Courses</option>
    <option value="{{ route('of.packs.index') }}">Packs</option>

</select>
@push('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            $('.js-example-basic-single').select2();

            $('.js-example-basic-single').on('select2:select', function (e) {
                window.location.href = $(this).val();
            });
        });
    </script>
@endpush
