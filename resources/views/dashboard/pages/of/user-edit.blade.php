<x-auth-layout>

        <x-form :action="route('of.users.update',[$user])" id="manager_create_form" v-on:submit="checkForm">
            @method('patch')
            @csrf
            <x-content.breadcrumb
                :breadcrumbs="[route('of.users.index')=>trans('common.manager.index.title'),'#'=>trans('common.manager.create.title')]"></x-content.breadcrumb>
            <x-content.header title="{{trans('common.manager.edit.title')}}"></x-content.header>
            @include('dashboard.partials.user')
        </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')

            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-url="{{ route('of.users.delete',['user'=>$user]) }}"
                        data-title="Supprimer définitivement<br> cet utilisateur?"
                        data-type="delete"><i class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>
            @endslot

            @empty($user->password)
                <span class="text-danger me-3 d-none d-md-flex align-self-center">Cet utilisateur n'a pas encore choisi son mot de passe</span>
                <button class="btn btn-outline-danger me-3"
                        data-url="{{ route('of.users.reinvite',['user'=>$user]) }}"
                        data-type="reinvite"><i class="fal fa-bell"></i>
                    <span class="d-none d-md-inline">{{ __('common.reinvite') }}</span></button>
            @endif

            <x-form-submit id="manager_create" ajax="1" form_id="manager_create_form">
                {{ __('common.manager.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush
</x-auth-layout>
