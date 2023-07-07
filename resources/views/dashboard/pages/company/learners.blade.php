<x-auth-layout>

        <x-content.header></x-content.header>
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active ms-0 text-dark" data-bs-toggle="tab" data-bs-target="#tab-in" type="button" role="tab" aria-controls="tab-in" aria-selected="true">
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
                @include('components.datatable._table',['table'=>$table_in])
            </div>
            <div class="tab-pane fade" id="tab-left" role="tabpanel" aria-labelledby="tab-left" >
                @include('components.datatable._table',['table'=>$table_left])
            </div>
        </div>

</x-auth-layout>
