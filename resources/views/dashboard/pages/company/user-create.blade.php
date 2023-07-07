<x-auth-layout>

    <x-form :action="route('company.users.store')" id="manager_create_form" v-on:submit="checkForm">
        @method('post')
        @csrf
        <x-content.breadcrumb :breadcrumbs="[route('company.users.index')=>trans('common.manager.index.title'),'#'=>trans('common.manager.create.title')]"></x-content.breadcrumb>
        <x-content.header title="{{trans('common.manager.create.title')}}" sub_title="{{trans('common.manager.create.subtitle')}}"></x-content.header>
        @include('dashboard.partials.user')
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="manager_create" ajax="1" form_id="manager_create_form">
                {{ __('common.manager.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
