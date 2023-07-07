<div class="card mb-4 overflow-hidden aside-summary">

    {{ $pack->description->aside_image }}

    <div class="card-body">
        <div class="pb-3 title">
            {{ $pack->description->name }}
        </div>
        <div class="flex-column">
            <div class="text-muted mb-2"><i class="fas fa-ticket px-2"></i> {{ $pack->description->reference }}</div>

            @if(!empty($session))
                <div class="text-muted mb-2"><i
                        class="fas fa-calendar-alt px-2"></i>{{ $session->date_start->calendar_date }}
                    @if($session->days->count() > 1)
                        <span
                            class="bg-primary small bg-opacity-10 rounded-4 text-primary py-1 px-2 ms-2">+{{ $session->days->count()-1 }}</span>
                    @endif
                </div>

                @if($pack->type =='virtual')
                    <div class="text-muted mb-2"><i class="fas fa-location-dot px-2"></i> Où vous voulez</div>
                @else
                    <div class="text-muted mb-2"><i
                            class="fas fa-location-dot px-2"></i>{{ $session->classroom->address->city }}</div>
                @endif
            @endif

            <div class="text-muted"><i class="fas fa-clock px-2"></i>{{ $pack->time_duration }}</div>
            <div class="text-muted my-4">
                            <span class="bg-primary small bg-opacity-10 rounded-4 text-primary py-2 px-2 ms-2">
                                <i class="fas fa-user-group text-primary px-2"></i>10 places restantes</span></div>
        </div>

        <hr>
        <div class="d-flex justify-content-between align-items-sm-baseline">
            <div class="float-start">
                <span class="fw-bold">{{ empty($session) || $session->description->intra === 0?$pack->getPrice(1)->price_ht:$pack->getPrice(1)->price_ht }} € HT /</span>
                <i class="icon fas fa-user text-muted"></i>
            </div>
            <div class="float-end">
                <button class="btn btn-lg btn-secondary px-4 py-2">Acheter</button>
            </div>
        </div>
    </div>
</div>
