<!--begin::Body-->
<div class="card rounded-4" id="{{ $table->id }}">
    <div class="card-header">
        <!--begin::Toolbar-->
        <div class="card-toolbar d-flex flex-nowrap justify-content-sm-between">
            @if(isset($table->search) && $table->search && isset($table->title))
                <div class="d-flex flex-nowrap align-items-center">
                    <h3>{{ $table->title }}</h3>
                </div>
                <div class="d-flex flex-nowrap align-items-center">
                    @include('components.datatable.toolbar._search',['item'=>$table->search])
                    @isset($table->filters)
                        @foreach($table->filters as $filter)
                            @switch($filter->type)
                                @case('dropdown')
                                    @include('components.datatable.toolbar.filter._dropdown')
                                    @break
                                @case('select')
                                    @include('components.datatable.toolbar.filter._base')
                                    @break
                                @default
                                    @include('components.datatable.toolbar.filter._dropdown')
                                    @break
                            @endswitch
                        @endforeach
                    @endisset
                    @isset($table->export)
                        @include('components.datatable.toolbar._export',['title'=>$table->export->title])
                    @endisset
                    @isset($table->action)
                        @if(!isset($table->permission) || auth()->user()->can('create ' . $table->permission))
                            @include('components.datatable.toolbar._action',['item'=>$table->action])
                        @endif
                    @endisset
                </div>
            @else
                @isset($table->title)
                    <div class="d-flex flex-nowrap align-items-center">
                        <h3>{{ $table->title }}</h3>
                    </div>
                @endisset
                @if(isset($table->search) && $table->search)
                    <div class="d-flex flex-nowrap align-items-center">
                        @include('components.datatable.toolbar._search',['item'=>$table->search])
                    </div>
                @endif
                <div class="d-flex flex-nowrap align-items-center">
                    @isset($table->filters)
                        @foreach($table->filters as $filter)
                            @switch($filter->type)
                                @case('dropdown')
                                    @include('components.datatable.toolbar.filter._dropdown')
                                    @break
                                @case('select')
                                    @include('components.datatable.toolbar.filter._base')
                                    @break
                                @default
                                    @include('components.datatable.toolbar.filter._dropdown')
                                    @break
                            @endswitch
                        @endforeach
                    @endisset
                    @isset($table->export)
                        @include('components.datatable.toolbar._export',['title'=>$table->export->title])
                    @endisset
                    @isset($table->action)
                        @if(!isset($table->permission) || auth()->user()->can('create ' . $table->permission))
                            @include('components.datatable.toolbar._action',['item'=>$table->action])
                        @endif
                    @endisset
                </div>
            @endif
        </div>
        <!--end::Toolbar-->
    </div>

    <!--begin::Table container-->
    <div class="card-body" data-columns="{{ count($table->columns) }}">
        <div class="table-responsive">
            <!--begin::Table-->
            <table id="{{ $table->id }}_datatable" class="table">
                <!--begin::Table head-->
                <thead>
                <tr>
                    @foreach($table->columns as $column)
                        <th class="{{ $column['class']??'' }} ">{{ $column['title'] }} </th>
                    @endforeach
                </tr>
                </thead>
            </table>
            <!--end::Table-->
        </div>
    </div>
    <!--end::Table container-->
