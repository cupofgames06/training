<x-auth-layout>

        <x-content.breadcrumb
            :breadcrumbs="$breadcrumbs"></x-content.breadcrumb>
        <x-content.header title="{{ $pack->description->reference }}"
                          :subTitle="$pack->description->name"></x-content.header>
        <x-content.nav-tab :items="$tab_nav"></x-content.nav-tab>
        <div class="row">
            <div class="col-md-5 col-12">
                <x-form.packable-card :pack="$pack"></x-form.packable-card>
            </div>
            <div class="col-md-7 col-12">
                <div id="elearnings-packables">
                    @foreach($pack->elearnings->sortBy( function($elm) use($pack){ return $elm->packables()->where('pack_id' ,$pack->id)->first()->position; }) as $packable)
                        <x-form.packable-card :pack="$pack" :packable="$packable"></x-form.packable-card>
                    @endforeach
                </div>
                @if( $pack->type == 'blended')
                    @foreach($pack->ordered_sessions() as $packable)
                        <x-form.packable-card :pack="$pack" :packable="$packable"></x-form.packable-card>
                    @endforeach
                @endif
            </div>
        </div>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", function (event) {
                let rules = $('.packable');
                rules.each(function () {
                    $(this).find('.delete').click(window.deleteElement);
                });
            });

            let elearnings = document.getElementById('elearnings-packables');
            let sortableElearnings = new Sortable(elearnings, {
                animation: 150,
                draggable: ".packable",
                onEnd: function (evt) {
                    let dropItem = $(evt.item);
                    updatePosition(dropItem);

                }
            });

            function updatePosition() {

                let position = [];
                $(elearnings).find('.packable').each(
                    function () {

                        position.push({
                            id: $(this).attr('data-id'),
                            position: $(this).index()
                        });

                    });

                $.ajax({
                    type: 'post',
                    url: '{{ route('of.packs.update_position') }}',
                    data: {
                        position: position,
                    },
                    dataType: 'json',
                    success: function (data) {

                    }
                });

            }

        </script>
    @endpush
</x-auth-layout>
