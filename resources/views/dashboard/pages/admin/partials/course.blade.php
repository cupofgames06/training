<div class="row">
    <div class="col-md-12 col-lg-6 mb-4">
        @include('dashboard.pages.of.partials.cards.course-infos',['course'=>!empty($course)?$course:null])
        @include('dashboard.pages.of.partials.cards.offer-resources',[
            'description'=>!empty($course)?$course->description:null,
            'url'=> route('of.courses.upload_image')
        ])

        @include('dashboard.pages.of.partials.cards.promo-message',['description'=>!empty($course)?$course->description:null])
        @include('dashboard.pages.of.partials.cards.learner-message',['description'=>!empty($course)?$course->description:null])
        @include('dashboard.pages.of.partials.cards.course-indicators',['course'=>!empty($course)?$course:null])
        @include('dashboard.pages.of.partials.cards.internal-comment',['description'=>!empty($course)?$course->description:null])

        @foreach(App\Models\PriceLevel::get() as $pl)
            @include('dashboard.pages.of.partials.cards.course-price',['course'=>!empty($course)?$course:null,'pl'=>$pl])
        @endforeach
    </div>

    <div class="col-md-12 col-lg-6">
        @include('dashboard.pages.of.partials.cards.offer-description',['description'=>!empty($course)?$course->description:null])
    </div>

</div>

@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            let intra = $("#description_intra");
            let price = $(".price");
            intra.on('change', toggleIntra);

            function toggleIntra() {
                let is_intra = Math.round(intra.val());
                if (is_intra === 1) {
                    price.addClass('d-none');
                } else {
                    price.removeClass('d-none');
                }
            }

            toggleIntra();
        });
    </script>
@endpush
