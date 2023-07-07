<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="[route('of.promotions.index')=>trans('of.promotions.index.title'),'#'=>trans('of.promotions.edit.title')]"></x-content.breadcrumb>
        <x-content.header title="{{ $promotion->name }}" :subTitle="$promotion->name"></x-content.header>

            <x-form :action="route('of.promotions.update',['promotion'=>$promotion])" id="promotion_edit_form"
                    v-on:submit="checkForm">
                @method('patch')
                @csrf
                @include('dashboard.pages.of.partials.promotion',['promotion'=>$promotion])
            </x-form>

            @push('sticky-footer')
                @component('components.content._sticky-footer')
                    @slot('buttons')
                        <a class="btn btn-outline-danger me-3"
                           href="{{ route('of.promotions.destroy',['promotion'=>$promotion]) }}"><i class="fal fa-trash-alt"></i>
                            <span class="d-none d-md-inline">{{ __('common.delete') }}</span></a>
                    @endslot
                    <x-form-submit id="edit_promotion" ajax="1" form_id="promotion_edit_form">
                        {{ __('of.promotions.edit.btn') }}
                    </x-form-submit>
                @endcomponent
            @endpush


</x-auth-layout>
