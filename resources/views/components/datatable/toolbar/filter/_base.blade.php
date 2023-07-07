<!--begin::Filter - Base-->
<div class="me-6">
    @isset($filter->label)
        <!--begin::Label-->
        <label class="form-label fw-bold">{{ $filter->label}} :</label>
        <!--end::Label-->
    @endisset
    <!--begin::Input-->
    <div>
        <select class="form-select form-select-solid w-200px" data-control="select2" data-placeholder="{{ $filter->placeholder }}" data-allow-clear="true" data-hide-search="true" data-kt-table-filter="filter" data-column="{{ $filter->column_filter }}" data-type="{{ $filter->type??false }}">
            <option></option>
            @foreach($filter->items as $row)
                <option value="{{ $row }}">{{ $row }}</option>
            @endforeach
        </select>
    </div>
    <!--end::Input-->
</div>
<!--end::Filter - Base-->
