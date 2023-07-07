<x-auth-layout>

        <x-content.breadcrumb :breadcrumbs="$breadcrumb"></x-content.breadcrumb>
        <x-content.header :title="$title">
            @include('dashboard.pages.company.components._toolbar')
        </x-content.header>
        <div class="row">
            <div class="col-sm-4" id="overview-content">
                @include('components.content._loader')
            </div>
            <div class="col-sm-5" id="indicators-content">
                @include('components.content._loader')
            </div>
            <div class="col-sm-3" id="ratings-content">
                @include('components.content._loader')
            </div>
        </div>
        <div class="mt-4">
            @include('components.datatable._table')
        </div>

</x-auth-layout>
