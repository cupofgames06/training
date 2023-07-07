<x-auth-layout>

    <x-form :action="route('of.sessions.store')" id="session_create_form"
            v-on:submit="checkForm">
        @method('post')
        @csrf

        <x-content.breadcrumb
            :breadcrumbs="[route('of.sessions.index')=>trans('of.sessions.index.title'),'#'=>trans('of.sessions.create.title')]"></x-content.breadcrumb>
        <x-content.header></x-content.header>
        @include('dashboard.pages.of.partials.session')

    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="create_session" ajax="1" form_id="session_create_form">
                {{ __('of.sessions.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
