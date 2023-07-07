@isset($monitoring)
    @include('front.pages.offers.partial.card.access-message')
@endisset

@if( !empty($course->description->promo_message))
    @include('front.pages.offers.partial.card.promo-message',['message'=>$course->description->promo_message])
@endif

@if( !empty($course->access_rules->count()))
    @include('front.pages.offers.partial.card.access-rules',['rules'=>$course->access_rules])
@endif

<div class="card mb-4">
    <div class="card-header">
        {{ __('front.courses.show.detail_title') }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Lieu</div>
                <div class="pb-2 mb-1">Où vous voulez</div>

            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Dates</div>
                <div>
                    quand vous voulez
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Formateurs</div>
            </div>
        </div>
    </div>
</div>

@include('front.pages.offers.partial.card.info',['description'=>$course->description])
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
