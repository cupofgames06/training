<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
        <x-content.header title="{{ $item->description->reference }}" :subTitle="$item->description->name"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-6 col-12">
                <x-form :action="route('of.access-rules.store',['item_type'=>$item_type,'item_id'=>$item->id])" name="store_rule_form"
                        id="store_intra_form" v-on:submit="checkForm">
                    @method('post')
                    @csrf
                    <x-form.access-rule-card :item="$item"></x-form.access-rule-card>
                </x-form>
            </div>
            <div class="col-md-6 col-12">
                @foreach($item->access_rules->sortByDesc('id') as $rule)
                    <x-form :action="route('of.access-rules.update',[$rule->id])"
                            name="update_rule_form_{{ $rule->id }}"
                            id="update_rule_form_{{ $rule->id }}" v-on:submit="checkForm">
                        @method('patch')
                        @csrf
                        <x-form.access-rule-card :item="$item" :id="$rule->id" name="{{  'Règle n°'.$item->access_rules->count()-$loop->index }}"></x-form.access-rule-card>
                    </x-form>
                @endforeach
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {
                let rules = $('.access-rule');
                rules.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });
        </script>
    @endpush
</x-auth-layout>
