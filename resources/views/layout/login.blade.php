<x-base-layout>
    <div class="d-flex vh-100">
        <x-header type="guest"></x-header>
        <div class="flex-fill overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</x-base-layout>





