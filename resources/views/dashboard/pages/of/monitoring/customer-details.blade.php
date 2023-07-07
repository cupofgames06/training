<x-auth-layout>

        <x-content.breadcrumb :breadcrumbs="$breadcrumb"></x-content.breadcrumb>

        <div class="card rounded-4 my-4">
            <div class="card-header rounded-4 d-flex justify-content-between">
                <h3 class="fw-bold text-primary">{{ $item->entity?$item->entity->name:null }}</h3>
                @include('dashboard.pages.of.monitoring._toolbar')
            </div>
            <div class="card-body d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <span class="fw-normal">{{ $item->get_address() }}</span>
                    <span>SIRET : <span class="fw-normal">{{ $item->entity->reg_number }}</span></span>
                    <span>Représentant légal :</span>
                    <span class="fw-normal">{{ $item->managers->first()->profile->full_name }} - {{ $item->managers->first()->profile->phone_1 }}</span>
                </div>
                <div class="d-flex flex-column">
                    <span>Administrateurs compte Société : </span>
                    @foreach($item->managers as $manager)
                        <span class="fw-normal">{{ $manager->profile->full_name }} - {{ $manager->profile->phone_1 }} - {{ $manager->profile->phone_1 }}</span>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" id="overview-content">
                @include('components.content._loader')
            </div>
            <div class="col-md-5 mb-4" id="indicators-content">
                @include('components.content._loader')
            </div>
            <div class="col-md-3 mb-4" id="ratings-content">
                @include('components.content._loader')
            </div>
        </div>

        <div class="mb-4">
            <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab-in" type="button" role="tab" aria-controls="tab-in" aria-selected="true">
                        {{ trans(Route::currentRouteName() . '.tab_nav.in') }}
                        <span class="badge bg-primary-100 rounded-4 text-primary"> {{ $count_in }} </span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab-left" type="button" role="tab" aria-controls="tab-left" aria-selected="true">
                        {{ trans(Route::currentRouteName() . '.tab_nav.left') }}
                        <span class="badge bg-primary-100 rounded-4 text-primary"> {{ $count_left }} </span>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="content">
                <div class="tab-pane fade show active" id="tab-in" role="tabpanel" aria-labelledby="tab-in">
                    @include('components.datatable._table',['table'=>$table])
                </div>
                <div class="tab-pane fade" id="tab-left" role="tabpanel" aria-labelledby="tab-left" >
                    @include('components.datatable._table',['table'=>$table_left])
                </div>
            </div>

        </div>


</x-auth-layout>
