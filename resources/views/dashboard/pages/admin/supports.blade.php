<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
        <x-content.header :title="$title" :subTitle="$subtitle"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-6 col-12">
                <x-form :action="route('of.supports.store',['item_type'=>$item_type,'item_id'=>$item->id])" name="course_create_support_form"
                        id="course_create_support_form" v-on:submit="checkForm">
                    @method('post')
                    @csrf
                    <x-form.support-card :item="$item"></x-form.support-card>
                </x-form>
            </div>
            <div class="col-md-6 col-12">
                <?php $i = $item->supports->count() ?>
                @foreach($item->supports->sortByDesc('id') as $support)
                    <x-form :action="route('of.supports.update',[$support])"
                            method="post"
                            name="update_support_form_{{ $support->id }}"
                            id="update_support_form_{{ $support->id }}" v-on:submit="checkForm">
                        @method('patch')
                        @csrf
                        <x-form.support_card :item="$item" :support="$support"></x-form.support_card>
                    </x-form>
                @endforeach
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {

                let rules = $('.support');
                rules.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });
        </script>
    @endpush
</x-auth-layout>
