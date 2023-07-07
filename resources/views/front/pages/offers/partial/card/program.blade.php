<div class="card mb-4">
    <div class="card-header">
        {{ __('front.courses.show.program_title') }}</div>
    <div class="card-body">
        <div class="bg-primary bg-opacity-10 border-2 rounded program">
            {!! $description->program !!}
        </div>
        <div class="text-muted mb-2 text-uppercase small">{{ __('front.courses.show.equipment_title') }}</div>
        <div class="text-muted d-flex align-items-baseline float-start">
            <i class="fa fa-book-open-cover pe-2"></i>
            <div class="text-dark"> {!! $description->equipment !!}</div>
        </div>
    </div>
</div>
