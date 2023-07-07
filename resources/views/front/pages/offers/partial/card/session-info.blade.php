<div class="card mb-4">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                {{ __('front.courses.show.detail_title') }}
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="d-flex flex-column">
                    @foreach($course->indicators as $indicator)
                        <div class="tag @if(!$loop->last) mb-2 @endif"><i
                                class="far fa-award pe-2"></i>{{ $indicator->name }}
                            +{{ $indicator->pivot->value }} {{ $indicator->unit }} </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Lieu</div>
                @if($course->type =='virtual')
                    <div class="pb-2 mb-1"><i class="fas fa-location-dot text-muted fa-lg"></i> Où vous voulez</div>
                @else
                    <div class="pb-2 mb-1"><i
                            class="fas fa-location-dot text-muted fa-lg"></i> {{ $session->classroom->address->city }}
                        ({{ $session->classroom->address->postal_code }})
                    </div>
                    <div class="pb-2 mb-1">
                        {!! $session->classroom->address_number().', '.$session->classroom->address_street() !!}
                        {!! !empty($session->classroom->address_complement())?', '.$session->classroom->address_complement():'' !!}
                        {!! '<br>'.$session->classroom->name !!}
                    </div>
                    @if($session->classroom->pmr == 1)
                        <div><i class="fas fa-check-square text-muted fa-lg pe-2"></i>Accessibilité PMR</div>
                    @endif

                    @if(!empty($session->offer->psh_accessibility))
                        <div><i class="fas fa-check-square text-muted fa-lg pe-2"></i>Accessibilité PSH</div>
                        <div>
                            {!! $session->offer->psh_accessibility !!}
                        </div>
                    @endif

                @endif
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card-subtitle">Dates</div>
                @foreach($session->days->sortBy('date') as $day)
                    <div class="row mb-1">
                        <div class="col-6">
                            <i class="far fa-calendar-day text-muted"></i> {{ $day->calendar_date }}
                        </div>
                        <div class="col-6">
                            <i class="far fa-timer text-muted"></i> {{ $day->start.'-'.$day->end }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-4 col-md-12">
                @if($session->trainers->count() > 0)
                    <div class="card-subtitle text-muted">Formateurs</div>
                    @foreach($session->trainers as $trainer)
                        <div class="row  mb-1  mb-1">

                            <div class="col-12 text-primary">
                                <i class="far fa-user-circle"></i> {{ $trainer->profile->fullname }}
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <i class="far fa-star text-muted"></i> {{ $trainer->averageRating($course,1)??'-' }}
                                    /10
                                </div>
                                <div class="col-6">
                                    <i class="far fa-comment-alt text-muted"></i> {{ $trainer->numberOfRatings($course) }}
                                    avis
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif
                <div class="row mt-3 mb-1  mb-1">

                    <div class="col-12 text-primary">
                        <div class="card-subtitle text-muted">Organisme</div>
                        <i class="far fa-buildings"></i> {{ $course->of->entity->name }}
                    </div>
                    <div class="row my-1">
                        <div class="col-6">
                            <i class="far fa-star text-muted"></i> {{ $course->of->averageRating($course,1)??'-' }} /10
                        </div>
                        <div class="col-6">
                            <i class="far fa-comment-alt text-muted"></i> {{ $course->of->numberOfRatings($course) }}
                            avis
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
