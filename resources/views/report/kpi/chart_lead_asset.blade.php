@extends('master')

@push('title')
    Report > KPI Chart
@endpush

@push('styles')
    <style>
        #ddd {
            height: 600px;
            min-width: 600px;
            max-width: 1400px;
            margin: 0 auto;
        }

        #ddd1 {
            height: 400px;
            min-width: 310px;
            max-width: 1400px;
            margin: 0 auto;
        }

        #ddd3 {
            height: 400px;
            min-width: 310px;
            max-width: 1400px;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white">Chart Report</h4>
        </div>
        <div class="card-body">
            <form class="row">
                <label class="col-1">Choose Unit</label>
                <select class="col-2 w-25 form-select my-1 mr-sm-2 cari_unit">
                    <option value="IT Assets">IT Assets</option>
                </select>
                <label class="col-1">Choose Year</label>
                <select class="col-2 w-25 form-select my-1 mr-2 cari_tahun">
                    <option value="all">All</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
                <button type="button" class="col-1 btn btn-primary my-1 ms-3 search_button">Search</button>
            </form><br>

            <div class="card animated fadeIn">
                <div class="card-body">
                    <div id="ddd"></div>
                </div>
            </div>

            <div class="card animated fadeIn">
                <div class="card-body">
                    <div id="ddd1"></div>
                </div>
            </div>

            <div class="card animated fadeIn">
                <div class="card-body">
                    <div id="ddd3"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('highchart/code/highcharts.js') }}"></script>
    <script src="{{ asset('highchart/code/highcharts-3d.js') }}"></script>
    <script src="{{ asset('highchart/code/highcharts-3d.src.js') }}"></script>
    <script src="{{ asset('highchart/code/modules/drilldown.js') }}"></script>
    <script src="{{ asset('highchart/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('highchart/code/modules/export-data.js') }}"></script>
    <script src="{{ asset('highchart/code/modules/series-label.js') }}"></script>
    <script>
        $('.search_button').click(function() {
            $.ajax({
                type: "get",
                url: '{{ route('all_report_manager_chart_cari_unit') }}',
                data: '&unit=' + $('.cari_unit').val() + '&tahun=' + $('.cari_tahun').val(),
                success: function(data) {
                    // pie
                    Highcharts.chart('ddd', {
                        chart: {
                            backgroundColor: null,

                            type: 'pie',

                        },
                        colors: ['#225bb7', '#868e96', '#ff3300', '#f9ed09', '#00b300'],


                        title: {
                            text: ('<strong>TOTAL PENILAIAN KPI ' + ' ' + data.tahun + ' ' +
                                data.tittle + '</strong>'),
                            style: {
                                fontSize: '30px',
                                fontWeight: 'bold',
                                textTransform: 'uppercase',
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        exporting: {
                            enabled: false
                        },
                        subtitle: {},
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            categories: ['', ],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: ''
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        plotOptions: {
                            pie: {

                                allowPointSelect: true,

                                // cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    crop: false,
                                    overflow: 'none',
                                    connectorShape: 'fixedOffset',
                                    format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI: {point.y}',
                                }
                            }
                        },
                        series: [{
                            name: data.tittle,
                            colorByPoint: true,
                            data: [{
                                    name: 'Good',
                                    y: data.pie[3]
                                },
                                {
                                    name: 'NA',
                                    y: data.pie[0]
                                }, {
                                    name: 'Unacceptable',
                                    y: data.pie[1]
                                }, {
                                    name: 'Need Improvement',
                                    y: data.pie[2]
                                }, {
                                    name: 'Outstanding',
                                    y: data.pie[4]
                                }
                            ]
                        }]

                    });
                    if (data.tittle == 'IT Service') {
                        Highcharts.chart('ddd1', {
                            chart: {
                                type: 'column',
                                options3d: {
                                    enabled: true,
                                    alpha: 0,
                                    beta: 0,
                                    depth: 70,
                                }
                            },
                            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
                            title: {
                                // text: ('<strong>Total FINAL KPI All '+data.tittle+'  '+data.tahun+'</strong>'),
                                text: ('<strong>TOTAL FINAL KPI ' + ' ' + data.tahun + ' ' +
                                    data.tittle + '</strong>'),
                                style: {
                                    fontSize: '30px',
                                    fontWeight: 'bold',
                                    textTransform: 'uppercase',
                                }
                            },
                            plotOptions: {
                                series: {
                                    depth: 25,
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            xAxis: {
                                categories: ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'],
                                labels: {
                                    x: -10
                                }
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'TOTAL KPI'
                                }
                            },
                            series: [{
                                    name: 'IT Asset',
                                    data: [data.column[0][2], data.column[1][2], data
                                        .column[2][2], data.column[3][2]
                                    ]
                                }, {
                                    name: 'IT Helpdesk',
                                    data: [data.column[0][0], data.column[1][0], data
                                        .column[2][0], data.column[3][0]
                                    ]
                                },
                                {
                                    name: 'IT Support',
                                    data: [data.column[0][1], data.column[1][1], data
                                        .column[2][1], data.column[3][1]
                                    ]
                                }
                            ],
                        });
                    } else {
                        Highcharts.chart('ddd1', {
                            chart: {
                                type: 'column',
                                options3d: {
                                    enabled: true,
                                    alpha: 0,
                                    beta: 0,
                                    depth: 70,
                                }
                            },
                            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
                            title: {
                                // text: ('<strong>Total FINAL KPI All '+data.tittle+'   '+data.tahun+'</strong>'),
                                text: ('<strong>TOTAL FINAL KPI ' + ' ' + data.tahun + ' ' +
                                    data.tittle + '</strong>'),
                                style: {
                                    fontSize: '30px',
                                    fontWeight: 'bold',
                                    textTransform: 'uppercase',
                                }
                            },
                            plotOptions: {
                                series: {
                                    depth: 25,
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            xAxis: {
                                categories: ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'],
                                labels: {
                                    x: -10
                                }
                            },
                            credits: {
                                enabled: false
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'TOTAL KPI'
                                }
                            },
                            series: [{
                                name: data.tittle,
                                data: [data.column[0], data.column[1], data.column[2],
                                    data.column[3]
                                ],
                            }],
                        });
                    }


                    if (data.tahun != 'all') {
                        Highcharts.chart('ddd3', {
                            chart: {
                                type: 'line'
                            },
                            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
                            title: {
                                // text: ('<strong>TOTAL KPI All '+data.tittle+'   '+data.tahun+'</strong>'),
                                text: ('<strong>TOTAL KPI ' + ' ' + data.tahun + ' ' + data
                                    .tittle + '</strong>'),
                                style: {
                                    fontSize: '30px',
                                    fontWeight: 'bold',
                                    textTransform: 'uppercase',
                                }
                            },
                            xAxis: {
                                categories: [data.tahun],
                            },
                            plotOptions: {
                                line: {
                                    dataLabels: {
                                        enabled: true
                                    },
                                    enableMouseTracking: true
                                }
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'TOTAL KPI'
                                }
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                    name: 'Gempol',
                                    data: [data.line[0][0]]
                                }, {
                                    name: 'Jakarta',
                                    data: [data.line[0][1]]
                                },
                                {
                                    name: 'Kediri',
                                    data: [data.line[0][2]]
                                },
                                {
                                    name: 'Surabaya',
                                    data: [data.line[0][3]]
                                }
                            ],
                        });
                    } else {
                        var year = [];
                        var gempol = [];
                        var jakarta = [];
                        var kediri = [];
                        var surabaya = [];
                        $(data.line).each(function(i, el) {
                            gempol[i] = data.line[i][0]
                            jakarta[i] = data.line[i][1]
                            kediri[i] = data.line[i][2]
                            surabaya[i] = data.line[i][3]
                            year[i] = data.year[i].p_year
                        });

                        Highcharts.chart('ddd3', {
                            chart: {
                                type: 'line'
                            },
                            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
                            title: {
                                // text: ('<strong>TOTAL KPI All '+data.tittle+'   '+data.tahun+'</strong>'),
                                text: ('<strong>TOTAL KPI ' + ' ' + data.tahun + ' ' + data
                                    .tittle + '</strong>'),
                                style: {
                                    fontSize: '30px',
                                    fontWeight: 'bold',
                                    textTransform: 'uppercase',
                                }
                            },
                            xAxis: {
                                categories: $(year).each(function(i, el) {
                                    year[i]
                                }),
                            },
                            yAxis: {
                                allowDecimals: false,
                                title: {
                                    text: 'TOTAL KPI'
                                }
                            },
                            plotOptions: {
                                line: {
                                    dataLabels: {
                                        enabled: true
                                    },
                                    enableMouseTracking: true
                                }
                            },
                            credits: {
                                enabled: false
                            },
                            series: [{
                                    name: 'Gempol',
                                    data: $(gempol).each(function(i, el) {
                                        gempol[i]
                                    }),
                                }, {
                                    name: 'Jakarta',
                                    data: $(jakarta).each(function(i, el) {
                                        jakarta[i]
                                    }),
                                },
                                {
                                    name: 'Kediri',
                                    data: $(kediri).each(function(i, el) {
                                        kediri[i]
                                    }),
                                },
                                {
                                    name: 'Surabaya',
                                    data: $(surabaya).each(function(i, el) {
                                        surabaya[i]
                                    }),
                                }
                            ],
                        });

                    }

                }
            });
        })


        Highcharts.chart('ddd', {
            chart: {
                backgroundColor: null,

                type: 'pie',

            },
            colors: ['#225bb7', '#868e96', '#ff3300', '#f9ed09', '#00b300', ],
            title: {
                text: ('<strong>TOTAL PENILAIAN KPI ALL IT Assets</strong>'),
                style: {
                    fontSize: '30px',
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                    // text: ('<strong>TOTAL PENILAIAN KPI TEAM</strong>'),
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            subtitle: {},

            xAxis: {
                categories: ['', ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {

                    allowPointSelect: true,

                    // cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        crop: false,
                        overflow: 'none',
                        connectorShape: 'fixedOffset',
                        format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI: {point.y}',
                    }
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: [{
                        name: 'Good',
                        y: {{ $totalgood_assets }}
                    },
                    {
                        name: 'NA',
                        y: {{ $totalna_assets }}
                    }, {
                        name: 'Unacceptable',
                        y: {{ $totalunacceptable_assets }}
                    }, {
                        name: 'Need Improvement',
                        y: {{ $totalni_assets }}
                    }, {
                        name: 'Outstanding',
                        y: {{ $totaloutstanding_assets }}
                    }
                ]
            }]

        });


        var chart = Highcharts.chart('ddd1', {

            chart: {

                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 0,
                    beta: 0,
                    depth: 70,
                }
            },
            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
            title: {
                text: ('<strong>Total FINAL KPI All IT Assets Per Site</strong>'),
                style: {
                    fontSize: '30px',
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                series: {
                    depth: 25,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                categories: ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'],
                labels: {
                    x: -10
                }
            },
            credits: {
                enabled: false
            },

            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'TOTAL KPI'
                }
            },

            series: [{

                    name: 'IT Asset',
                    data: [{{ $totalassetgempol }}, {{ $totalassetjakarta }}, {{ $totalassetkediri }},
                        {{ $totalassetsurabaya }}
                    ]
                },

            ],

        });

        var chart = Highcharts.chart('ddd3', {
            chart: {
                type: 'line'
            },
            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
            title: {
                text: ('<strong>TOTAL KPI All IT Assets</strong>'),
                style: {
                    fontSize: '30px',
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                }
            },
            xAxis: {
                categories: [
                    @for ($i = 0; $i < count($year); $i++)
                        '{{ $year[$i]->p_year }}',
                    @endfor
                ]
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            credits: {
                enabled: false
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'TOTAL KPI'
                }
            },
            series: [{
                    name: 'Gempol',
                    data: [
                        @for ($i = 0; $i < count($gmpl_site); $i++)
                            {{ $gmpl_site[$i][0]->total ?? 0 }},
                        @endfor
                    ],
                },

                {
                    name: 'Jakarta',
                    data: [
                        @for ($i = 0; $i < count($jkt_site); $i++)
                            {{ $jkt_site[$i][0]->total ?? 0 }},
                        @endfor
                    ],
                },

                {
                    name: 'Kediri',
                    data: [
                        @for ($i = 0; $i < count($kdr_site); $i++)
                            {{ $kdr_site[$i][0]->total ?? 0 }},
                        @endfor
                    ],
                },
                {
                    name: 'Surabaya',
                    data: [
                        @for ($i = 0; $i < count($sby_site); $i++)
                            {{ $sby_site[$i][0]->total ?? 0 }},
                        @endfor
                    ],
                },
            ],
        });
    </script>
@endpush
