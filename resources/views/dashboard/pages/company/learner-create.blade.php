<x-auth-layout>
    <x-form :action="route('company.learners.store')" id="manager_create_form" v-on:submit="checkForm">
        @method('post')
        @csrf
        <x-content.breadcrumb
            :breadcrumbs="[route('company.learners.index')=>trans('company.learners.index.title'),'#'=>trans('company.learners.edit.title')]"></x-content.breadcrumb>
        <x-content.header title="{{trans('company.learners.edit.title')}}"></x-content.header>
        @include('dashboard.pages.company.partials.learner')
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')

            <x-form-submit id="manager_create" ajax="1" form_id="manager_create_form">
                {{ __('company.learners.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
