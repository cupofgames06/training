@php($items = !empty($module->content['items'])?$module->content['items']:[])
<div data-type="quiz-accordion">

    @isset($items)
        @foreach($items as $item)
            @component('components.form.quiz.modules.content-accordion-item')
                @slot('module',$module)
                @slot('position',$loop->index)
                @slot('item',$item)
            @endcomponent
        @endforeach
    @endisset

    <div class="d-flex">
        <button type="button"
                data-url="{{ route('of.quizzes.store_accordion_item',[$module->id]) }}"
                data-type="add-accordion-item" data-module="{{$module->id}}"
                id="addAccordionItem{{$module->id}}"
                class="btn btn-round btn-outline-secondary opacity-75"><i
                class="rounded-circle far fa-lg fa-plus"></i></button>
    </div>

</div>