</div>
<!--end::Body-->
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {
            const element = $('#{{ $table->id }}_datatable');
            let table;
            @if($table->ajax)
                table = element.DataTable({
                searchDelay: 500,
                serverSide: true,
                paging: true,
                pageLength: 10,
                order: [],
                ajax: "{{ isset($table->route)?$table->route:route(\Request::route()->getName()) }}",
                columns: @json($table->getColumns()),
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/{{ app()->getLocale() }}-{{ strtoupper(app()->getLocale()) }}.json',
                    paginate: {
                        previous: '<i class="fa-solid fa-chevron-left"></i>',
                        next: '<i class="fa-solid fa-chevron-right"></i>'
                    },
                },
                dom: 'rtp',
            });
            @else
                table = element.DataTable({
                searchDelay: 500,
                order: [],
                paging: true,
                pageLength: 10,
                data: @json($table->items),
                columns: @json($table->getColumns()),
                language: {
                    Url: @json('https://cdn.datatables.net/plug-ins/1.12.1/i18n/{{ app()->getLocale() }}-{{ strtoupper(app()->getLocale()) }}.json'),
                    paginate: {
                        previous: '<i class="fa-solid fa-chevron-left"></i>',
                        next: '<i class="fa-solid fa-chevron-right"></i>'
                    },
                },
                dom: 'rtp',
            });
            @endif

            element.removeClass().addClass("table table-borderless dataTable");

            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ]
            }).container().appendTo($('#datatable_exports_buttons_{{ $table->id }}'));

            const exportButtons = document.querySelectorAll('#datatable_export_menu_{{ $table->id }} [data-kt-export]');
            exportButtons.forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Get clicked export value
                    const exportValue = e.target.getAttribute('data-kt-export');
                    const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                    // Trigger click event on hidden datatable export buttons
                    target.click();
                });
            });
            @if(isset($table->search) && $table->search)
            const filterSearch = document.querySelector('#{{ $table->id }} [data-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                let arr = [];
                arr['search'] = [e.target.value];

                @isset($table->filters)
                    const filters_button = document.querySelectorAll('.datatable_filter_menu');
                    @foreach($table->filters as $filter)
                        const {{ $filter->id }}_otions = document.querySelectorAll('#datatable_filter_menu_{{ $filter->id }} .dropdown-item');
                        const {{ $filter->id }}_badges = document.querySelectorAll('#badge_{{ $filter->id }}');

                        {{ $filter->id }}_otions.forEach(filterOption => {
                            filterOption.addEventListener('change', e => {
                                filters_button.forEach(filterButton => {
                                    const options = filterButton.querySelectorAll('.dropdown-item');
                                    const filterName = $(filterButton).data('table-filter');
                                    const filters = [];
                                    $(options).each(function () {
                                        if ($(this).children().find("input").is(':checked')) {
                                            filters.push($(this).children().find("input").val());
                                        }
                                    })

                                    arr[filterName] = filters;

                                });
                                {{ $filter->id }}_badges.forEach(filterBadge => {
                                    const name = $(filterBadge).data('badge-filter');
                                    if (arr[name].length === 0) {
                                        $(filterBadge).html('');
                                    } else {
                                        $(filterBadge).html(arr[name].length);
                                    }

                                })

                            });
                        })
                    @endforeach
                @endisset
                table.search(JSON.stringify(Object.assign({}, arr))).draw();
            });
            @endisset
            @isset($table->filters)
                const filters_button = document.querySelectorAll('.datatable_filter_menu');
                @foreach($table->filters as $filter)
                    const {{ $filter->id }}_otions = document.querySelectorAll('#datatable_filter_menu_{{ $filter->id }} .dropdown-item');
                    const {{ $filter->id }}_badges = document.querySelectorAll('#badge_{{ $filter->id }}');

                    {{ $filter->id }}_otions.forEach(filterOption => {
                        filterOption.addEventListener('change', e => {
                            let arr = [];
                            @if(isset($table->search) && $table->search)
                            const filterSearch = document.querySelector('#{{ $table->id }} [data-table-filter="search"]');
                            arr['search'] = [$(filterSearch).val()];
                            @endif
                            filters_button.forEach(filterButton => {
                                const options = filterButton.querySelectorAll('.dropdown-item');
                                const filterName = $(filterButton).data('table-filter');
                                const filters = [];

                                $(options).each(function () {
                                    if ($(this).children().find("input").is(':checked')) {
                                        filters.push($(this).children().find("input").val());
                                    }
                                })

                                arr[filterName] = filters;
                                console.log(filterName);

                            });
                            {{ $filter->id }}_badges.forEach(filterBadge => {
                                const name = $(filterBadge).data('badge-filter');
                                if (arr[name].length == 0) {
                                    $(filterBadge).html('');
                                } else {
                                    $(filterBadge).html(arr[name].length);
                                }

                            })
                            table.search(JSON.stringify(Object.assign({}, arr))).draw();
                        });
                    })
                @endforeach
            @endisset

        });


        function filters(table) {

        }

    </script>
@endpush

