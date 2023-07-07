<x-auth-layout>

    <x-content.breadcrumb
        :breadcrumbs="[route('of.classrooms.index')=>trans('of.classrooms.index.title'),'#'=>trans('of.classrooms.edit.title')]"></x-content.breadcrumb>
    <x-content.header title="{{ $classroom->name }}" :subTitle="$classroom->name"></x-content.header>

    <x-form :action="route('of.classrooms.update',['classroom'=>$classroom])" id="classroom_edit_form"
            v-on:submit="checkForm">
        @method('patch')
        @csrf
        @include('dashboard.pages.of.partials.classroom',['classroom'=>$classroom])
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-type="delete"
                        data-title="Supprimer cette salle?"
                        data-url="{{ route('of.classrooms.destroy',['classroom'=>$classroom]) }}"><i
                        class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>
            @endslot
            <x-form-submit id="edit_classroom" ajax="1" form_id="classroom_edit_form">
                {{ __('of.classrooms.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush


</x-auth-layout>
