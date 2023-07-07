<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="[
    route('of.sessions.index')=>trans('of.sessions.index.title'),
    route('of.sessions.edit',['session'=>$item])=>trans('of.sessions.edit.title'),
    '#'=>trans('of.session_trainers.title')
    ]"></x-content.breadcrumb>
        <x-content.header title="{{ $item->title() }}" :subTitle="$item->subtitle()"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-6 col-12">
                <x-form :action="route('of.sessions.store_trainer',[$item])" name="course_create_session_trainer_form"
                        id="course_create_session_trainer_form" v-on:submit="checkForm">
                    @method('patch')
                    @csrf
                    <x-form.session-trainer-card :item="$item"></x-form.session-trainer-card>
                </x-form>
            </div>
            <div class="col-md-6 col-12">
                <?php $i = $item->trainers->count() ?>
                @foreach($item->trainers->sortByDesc('id') as $sessionTrainer)
                    <x-form :action="route('of.sessions.update_trainer',[$item,$sessionTrainer->pivot->id])"
                            name="update_trainer_form_{{ $sessionTrainer->id }}"
                            id="update_trainer_form_{{ $sessionTrainer->id }}" v-on:submit="checkForm">
                        @method('patch')
                        @csrf
                        <x-form.session-trainer-card :item="$item" :datas="$sessionTrainer"></x-form.session-trainer-card>
                    </x-form>
                @endforeach
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {

                let items = $('.session-trainer');
                items.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });

        </script>
    @endpush
</x-auth-layout>
