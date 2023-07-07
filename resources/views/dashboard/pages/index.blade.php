<x-auth-layout>

        @isset($of)
            <x-content.header subTitle="A définir avec KWU"> </x-content.header>
        @else
            <x-content.header></x-content.header>
        @endisset

</x-auth-layout>
