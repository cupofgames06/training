<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="[route('of.monitoring.sessions')=>trans('of.monitoring.sessions.title'),'#'=>trans('of.monitoring.sessions.edit.title')]"></x-content.breadcrumb>
        <x-content.header title="{{ $session->title() }}" :subTitle="$session->subtitle()"></x-content.header>

        <div class="row">
            <div class="col-sm-6 d-flex align-items-stretch mb-4">
                <div class="card w-100">
                    <div class="card-header">
                        <div class="card-title text-uppercase">Détail session</div>
                    </div>
                    <div class="card-body fw-normal">
                        <p>Type : {{ trans('of.monitoring.sessions.type.'.$session->course->type) }}</p>
                        @session('physical',$session)
                            <p>Adresse : {{ isset($session->classroom->address)?$session->classroom->get_address():'-' }}</p>
                        @endsession
                        <p>Date de début : {{ $session->first_day->calendar_date.' '.$session->first_day->start }}</p>
                        <p>Date de fin : {{ $session->last_day->calendar_date.' '.$session->last_day->end }}</p>
                        <p>Durée : {{ Str::of($session->course->time_duration)->replace(':','h') }}</p>
                        <p>Prix moyen par participant : {{ $session->course->price->price_ht }}</p>
                        <p>Formateur(s) : {{ Arr::join($session->trainers->pluck('profile.full_name')->toArray(),',') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 d-flex align-items-stretch mb-4">
                <div class="card w-100">
                    <div class="card-header">
                        <div class="card-title text-uppercase">Bilan session</div>
                    </div>
                    <div class="card-body fw-normal">
                        <p>Coût de la session : {{ $session->cost }} € HT</p>
                        <p>Nombre d'apprenants : {{ $session->enrollments->count() }} </p>
                        <p>Chiffre d'affaire :</p>
                        <p>Marge (commissions déduites) :</p>
                    </div>
                </div>
            </div>
        </div>
        @include('components.datatable._table',['table'=>$table])

</x-auth-layout>
