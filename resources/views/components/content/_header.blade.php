<div class="d-flex justify-content-between align-items-center">
    <div class="float-start">
        @empty($sub_title)
            <h3 class="fw-bold text-dark mb-2 pb-3"> {!! $title??null !!}</h3>
        @else
            <h3 class="fw-bold text-dark mb-1 pb-2"> {!! $title??null !!}</h3>
            <div class="text-dark mb-2 pb-3">{!! $sub_title !!}</div>
        @endempty
    </div>
    <div class="float-end">
        {{ $slot }}
    </div>
</div>

