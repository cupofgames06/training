<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="[
    route('of.sessions.index')=>trans('of.sessions.index.title'),
    route('of.sessions.edit',['session'=>$item])=>trans('of.sessions.edit.title'),
    '#'=>trans('of.session_days.title')
    ]"></x-content.breadcrumb>
        <x-content.header title="{{ $item->title() }}" :subTitle="$item->subtitle()"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-6 col-12">
                <x-form :action="route('of.sessions.store_day',[$item])" name="course_create_day_form"
                        id="course_create_day_form" v-on:submit="checkForm">
                    @method('patch')
                    @csrf
                    <x-form.session-day-card :session="$item"></x-form.session-day-card>
                </x-form>
            </div>
            <div class="col-md-6 col-12">
                <?php $i = 1;  ?>
                @foreach($item->days->sortBy('date') as $day)

                    <x-form :action="route('of.sessions.update_day',[$item,$day])"
                            name="update_day_form_{{ $day->id }}"
                            id="update_day_form_{{ $day->id }}" v-on:submit="checkForm">
                        @method('patch')
                        @csrf
                        <x-form.session-day-card :session="$item" :sessionDay="$day">{{ $day->calendar_date }}</x-form.session-day-card>
                    </x-form>
                @endforeach
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {

                let items = $('.day');
                items.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });
        </script>
    @endpush
</x-auth-layout>
