<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">

    @php( $preview = request()->get('preview')?'?preview='.request()->get('preview'):'' )
    <li class="nav-item" role="presentation">
        <a class="nav-link @empty($content) active @endempty "
           @isset($content) href="{{ route('front.offers.pack',[$pack]).$preview }}" @endisset >
            Description
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a class="nav-link @isset($content) active @endisset "
           @empty($content) href="{{ route('front.offers.pack-content',[$pack]).$preview }}" @endisset>
            Contenu du Pack ({{ $pack->packables()->count() }})
        </a>
    </li>

</ul>
