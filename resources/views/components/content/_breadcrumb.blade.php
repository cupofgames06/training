<ol class="breadcrumb text-muted">
    @foreach ($breadcrumbs as $k => $v)
        @if (!is_null($k) && !$loop->last)
            <li class="breadcrumb-item"><a class="text-muted" href="{{ $k }}">{{ $v }}</a></li>
        @else
            <li class="breadcrumb-item active text-muted">{{  $v }}</li>
        @endif
    @endforeach
</ol>
