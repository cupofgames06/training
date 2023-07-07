@if(!empty($session))
    @include('front.pages.offers.partial.card.nav-tab',['course'=>$course,'trainer' => true])
@endif

@foreach($session->trainers()->get() as $trainer)
    @include('front.pages.offers.partial.card.trainer',['trainer'=>$trainer])
@endforeach



