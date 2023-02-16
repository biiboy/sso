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

        #container1 {
            height: 400px;
            min-width: 310px;
            max-width: 1400px;
            margin: 0 auto;
        }

        #container3 {
            height: 400px;
            min-width: 310px;
            max-width: 1400px;
            margin: 0 auto;
        }

        #container2 {
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
                    <option value="IT Support">IT Support</option>
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
            <div class="drop_here">
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <div id="ddd"></div>
                    </div>
                </div>
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <div id="container1"></div>
                    </div>
                </div>
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <div id="container3"></div>
                    </div>
                </div>
                <div class="card animated fadeIn">
                    <div class="card-body">
                        <div id="ddd3"></div>
                    </div>
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
                url: '{{ route('all_report_lead_support_chart_cari_unit') }}',
                data: '&unit=' + $('.cari_unit').val() + '&tahun=' + $('.cari_tahun').val(),
                success: function(data) {

                    $('.drop_here').html(data);

                }
            });
        })

        Highcharts.chart('ddd', {
            chart: {
                backgroundColor: null,
                type: 'pie',

            },
            colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
            title: {
                text: ('<strong>TOTAL PENILAIAN KPI ALL IT Support</strong>'),
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
                        connectorShape: 'fixedOffset',
                        // inside: true,
                        format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI {point.name}: {point.y}',
                    },
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: [{
                        name: 'NA',
                        y: {{ $totalna_support }}
                    }, {
                        name: 'Unacceptable',
                        y: {{ $totalunacceptable_support }}
                    }, {
                        name: 'Need Improvement',
                        y: {{ $totalni_support }}
                    },
                    {
                        name: 'Good',
                        y: {{ $totalgood_support }}
                    }, {
                        name: 'Outstanding',
                        y: {{ $totaloutstanding_support }}
                    }
                ]
            }]

        });




        var chart = Highcharts.chart('ddd3', {
            chart: {
                type: 'line'
            },
            colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
            title: {
                text: ('<strong>TOTAL KPI All IT Support</strong>'),
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

        Highcharts.chart('container1', {
            chart: {
                type: 'column',
                options3d: {
                    enabled: true,
                    alpha: 0,
                    beta: 0,
                    depth: 70,
                }
            },
            colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],

            // #868e96 => abu2
            // #ff3300 => merah
            // #f9ed09 => kuning
            // #225bb7 => biru
            // #00b300 => ijo

            title: {
                text: ('<strong>Total FINAL KPI All IT Support Per Site</strong>'),
                style: {
                    fontSize: '30px',
                    fontWeight: 'bold',
                    textTransform: 'uppercase',
                }
            },
            xAxis: {
                type: 'category'
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
            plotOptions: {
                series: {
                    depth: 25,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            //main series = as level 0
            series: [{
                name: "Site",
                colorByPoint: true,
                colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
                data: [
                    @foreach ($chart_index_awal as $i => $value)
                        {
                            name: "{{ $all_site_name[$i] }}",
                            y: {{ $value }},
                            drilldown: "{{ $all_site_name[$i] }}drill"
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                drillUpButton: {
                    relativeTo: 'spacingBox',
                    position: {
                        y: 0,
                        x: 0

                    }
                },
                series: [
                    @foreach ($all_site_name as $i => $value)
                        {
                            name: "Site {{ $value }}",
                            id: "{{ $value }}drill",
                            data: [
                                @foreach ($chart_index_kedua as $i1 => $value1)
                                    @if ($i == $i1)
                                        @if ($i1 == 1)
                                            @for ($k = 0; $k < 3; $k++)
                                                {
                                                    name: "IT 1 {{ $unit_has_text[$k] }}",
                                                    y: {{ $chart_index_kedua[$i1][$k] }},
                                                    drilldown: "{{ $value }}detail{{ $unit_has_text[$k] }}"
                                                },
                                            @endfor
                                        @else
                                            @for ($k = 0; $k < 2; $k++)
                                                {
                                                    name: "IT 2 {{ $unit_as_text[$k] }}",
                                                    y: {{ $chart_index_kedua[$i1][$k] }},
                                                    drilldown: "{{ $value }}detail{{ $unit_as_text[$k] }}"
                                                },
                                            @endfor
                                        @endif
                                    @endif
                                @endforeach
                            ],
                        },
                    @endforeach
                    @foreach ($all_site_name as $i => $value)
                        @foreach ($chart_index_ketiga as $i1 => $value1)
                            @if ($i == $i1)
                                @if ($i1 == 1)
                                    @for ($i1 = 0; $i1 < 3; $i1++)
                                        {
                                            name: "IT 3 {{ $unit_has_text[$i1] }} {{ $value }}",
                                            id: "{{ $value }}detail{{ $unit_has_text[$i1] }}",
                                            data: [
                                                @for ($k = 0; $k < 5; $k++)
                                                    {
                                                        name: "{{ $nilai[$k] }}",
                                                        y: {{ $chart_index_ketiga[$i][$i1][$k] }},
                                                        color: '{{ $color[$k] }}'
                                                    },
                                                @endfor
                                            ],
                                        },
                                    @endfor
                                @else
                                    @for ($i1 = 0; $i1 < 2; $i1++)
                                        {
                                            name: "IT 4 {{ $unit_as_text[$i1] }} {{ $value }}",
                                            id: "{{ $value }}detail{{ $unit_as_text[$i1] }}",
                                            data: [
                                                @for ($k = 0; $k < 5; $k++)
                                                    {
                                                        name: "{{ $nilai[$k] }}",
                                                        y: {{ $chart_index_ketiga[$i][$i1][$k] }},
                                                        color: '{{ $color[$k] }}'
                                                    },
                                                @endfor
                                            ],
                                        },
                                    @endfor
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                ]
            }
        });
        $(function() {
            Highcharts.setOptions({
                lang: {
                    drillUpText: 'Back to {series.name}'
                }
            });

            // Create the chart
            $('#container3').highcharts({
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 0,
                        beta: 0,
                        depth: 70,
                    }

                },
                // colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7'],
                colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],

                xAxis: {
                    type: 'category'
                },
                title: {
                    text: ('<strong>Total FINAL KPI All IT Support Per Specialist</strong>'),
                    style: {
                        fontSize: '30px',
                        fontWeight: 'bold',
                        textTransform: 'uppercase',
                    }
                },

                legend: {
                    enabled: true
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
                plotOptions: {
                    series: {
                        depth: 25,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },

                series: [{

                    name: 'IT Support',
                    data: [
                        @foreach ($chart_index_awal_bawah as $i => $value)
                            {
                                name: '{{ $all_site_name[$i] }}',
                                y: {{ $chart_index_awal_bawah[$i][1] }},
                                drilldown: 'drilldownsupport{{ $all_site_name[$i] }}',
                            },
                        @endforeach
                    ],
                }, ],

                drilldown: {
                    drillUpButton: {
                        relativeTo: 'spacingBox',
                        position: {
                            y: 0,
                            x: 0

                        }
                    },
                    series: [
                        @foreach ($array_support as $i => $value)
                            {
                                name: 'IT Support {{ $all_site_name[$i] }}',
                                id: 'drilldownsupport{{ $all_site_name[$i] }}',
                                data: [
                                    @foreach ($array_support[$i] as $i1 => $value1)
                                        {
                                            name: '{{ $array_support[$i][$i1]->m_name }}',
                                            y: {{ $chart_index_kedua_bawah_count_support[$i][$i1] }},
                                            drilldown: 'support{{ $array_support_id[$i][$i1]->m_id }}'
                                        },
                                    @endforeach
                                ]
                            },
                        @endforeach


                        @foreach ($chart_index_kedua_bawah_count_nilai_support as $i => $value)
                            @foreach ($chart_index_kedua_bawah_count_nilai_support[$i] as $i1 => $value1)
                                {
                                    name: 'Total {{ $array_support[$i][$i1]->m_name }}',
                                    id: 'support{{ $array_support_id[$i][$i1]->m_id }}',
                                    data: [
                                        @foreach ($chart_index_kedua_bawah_count_nilai_support[$i][$i1] as $i2 => $value2)
                                            {
                                                name: '{{ $nilai[$i2] }}',
                                                color: '{{ $color[$i2] }}',

                                                y: {{ $chart_index_kedua_bawah_count_nilai_support[$i][$i1][$i2] }},
                                                // drilldown: 'a'
                                            },
                                        @endforeach
                                    ]
                                },
                            @endforeach
                        @endforeach


                        // this is 2nd level drilldown
                    ]
                }


            });
        });
    </script>
@endpush
