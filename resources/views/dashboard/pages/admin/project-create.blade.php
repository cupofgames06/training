<x-auth-layout>

    <x-form :action="route('of.courses.store')" id="course_create_form"
            v-on:submit="checkForm">
        @method('post')
        @csrf
        <x-content.breadcrumb
            :breadcrumbs="[route('of.courses.index')=>trans('of.courses.index.title'),'#'=>trans('of.courses.create.title')]"></x-content.breadcrumb>
        <x-content.header></x-content.header>
        @include('dashboard.pages.of.partials.course')
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="create_course" ajax="1" form_id="course_create_form">
                {{ __('of.courses.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
