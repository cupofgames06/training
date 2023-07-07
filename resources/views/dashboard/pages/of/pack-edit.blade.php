<x-auth-layout>

    <x-content.breadcrumb
        :breadcrumbs="[route('of.'.$pack_type.'s.index')=>trans('of.'.$pack_type.'s.index.title'),'#'=>trans('of.'.$pack_type.'s.edit.title')]"></x-content.breadcrumb>
    <x-content.header title="{{ $pack->description->reference }}"
                      :subTitle="$pack->description->name"></x-content.header>
    <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>

    <x-form :action="route('of.'.$pack_type.'s.update',['pack'=>$pack])" id="pack_edit_form"
            v-on:submit="checkForm">
        @method('patch')
        @csrf
        @include('dashboard.pages.of.partials.pack',['pack'=>$pack])
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            @slot('buttons')
                <button class="btn btn-outline-danger me-3"
                        data-type="delete"
                        data-title="Supprimer ce pack?"
                        data-url="{{ route('of.packs.destroy',['pack'=>$pack]) }}"><i class="fal fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>

                <a class="btn btn-outline-dark me-3"
                   href="{{ $pack->preview_url  }}"><i
                        class="far fa-eye"></i> <span
                        class="d-none d-md-inline">{{ __('common.preview') }}</span></a>


                @if($pack->status == 'active')

                    <button id=""
                            data-type="toggle-status"
                            data-title="Retirer {{ $pack->description->name }} de la mise en ligne?"
                            data-url="{{ route('of.packs.toggle-status',[ 'pack'=>$pack, 'status'=>'inactive']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Retirer de la mise en ligne</span></button>

                @else

                    <button id=""
                            data-type="toggle-status"
                            data-title="Mettre en ligne {{ $pack->description->name }}?"
                            data-url="{{ route('of.packs.toggle-status',[ 'pack'=>$pack, 'status'=>'active']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Mettre en ligne</span></button>

                @endif


            @endslot
            <x-form-submit id="create_pack" ajax="1" form_id="pack_edit_form">
                {{ __('of.'.$pack_type.'s.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush

</x-auth-layout>
