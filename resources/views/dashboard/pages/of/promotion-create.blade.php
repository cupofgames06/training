<x-auth-layout>

        <x-form :action="route('of.promotions.store')" id="promotion_create_form"
                v-on:submit="checkForm">
            @method('post')
            @csrf
                    <x-content.breadcrumb
                        :breadcrumbs="[route('of.promotions.index')=>trans('of.promotions.index.title'),'#'=>trans('of.promotions.create.title')]"></x-content.breadcrumb>
                    <x-content.header></x-content.header>
                    @include('dashboard.pages.of.partials.promotion')

        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            <x-form-submit id="promotion_create" ajax="1" form_id="promotion_create_form">
                {{ __('of.promotions.create.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
