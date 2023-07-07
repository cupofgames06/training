<x-base-layout>
    <div class="d-flex vh-100" style="padding-top: 4.5rem">
        <x-header type="auth"></x-header>
        <div class="flex-fill">
            {{ $slot }}
        </div>
    </div>
</x-base-layout>





