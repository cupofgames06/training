<div class="card overview" style="height: 100%">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-4">
            <h4>@lang('common.monitoring.overview.title')</h4>
        </div>
        <div class="row">
            <div class="col-sm-6" id="chart">

            </div>
            <div class="col-sm-6 ps-4">
                <div class="d-flex flex-column h-100 justify-content-between ms-4 ps-4 mt-2 pb-1">
                    @isset($count)
                        <div class="d-flex align-items-center mb-3">
                            <i class="fa-light fa-user-group me-1"></i> {{ $count }}
                        </div>
                    @endisset
                    <div class="d-flex align-items-start mb-3">
                        <span class="p-2 bg-primary border rounded-circle me-2"></span>
                        <div class="d-flex flex-column align-content-end">
                            <span class="title">@lang('common.monitoring.overview.labels.finish')</span>
                            <span class="label">{{ $finish['events'] }}<span class="sep"></span>{{ $finish['hours'] }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <span class="p-2 bg-primary-300 border rounded-circle me-2"></span>
                        <div class="d-flex flex-column align-content-end">
                            <span class="title">@lang('common.monitoring.overview.labels.in_progress')</span>
                            <span class="label">{{ $in_progress['events'] }}<span class="sep"></span>{{ $in_progress['hours'] }}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <span class="p-2 bg-primary-100 border rounded-circle me-2"></span>
                        <div class="d-flex flex-column align-content-end">
                            <span class="title">@lang('common.monitoring.overview.labels.next')</span>
                            <span class="label">{{ $next['events'] }}<span class="sep"></span>{{ $next['hours'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        @if($finish['events']*100/3 == 0 && $in_progress['events']*100/3 == 0 && $next['events']*100/3 == 0)
            series: [1, 1, 1],
        @else
            series: [{{ $in_progress['events']*100/3 }},{{ $next['events']*100/3 }}, {{$finish['events']*100/3 }}],
        @endif
        labels: ['{{ trans('common.monitoring.overview.labels.in_progress') }}', '{{ trans('common.monitoring.overview.labels.next') }}','{{ trans('common.monitoring.overview.labels.finish') }}'],
        fill: {
            colors: [in_progress,next,finish ]
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show:false,
        },
        chart: {
            fontFamily: font_family,
            type: 'donut',
            height: 250,
        },
        states: {
            hover: {
                filter: {
                    type: 'none',
                }
            },
        },
        tooltip: {
            enabled: false,
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            showAlways: true,
                            formatter: () => ['{{ trans('common.courses') }}','{{ $total['hours'] }}'],
                            label: '{{ $finish['events'] + $in_progress['events'] + $next['events'] }}',
                            fontSize:'32px',
                        },

                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    show:false,
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

</script>

