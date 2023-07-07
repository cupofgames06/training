@include('front.pages.offers.partial.card.pack-nav-tab',['pack'=>$pack])

@if( !empty($pack->description->promo_message))
    @include('front.pages.offers.partial.card.promo-message',['message'=>$pack->description->promo_message])
@endif

@foreach($pack->elearnings()->where('status','Active')->get() as $course)
    @if( !empty($course->access_rules->count()))
        @include('front.pages.offers.partial.card.access-rules',['rules'=>$course->access_rules])
    @endif
@endforeach

@if(!empty($session))
    @include('front.pages.offers.partial.card.session-info',['course'=>$course,'session'=>$session])
@endif

@include('front.pages.offers.partial.card.info',['description'=>$pack])
@include('front.pages.offers.partial.card.objectives',['description'=>$pack->description])
@include('front.pages.offers.partial.card.program',['description'=>$pack->description])

<div class="row">
    <div class="col-md-6 col-sm-12">
        @include('front.pages.offers.partial.card.pedago',['description'=>$pack->description])
    </div>
    <div class="col-md-6 col-sm-12">
        @include('front.pages.offers.partial.card.eval',['description'=>$pack->description])
    </div>
</div>
