<x-auth-layout>

        <x-content.breadcrumb :breadcrumbs="$breadcrumb"></x-content.breadcrumb>
        <x-content.header :title="$title">
            @include('dashboard.pages.company.components._toolbar')
        </x-content.header>
        <div class="row">
            <div class="col-sm-4">
                <div class="card rounded-4" style="height: 100%">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-4">
                            <h3>Synthèse</h3>
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-calendar"></i>
                                Année 2023
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="chart"></div>
                            </div>
                            <div class="col-sm-6 ps-4">
                                <div class="d-flex flex-column h-100 justify-content-center ms-4 ps-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fa-light fa-user-group me-1"></i> {{ $company->learners->count() }}
                                    </div>

                                    <div class="d-flex align-items-start mb-3">
                                        <span class="p-2 bg-primary border rounded-circle me-2"></span>
                                        <div class="d-flex flex-column align-content-end">
                                            <span style="line-height: 1">Terminées</span>
                                            <span class="fw-lighter">12 <span class="text-muted">| </span> 120h</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start mb-3">
                                        <span class="p-2 bg-primary-300 border rounded-circle me-2"></span>
                                        <div class="d-flex flex-column align-content-end">
                                            <span style="line-height: 1">En cours</span>
                                            <span class="fw-lighter">12 <span class="text-muted">| </span> 120h</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-3">
                                        <span class="p-2 bg-primary-100 border rounded-circle me-2"></span>
                                        <div class="d-flex flex-column align-content-end">
                                            <span style="line-height: 1">A faire</span>
                                            <span class="fw-lighter">12 <span class="text-muted">| </span> 120h</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5" id="indicators-content">
                @include('components.content._loader')
            </div>
            <div class="col-sm-3" id="ratings-content">
                @include('components.content._loader')
            </div>
        </div>
        <div class="mt-4">
            {!! $table??null !!}
        </div>

</x-auth-layout>
