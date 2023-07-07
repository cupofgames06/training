@if(!empty($session))
    @if($session->trainers->count() > 0)
        @include('front.pages.offers.partial.card.nav-tab',['course'=>$course])
    @endif
@endif

@if( !empty($session->description->promo_message))
    @include('front.pages.offers.partial.card.promo-message',['message'=>$session->description->promo_message])
@endif

@if( !empty($course->description->promo_message))
    @include('front.pages.offers.partial.card.promo-message',['message'=>$course->description->promo_message])
@endif

@if( !empty($course->access_rules->count()))
    @include('front.pages.offers.partial.card.access-rules',['rules'=>$course->access_rules])
@endif

@if(!empty($session))
    @include('front.pages.offers.partial.card.session-info',['course'=>$course,'session'=>$session])
@endif

@include('front.pages.offers.partial.card.info',['description'=>$course])
@include('front.pages.offers.partial.card.objectives',['description'=>$course->description])
@include('front.pages.offers.partial.card.program',['description'=>$course->description])

<div class="row">
    <div class="col-md-6 col-sm-12">
        @include('front.pages.offers.partial.card.pedago',['description'=>$course->description])
    </div>
    <div class="col-md-6 col-sm-12">
        @include('front.pages.offers.partial.card.eval',['description'=>$course->description])
    </div>
</div>
