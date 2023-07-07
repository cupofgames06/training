@include('front.pages.offers.partial.card.pack-nav-tab',['pack'=>$pack,'content'=>true])

@foreach($pack->elearnings->sortBy( function($elm) use($pack){ return $elm->packables()->where('pack_id' ,$pack->id)->first()->position; }) as $packable)
    <div class="card mb-4  @if(!$loop->last) mt-5 @endif ">
        <div class="card-header  align-items-baseline justify-content-between d-flex">
            <div class="float-start justify-content-start d-flex w-50 align-items-baseline">
            {{ $packable->description->reference.' - '.$packable->description->name }}
            </div>
            <div class="float-end d-flex align-items-baseline justify-content-end">
            <a href="#collapse{{ $packable->id }}" type="button" class="pe-2 fas fa-chevron-up text-decoration-none"
               data-bs-toggle="collapse"
               data-bs-target="#collapse{{ $packable->id }}"
               aria-expanded="true" aria-controls="collapse{{ $packable->id }}">
            </a>
            </div>
        </div>
    </div>
    <div class="collapse show" id="collapse{{ $packable->id }}">
    @include('front.pages.offers.partial.'.$packable->type,['course'=>$packable])
    </div>
@endforeach

@if( $pack->type == 'blended')
    @foreach($pack->ordered_sessions() as $packable)
        <div class="card mb-4 mt-5">
            <div class="card-header  align-items-baseline justify-content-between d-flex">
                <div class="float-start justify-content-start d-flex w-50 align-items-baseline">
                    {{ $packable->course->description->reference.' - '.$packable->course->description->name }}
                </div>
                <div class="float-end d-flex align-items-baseline justify-content-end">
                    <a href="#collapse{{ $packable->id }}" type="button" class="pe-2 fas fa-chevron-up text-decoration-none"
                       data-bs-toggle="collapse"
                       data-bs-target="#collapse{{ $packable->id }}"
                       aria-expanded="true" aria-controls="collapse{{ $packable->id }}">
                    </a>
                </div>
            </div>
        </div>
        <div class="collapse show" id="collapse{{ $packable->id }}">
        @include('front.pages.offers.partial.'.$packable->course->type,['course'=>$packable->course,'session'=>$packable])
        </div>
    @endforeach
@endif




