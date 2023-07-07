<div class="bg-primary bg-opacity-10 d-sm-flex justify-content-between align-items-center rounded border border-4 border-white p-4 mb-4">
    <div class="d-flex flex-row">
        <div class="me-2">
            <i class="fas fa-location-dot text-primary fa-xl"></i>
        </div>
        <div class="d-flex flex-column">
            <span>{{ $session->classroom->address->city }} ({{ $session->classroom->address->postal_code }})</span>
            <span class="mt-2 mt-sm-0">
                {!! $session->classroom->address_number().', '.$session->classroom->address_street() !!}
                {!! !empty($session->classroom->address_complement())?', '.$session->classroom->address_complement():'' !!}
                {!! '<br>'.$session->classroom->name !!}
            </span>
        </div>
    </div>
    <a class="btn btn-secondary mt-2 mt-sm-0"> Voir sur le navigateur</a>
</div>
