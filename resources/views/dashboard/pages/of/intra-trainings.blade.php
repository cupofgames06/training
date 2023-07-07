<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
        <x-content.header title="{{ $title }}" :subTitle="$subtitle"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-6 col-12">
                <x-form :action="route('of.intra-trainings.store',['item_type'=>$item_type,'item_id'=>$item->id])" name="store_intra_form"
                        id="store_intra_form" v-on:submit="checkForm">
                    @method('post')
                    @csrf
                    <x-form.intra-training-card :item="$item"></x-form.intra-training-card>
                </x-form>
            </div>
            <div class="col-md-6 col-12">
                @foreach($item->intra_trainings->sortByDesc('id') as $intra_training)
                    <x-form :action="route('of.intra-trainings.update',[$intra_training])"
                            name="update_intra_form_{{ $intra_training->id }}"
                            id="update_intra_form_{{ $intra_training->id }}" v-on:submit="checkForm">
                        @method('patch')
                        @csrf
                        <x-form.intra-training-card :item="$item" :intra="$intra_training"></x-form.intra-training-card>
                    </x-form>
                @endforeach
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {
                let items = $('.intra-training');
                items.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });
        </script>
    @endpush

</x-auth-layout>
