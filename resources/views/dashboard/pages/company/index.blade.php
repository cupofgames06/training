<x-auth-layout>

        <x-content.header>
            @include('dashboard.pages.company.components._toolbar')
        </x-content.header>

        <div class="row">
            <div class="col-md-4 mb-md-0 mb-4" id="overview-content">
                @include('components.content._loader')
            </div>
            <div class="col-md-4 mb-md-0 mb-4" id="indicators-content" >
                @include('components.content._loader')
            </div>
            <div class="col-sm-4 mb-md-0 mb-4">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-4">
                            <h3>Heures de formation</h3>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="w-100 rounded-4 mt-4 mx-2" style="background-color: #FFF4F5">
                                <div id="chart2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {!! $table??null !!}
        </div>

    @push('scripts')
        <script>
            window.addEventListener("DOMContentLoaded", (event) => {
                var options = {
                    series: [{
                        name: "Desktops",
                        data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
                    }],
                    chart: {
                        height: 250,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight',
                        colors: ['#D46370']
                    },
                    grid: {
                        row: {
                            colors: ["#FFF4F5"],
                        },
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                    },
                    tooltip: {
                        custom: function({ series, seriesIndex, dataPointIndex, w }) {
                            return (
                                '<div class="arrow_box text-white p-2" style="background-color: #EB717F">' +
                                "<span>"+ w.globals.categoryLabels[dataPointIndex] +"<br>" +
                                series[seriesIndex][dataPointIndex] +
                                " heures</span>" +
                                "</div>"
                            );
                        },
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart2"), options);
                chart.render();
            });

        </script>
    @endpush
</x-auth-layout>


