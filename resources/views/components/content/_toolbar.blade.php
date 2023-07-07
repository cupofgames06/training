<!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" data-kt-daterangepicker-range="today" class="btn btn-sm btn-light d-flex align-items-center px-4" data-kt-initialized="1">
    <!--begin::Display range-->
    <div class="text-gray-600 fw-bold"></div>
    <!--end::Display range-->
    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
    <i class="fa-regular fa-calendar ms-2 me-0 fs-5"></i>
    <!--end::Svg Icon-->
</div>
<!--end::Daterangepicker-->
@push('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    <script type="module">
        document.addEventListener("DOMContentLoaded", function (event) {

            const elements = [].slice.call(document.querySelectorAll('[data-kt-daterangepicker="true"]'));
            const start = moment().startOf('year');
            const end = moment();

            const indicators = function (start,end){
                let route = "{{ route('company.indicators') }}";

                axios.get(route, {
                    params: {
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD'),
                        @if(Route::current()->getName() !== 'company.index')
                        learner: {{ $learner->id }}
                            @endif
                    }
                }).then(function (response) {
                    toggleLoaders(false,'#indicators-content .loader');

                    $('#indicators-content').html(response.data);

                    $(".progress-bar").each(function(){
                        const pourcent = $(this).attr("pourcent");
                        $(this).animate({ width: pourcent }, 1000);
                    })
                }).catch(function (error) {

                });
            };

            const toggleLoaders = function (visibility = true,item = null){
                const loaders = document.querySelectorAll('.loader');
                if(visibility)
                {
                    loaders.forEach(function (element){
                        element.classList.remove('d-none')
                    });
                }
                else
                {
                    if(item != null)
                    {
                        $(item).addClass('d-none');
                    }
                    else
                    {
                        loaders.forEach(function (element) {
                            element.classList.add('d-none');
                        });
                    }
                }

            }
            elements.map(function (element) {
                const display = element.querySelector('div');
                const attrOpens = element.hasAttribute('data-kt-daterangepicker-opens') ? element.getAttribute('data-kt-daterangepicker-opens') : 'left';

                const cb = function (start, end) {
                    if (display) {
                        display.innerHTML = start.locale('fr').format('D MMM YYYY') + ' - ' + end.locale('fr').format('D MMM YYYY');
                    }

                    toggleLoaders(); // affiche les loaders

                    indicators(start,end); // appel ajax pour les indicateurs

                }

                $(element).daterangepicker({
                    startDate: start,
                    endDate: end,
                    opens: attrOpens,
                    separator: ' à ',
                    locale:{
                        applyLabel: 'OK',
                        cancelLabel: 'Annuler',
                        fromLabel: 'De',
                        toLabel: 'À',
                        customRangeLabel: 'Personnalisé',
                        weekLabel: 'S',
                        daysOfWeek: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                        monthNames: [
                            'Janvier',
                            'Février',
                            'Mars',
                            'Avril',
                            'Mai',
                            'Juin',
                            'Juillet',
                            'Août',
                            'Septembre',
                            'Octobre',
                            'Novembre',
                            'Décembre'
                        ],
                        firstDay: 1
                    }
                },cb);

                cb(start, end);
            });
        });
    </script>
@endpush
