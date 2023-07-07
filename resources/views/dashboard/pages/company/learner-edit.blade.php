<x-auth-layout>
        <x-form :action="route('company.learners.update',[$learner])" id="manager_create_form" v-on:submit="checkForm">
            @method('patch')
            @csrf
            <x-content.breadcrumb
                :breadcrumbs="[route('company.learners.index')=>trans('company.learners.index.title'),'#'=>trans('company.learners.edit.title')]"></x-content.breadcrumb>
            <x-content.header title="{{trans('company.learners.edit.title')}}"></x-content.header>
            @include('dashboard.pages.company.partials.learner')
        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')

            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-url="{{ route('company.learners.delete',['learner'=>$learner]) }}"
                        data-type="delete"><i class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>

            @endslot

            <x-form-submit id="manager_create" ajax="1" form_id="manager_create_form">
                {{ __('company.learners.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
