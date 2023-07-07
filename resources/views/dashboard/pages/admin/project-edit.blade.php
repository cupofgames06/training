<x-auth-layout>
    <x-content.breadcrumb
        :breadcrumbs="[route('of.courses.index')=>trans('of.courses.index.title'),'#'=>trans('of.courses.edit.title')]"></x-content.breadcrumb>
    <x-content.header title="{{ $course->description->reference }}"
                      :subTitle="$course->description->name"></x-content.header>
    <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>

    <x-form :action="route('of.courses.update',['course'=>$course])" id="course_edit_form"
            v-on:submit="checkForm">
        @method('patch')
        @csrf
        @include('dashboard.pages.of.partials.course',['course'=>$course])
    </x-form>

    @push('sticky-footer')
        @component('components.content._sticky-footer')
            @slot('buttons')
                <button class="btn btn-outline-danger me-3" data-type="delete"
                        data-title="Supprimer cette formation et son contenu?"
                   data-url="{{ route('of.courses.destroy',['course'=>$course]) }}"><i class="far fa-trash-alt"></i>
                    <span class="d-none d-md-inline">{{ __('common.delete') }}</span></button>

                <a class="btn btn-outline-secondary me-3"
                   href="{{ $course->preview_url  }}"><i
                        class="far fa-eye"></i> <span
                        class="d-none d-md-inline">{{ __('common.preview') }}</span></a>

                @if($course->status == 'active')

                    <button id=""
                            data-type="toggle-status"
                            data-title="Retirer la formation {{ $course->description->name }} de la mise en ligne?"
                            data-url="{{ route('of.courses.toggle-status',[ 'course'=>$course, 'status'=>'inactive']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Retirer de la mise en ligne</span></button>

                @else

                    <button id=""
                            data-type="toggle-status"
                            data-title="Mettre en ligne la formation {{ $course->description->name }}?"
                            data-url="{{ route('of.courses.toggle-status',[ 'course'=>$course, 'status'=>'active']) }}"
                            class="btn btn-secondary me-3"><i class="fal fa-wave-pulse"></i> <span
                            class="d-none d-md-inline">Mettre en ligne</span></button>

                @endif


            @endslot
            <x-form-submit id="create_course" ajax="1" form_id="course_edit_form">
                {{ __('of.courses.edit.btn') }}
            </x-form-submit>
        @endcomponent
    @endpush

</x-auth-layout>
