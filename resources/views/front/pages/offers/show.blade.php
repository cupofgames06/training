<x-guest-layout>
    <x-content.breadcrumb :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
    <div class="row  @if( !empty($preview) ) mb-5 pb-5 @endif ">
        <div class="col-lg-9 col-md-12 order-2 order-md-1">
            {!! $main !!}
        </div>
        <div class="col-lg-3 col-md-12 order-1 order-md-2">
            {!! $side !!}
        </div>
    </div>

    @if(!empty($preview))
        @push('sticky-footer')
            @component('components.content._sticky-footer')
                <a class="btn btn-outline-dark me-3"
                   href="{{ $preview['editor_url']  }}"><i class="fal fa-backward-step"></i>
                    <span class="d-none d-md-inline">{{ __('of.back_edit') }}</span></a>
            @endcomponent
        @endpush
    @endif
</x-guest-layout>
