<x-quiz-layout>
    @foreach($page->modules->sortBy('position') as $module)
            <x-form.quiz.base-module :module="$module"></x-form.quiz.base-module>
    @endforeach

    @if(!empty($preview))
        @push('sticky-footer')
            @component('components.content._sticky-footer')
                <a class="btn btn-outline-dark me-3"
                   href="{{ $preview['editor_url']  }}"><i class="fal fa-backward-step"></i>
                    <span class="d-none d-md-inline">{{ __('of.courses.back') }}</span></a>
            @endcomponent
        @endpush
    @endif
</x-quiz-layout>


