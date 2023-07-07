<x-auth-layout>

    <x-content.header title="{{ trans('common.manager.index.title') }}"></x-content.header>
    <div class="mt-4">
        @include('components.datatable._table')
    </div>


</x-auth-layout>
