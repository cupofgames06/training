<div class="me-3">
    <!--begin::Export dropdown-->
    <div class="dropdown-center">
        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-regular fa-cloud-arrow-down"></i>
            Exporter
        </button>
        <ul class="dropdown-menu" id="datatable_export_menu_{{ $table->id }}">
            <li><a class="dropdown-item" href="#" data-kt-export="csv">CSV</a></li>
            <li><a class="dropdown-item" href="#" data-kt-export="excel">Excel</a></li>

        </ul>
    </div>
    <!--end::Export dropdown-->

    <!--begin::Hide default export buttons-->
    <div id="datatable_exports_buttons_{{ $table->id }}" class="d-none" data-title="{{ $title }}"></div>
    <!--end::Hide default export buttons-->
</div>
