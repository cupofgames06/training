<!--begin::Filter - Dropdown-->
<div class="me-3">
    <!--begin::Export dropdown-->
    <div class="dropdown-center">
        <button class="{{ $filter->class??null }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {!! $filter->icon??null !!}
            {!! $filter->label??null !!}

            <span class="badge bg-secondary rounded-circle" id="badge_{{ $filter->id }}" data-badge-filter="{{ Str::lower($filter->label) }}"></span>
        </button>
        <ul class="dropdown-menu datatable_filter_menu" id="datatable_filter_menu_{{ $filter->id }}" data-table-filter="{{ Str::lower($filter->label) }}">
            @foreach($filter->items as $key => $item)
                <li class="dropdown-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $item }}" id="filter_{{ $key }}" />
                        <label class="form-check-label" for="filter_{{ $key }}">{{ $item }}</label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!--end::Export dropdown-->
</div>
<!--end::Filter - Dropdown-->
@push('scripts')
    <script type="module">

        document.addEventListener("DOMContentLoaded", function (event) {
            $(".dropdown-item").click(function (e) {
                e.stopPropagation();
            })
        })
    </script>
@endpush
