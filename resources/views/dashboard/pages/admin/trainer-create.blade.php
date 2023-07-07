<x-auth-layout>

        <x-form :action="route('of.trainers.store')" id="trainer_create_form"
                v-on:submit="checkForm">
            @method('post')
            @csrf
                    <x-content.breadcrumb
                        :breadcrumbs="[route('of.trainers.index')=>trans('of.trainers.index.title'),'#'=>trans('of.trainers.edit.title')]"></x-content.breadcrumb>
                    <x-content.header></x-content.header>
                    @include('dashboard.pages.of.partials.trainer')

        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="trainer_create" ajax="1" form_id="trainer_create_form">
                {{ __('of.trainers.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
