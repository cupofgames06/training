<x-auth-layout>

        <x-content.breadcrumb :breadcrumbs="$breadcrumb"></x-content.breadcrumb>
        <x-content.header :title="$title">
            @include('dashboard.pages.of.monitoring._toolbar')
        </x-content.header>
        <div class="row mt-4">
            <div class="col-md-4 mb-4" id="overview-content">
                @include('components.content._loader')
            </div>
            <div class="col-lg-5 mb-4" id="indicators-content">
                @include('components.content._loader')
            </div>
            <div class="col-md-3 mb-4" id="ratings-content">
                @include('components.content._loader')
            </div>
        </div>
        <div class="mt-4">
            @include('components.datatable._table')
        </div>

</x-auth-layout>
