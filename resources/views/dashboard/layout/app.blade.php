<x-base-layout>
    <div class="d-flex" style="padding-top: 4.5rem">
        <x-header type="auth"></x-header>
        <div class="flex-fill content content-custom " >
            {{ $slot }}
        </div>
    </div>
</x-base-layout>




