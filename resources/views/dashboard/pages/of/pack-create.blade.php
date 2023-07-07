<x-auth-layout>

        <x-form :action="route('of.'.$pack_type.'s.store')" id="pack_create_form"
                v-on:submit="checkForm">
            @method('post')
            @csrf
            <x-content.breadcrumb
                :breadcrumbs="[route('of.'.$pack_type.'s.index')=>trans('of.'.$pack_type.'s.index.title'),'#'=>trans('of.'.$pack_type.'s.create.title')]"></x-content.breadcrumb>
            <x-content.header></x-content.header>
            @include('dashboard.pages.of.partials.pack')
        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="create_pack" ajax="1" form_id="pack_create_form">
                {{ __('of.'.$pack_type.'s.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
