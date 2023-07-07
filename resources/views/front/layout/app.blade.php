<x-base-layout>
    <x-header type="guest"></x-header>
    <div class="container container-fluid" style="margin-top:120px;margin-bottom: 230px">
        {{ $slot }}
    </div>
    <x-footer type="guest"></x-footer>
    @section('body-class','min-vh-100 position-relative pb-5')
</x-base-layout>




