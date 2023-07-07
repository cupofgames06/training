<x-auth-layout>

    <x-content.breadcrumb
        :breadcrumbs="[route('of.trainers.index')=>trans('of.trainers.index.title'),'#'=>trans('of.trainers.edit.title')]"></x-content.breadcrumb>
    <x-content.header title="{{ $trainer->name }}" :subTitle="$trainer->name"></x-content.header>

    <x-form :action="route('of.trainers.update',['trainer'=>$trainer])" id="trainer_edit_form"
            v-on:submit="checkForm">
        @method('patch')
        @csrf
        @include('dashboard.pages.of.partials.trainer',['trainer'=>$trainer])
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-type="delete"
                        data-url="{{ route('of.trainers.destroy',['trainer'=>$trainer]) }}"><i
                        class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ 'Retirer de mes formateurs' }}</span></button>
            @endslot
            <x-form-submit id="edit_trainer" ajax="1" form_id="trainer_edit_form">
                {{ __('of.trainers.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush


</x-auth-layout>
