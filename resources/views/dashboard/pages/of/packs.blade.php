<x-auth-layout>
    <div class="my-4">
        <x-content.header>
        </x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
    </div>

    <div id="">
        @include('components.datatable._table',['table'=>$table])
    </div>
</x-auth-layout>
