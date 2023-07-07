<x-auth-layout>

    <x-content.breadcrumb
        :breadcrumbs="[route('of.sessions.index')=>trans('of.sessions.index.title'),'#'=>trans('of.sessions.edit.title')]"></x-content.breadcrumb>
    <x-content.header title="{{ $session->title() }}" :subTitle="$session->subtitle()"></x-content.header>
    <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>

    <x-form :action="route('of.sessions.update',['session'=>$session])" id="session_edit_form"
            v-on:submit="checkForm">
        @method('patch')
        @csrf
        @include('dashboard.pages.of.partials.session',['session'=>$session])
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-type="delete"
                        data-title="Supprimer cette session?"
                        data-url="{{ route('of.sessions.destroy',['session'=>$session]) }}"><i
                        class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>

                <a class="btn btn-outline-secondary me-3"
                   href="{{ $session->preview_url }}"><i
                        class="far fa-eye"></i> <span
                        class="d-none d-md-inline">{{ __('common.preview') }}</span></a>

                @if($session->status == 'active')

                    <button id=""
                            data-type="toggle-status"
                            data-title="Retirer la formation {{ $session->description->name }} de la mise en ligne?"
                            data-url="{{ route('of.sessions.toggle-status',[ 'session'=>$session, 'status'=>'inactive']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Retirer de la mise en ligne</span></button>

                @else

                    <button id=""
                            data-type="toggle-status"
                            data-title="Mettre en ligne la formation {{ $session->description->name }}?"
                            data-url="{{ route('of.sessions.toggle-status',[ 'session'=>$session, 'status'=>'active']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Mettre en ligne</span></button>

                @endif

            @endslot
            <x-form-submit id="create_session" ajax="1" form_id="session_edit_form">
                {{ __('of.sessions.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush


</x-auth-layout>
