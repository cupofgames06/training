<x-auth-layout>

    <x-page-title :toolbar="$toolbar??null"></x-page-title>

    <div class="grid grid-cols-2 gap-9">
        <div class="bg-white border-0 rounded-lg my-8">
            <div class="flex flex-row items-center border-b border-gray-100 space-x-2 p-4">
                <img  class="w-6 h-6" src="{{ asset('resources/media/svg/user-circle.svg') }}">
                <span class="font-bold"> Société</span>
            </div>
            <div class="p-4">
                <x-form-input name="company"></x-form-input>
            </div>
        </div>
        <div class="bg-white border-0 rounded-lg my-8">
            <div class="flex flex-row items-center border-b space-x-2 p-4">
                <img  class="w-6 h-6" src="{{ asset('resources/media/svg/user-circle.svg') }}">
                <span class="font-bold"> Représentant</span>
            </div>
        </div>
    </div>

</x-auth-layout>
