<!--begin::Action-->
<div>
    <a href="{{ $item->route }}" class="{{ $item->class }}">
        {!! $item->icon??null !!}
        {{ $item->label }}
    </a>
</div>
<!--end::Action-->
