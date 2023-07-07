<div class="card mb-4 overflow-hidden aside-summary">

    @isset($course->description->video)

        <button class="btn position-absolute w-100">
            <i class="fas fa-youtube-play" id="playVideo">jlk</i>
        </button>

    @endisset

    {{ $course->description->aside_image }}

    <div class="card-body">
        <div class="pb-3 title">
            {{ $course->description->name }}
        </div>
        <div class="flex-column">
            <div class="indication"><i class="fas fa-tag fa-sm"></i> {{ $course->description->reference }}</div>

            @if(!empty($session))
                @if(!empty($session->first_day))
                    <div class="indication"><i
                            class="fas fa-calendar-day fa-sm"></i> {{ $session->first_day->calendar_date }}
                        @if($session->days->count() > 1)
                            <span
                                class="bg-primary small bg-opacity-10 rounded-4 text-primary py-1 px-2 ms-2">+{{ $session->days->count()-1 }}</span>
                        @endif
                    </div>
                @endif
                @if($course->type =='virtual')
                    <div class="indication"><i class="fas fa-sm  fa-location-dot"></i> Où vous voulez</div>
                @else
                    <div class="indication text-muted mb-2"><i
                            class="fas fa-sm fa-location-dot"></i> {{ $session->classroom->address->city }}</div>
                @endif

            @else
                {{-- elearning --}}
                <div class="indication"><i class="fas fa-sm fa-calendar-day"></i> Quand vous voulez</div>
                <div class="indication"><i class="fas fa-location-dot"></i> Où vous voulez</div>
            @endif

            <div class="indication"><i class="fas fa-sm fa-clock"></i> {{ $course->time_duration }}</div>
            @isset($monitoring)
            @else
                <div class="text-muted my-4">
                    <span class="bg-primary small bg-opacity-10 rounded-4 text-primary py-2 px-3">
                        <i class="fas fa-user-group text-primary"></i> 10 places restantes
                    </span>
                </div>
            @endif
        </div>

        <hr>
        @isset($monitoring)
            <div class="d-flex flex-row">
                <span class="small me-2">{{ $progress }}%</span>
                <div class="w-100 ">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Example with label"
                             style="width: {{$progress}}%;" aria-valuenow="{{$progress}}" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                </div>

            </div>
        @else
            <div class="d-flex justify-content-between align-items-sm-baseline">
                <div class="float-start">
                    <span class="fw-bold">{{ empty($session) || $session->description->intra === 0?$course->getPrice(1)->price_ht:$course->getPrice(1)->price_ht }} € HT /</span>
                    <i class="icon fas fa-user text-muted"></i>
                </div>
                <div class="float-end">
                    <button class="btn btn-lg btn-secondary px-4 py-2">Acheter</button>
                </div>
            </div>
        @endisset

    </div>
</div>
@isset($monitoring)
    @include('front.pages.offers.partial.card.ratings')
    @include('front.pages.offers.partial.card.documents')
@endisset
@isset($course->description->video)
    <div id="youtube" class="d-none">
        @component('components.content._youtube')
            @slot('id', $course->description->video)
        @endcomponent
    </div>
@endisset
@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {
            @isset($course->description->video)
            $('#playVideo').on('click', function () {
                Swal.fire({
                    title: '{{ $course->description->name }}',
                    html: $('#youtube').html(),
                    width: '1280px',
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                    focusConfirm: false,
                });
            })
            @endisset
        });
    </script>
@endpush

