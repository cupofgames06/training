<x-auth-layout>
    <div class="my-4">
        <x-content.header></x-content.header>
    </div>

    @include('components.datatable._table',['table'=>$table])

</x-auth-layout>
