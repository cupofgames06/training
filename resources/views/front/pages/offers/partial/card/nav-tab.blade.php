<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">

    @php( $preview = request()->get('preview')?'?preview='.request()->get('preview'):'' )
    <li class="nav-item" role="presentation">
        <a class="nav-link @empty($trainer) active @endempty "
           @isset($trainer) href="{{ route('front.offers.session',[$session]).$preview }}" @endisset >
            Description
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a class="nav-link @isset($trainer) active @endisset "
           @empty($trainer) href="{{ route('front.offers.trainers',[$session]).$preview }}" @endisset>
            Formateurs
        </a>
    </li>

</ul>
