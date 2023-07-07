<x-auth-layout>

        <x-form :action="route('of.classrooms.store')" id="classroom_create_form"
                v-on:submit="checkForm">
            @method('post')
            @csrf
                    <x-content.breadcrumb
                        :breadcrumbs="[route('of.classrooms.index')=>trans('of.classrooms.index.title'),'#'=>trans('of.classrooms.create.title')]"></x-content.breadcrumb>
                    <x-content.header></x-content.header>
                    @include('dashboard.pages.of.partials.classroom')

        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="classroom_create" ajax="1" form_id="classroom_create_form">
                {{ __('of.classrooms.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
