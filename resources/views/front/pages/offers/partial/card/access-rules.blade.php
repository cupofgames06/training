<div
    class="bg-primary bg-opacity-10 align-items-start align-items-baseline  flex-column d-flex rounded border border-4 border-white p-4 mb-4">

    @if( count($rules) == 1)
        <div><i class="icon text-muted fas fa-info-circle pe-2"></i> Pré-requis : Avoir
            {!! $rules[0]->readable !!}
        </div>
    @else
        <div class="d-flex align-items-baseline"><i class="icon text-muted fas fa-info-circle pe-2"></i> Pré-requis (un
            minimum) :
        </div>
        <div class="d-flex">
            <ul>
                @foreach($rules as $r)
                    <li>
                        @if ($loop->first)
                            Avoir
                        @else
                            Ou avoir
                        @endif
                        {!! $r->readable !!} </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

