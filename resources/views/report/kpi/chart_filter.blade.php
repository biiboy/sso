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



<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="https://blacklabel.github.io/grouped_categories/grouped-categories.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.src.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script type="text/javascript">
    if ('{{ $title }}' == 'IT Services') {
        var unit_title = 'ALL {{ $title }}';
    } else {
        var unit_title = 'ALL {{ $title }}';
    }



    Highcharts.chart('ddd', {
        chart: {
            backgroundColor: null,
            type: 'pie',

        },
        // colors: ['#225bb7','#868e96','#ff3300','#f9ed09','#00b300'],
        colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
        title: {
            @if ($tahun == 'all')
                text: ('<strong>TOTAL penilaian KPI ' + unit_title + '</strong>'),
            @else
                text: ('<strong>TOTAL penilaian KPI {{ $tahun }} ' + unit_title + '</strong>'),
            @endif
            // text: ('<strong>TOTAL PENILAIAN KPI '+unit_title+' {{ $tahun }}</strong>'),
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
                    // crop: false,
                    overflow: 'none',
                    connectorShape: 'fixedOffset',
                    // format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI: {point.y}',
                    format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI {point.name}: {point.y}',
                },
                //           tooltip: {
                //   pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                // },
            }
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data: [
                @for ($i = 0; $i < count($nilai); $i++)
                    {
                        name: "{{ $nilai[$i] }}",
                        y: {{ $pie[$i] }},
                    },
                @endfor
            ]
        }]

    });

    var chart = Highcharts.chart('ddd3', {
        chart: {
            type: 'bar'
        },
        // colors: ['#ff3300','#f9ed09','#00b300','#225bb7',],s
        colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
        title: {
            @if ($tahun == 'all')
                text: ('<strong>TOTAL KPI ' + unit_title + '</strong>'),
            @else
                text: ('<strong>TOTAL KPI {{ $tahun }} ' + unit_title + '</strong>'),
            @endif
            // text: ('<strong>TOTAL KPI '+unit_title+' {{ $tahun }}</strong>'),
            style: {
                fontSize: '30px',
                fontWeight: 'bold',
                textTransform: 'uppercase',
            }
        },
        exporting: {
            enabled: false
        },
        xAxis: {
            categories: [
                @if ($tahun == 'all')
                    @for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++)
                        '{{ $year[$i]->p_year }}',
                    @endfor
                @else
                    '{{ $tahun }}'
                @endif
            ]
        },
        plotOptions: {
            bar: {
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
                    @if ($tahun == 'all')
                        @for ($i = 0; $i < count($line); $i++)
                            {{ $line[$i][0] }},
                        @endfor
                    @else
                        @for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++)
                            @for ($i1 = 0; $i1 < count($line); $i1++)
                                {{ $line[$i][$i1] }},
                            @endfor
                        @endfor
                    @endif
                ],
            },

            {
                name: 'Jakarta',
                data: [
                    @for ($i = 0; $i < count($line); $i++)
                        {{ $line[$i][1] }},
                    @endfor
                ],
            },

            {
                name: 'Kediri',
                data: [
                    @for ($i = 0; $i < count($line); $i++)
                        {{ $line[$i][2] }},
                    @endfor
                ],
            },
            {
                name: 'Surabaya',
                data: [
                    @for ($i = 0; $i < count($line); $i++)
                        {{ $line[$i][3] }},
                    @endfor
                ],
            },
        ],
    });
</script>
<script type="text/javascript">
    // Create the chart
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
        // colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
        colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
        title: {
            @if ($tahun == 'all')
                text: ('<strong>TOTAL final KPI ' + unit_title + ' Per Site</strong>'),
            @else
                text: ('<strong>TOTAL final KPI {{ $tahun }} ' + unit_title + ' Per Site</strong>'),
            @endif
            style: {
                fontSize: '30px',
                fontWeight: 'bold',
                textTransform: 'uppercase',
            }
        },
        xAxis: {
            type: 'category'
        },
        exporting: {
            enabled: false
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
            lang: {
                drillUpText: 'Go back'
            },
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
                @foreach ($chart_index_awal as $i => $value)
                    {
                        name: "{{ $all_site_name[$i] }}",
                        y: {{ $value }},
                        drilldown: "{{ $all_site_name[$i] }}drill"
                    },
                @endforeach ]
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
                                @if ($title == 'IT Assets')
                                    {
                                        name: "IT Assets",
                                        y: {{ $chart_index_kedua[$i1][0] }},
                                        drilldown: "{{ $value }}detailasset"
                                    },
                                @endif
                                @if ($title == 'IT Support')
                                    {
                                        name: "IT Support",
                                        y: {{ $chart_index_kedua[$i1][0] }},
                                        drilldown: "{{ $value }}detailsupport"
                                    },
                                @endif
                                @if ($title == 'IT Services')
                                    @if ($i1 == 1)
                                        @for ($k = 0; $k < 3; $k++)
                                            {
                                                name: "IT {{ $unit_has_text[$k] }}",
                                                y: {{ $chart_index_kedua[$i1][$k] }},
                                                drilldown: "{{ $value }}detail{{ $unit_has_text[$k] }}"
                                            },
                                        @endfor
                                    @else
                                        @for ($k = 0; $k < 2; $k++)
                                            {
                                                name: "IT {{ $unit_as_text[$k] }}",
                                                y: {{ $chart_index_kedua[$i1][$k] }},
                                                drilldown: "{{ $value }}detail{{ $unit_as_text[$k] }}"
                                            },
                                        @endfor
                                    @endif
                                @endif
                            @endif
                            @if ($i == 1)
                                @if ($title == 'IT Helpdesk')
                                    {
                                        name: "IT Helpdesk",
                                        y: {{ $chart_index_kedua[0][0] }},
                                        drilldown: "Jakartadetailhelpdesk"
                                    },
                                @endif
                            @endif
                        @endforeach
                    ],
                },
            @endforeach
            @foreach ($all_site_name as $i => $value)
                @foreach ($chart_index_ketiga as $i1 => $value1)
                    @if ($i == $i1)
                        @if ($title == 'IT Assets')
                            {
                                name: "IT Assets {{ $value }}",
                                id: "{{ $value }}detailasset",
                                data: [
                                    @for ($k = 0; $k < 5; $k++)
                                        {
                                            name: "{{ $nilai[$k] }}",
                                            y: {{ $chart_index_ketiga[$i][0][$k] }},
                                            color: '{{ $color[$k] }}'
                                        },
                                    @endfor
                                ],
                            },
                        @endif
                        @if ($title == 'IT Support')
                            {
                                name: "IT Support {{ $value }}",
                                id: "{{ $value }}detailsupport",
                                data: [
                                    @for ($k = 0; $k < 5; $k++)
                                        {
                                            name: "{{ $nilai[$k] }}",
                                            y: {{ $chart_index_ketiga[$i][0][$k] }},
                                            color: '{{ $color[$k] }}'
                                        },
                                    @endfor
                                ],
                            },
                        @endif
                        @if ($title == 'IT Services')
                            @if ($i1 == 1)
                                @for ($i1 = 0; $i1 < 3; $i1++)
                                    {
                                        name: "IT {{ $unit_has_text[$i1] }} {{ $value }}",
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
                                        name: "IT {{ $unit_as_text[$i1] }} {{ $value }}",
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
                    @endif
                    @if ($i == 1)
                        @if ($title == 'IT Helpdesk')
                            {
                                name: "IT Helpdesk Jakarta",
                                id: "Jakartadetailhelpdesk",
                                data: [
                                    @for ($k = 0; $k < 5; $k++)
                                        {
                                            name: "{{ $nilai[$k] }}",
                                            y: {{ $chart_index_ketiga[0][0][$k] }},
                                            color: '{{ $color[$k] }}'
                                        },
                                    @endfor
                                ],
                            },
                        @endif
                    @endif
                @endforeach
            @endforeach
        ]
    }
    })



    $(function() {
        Highcharts.setOptions({
            lang: {
                drillUpText: 'Back to {series.name}'
            }
        });

        Highcharts.chart('container3', {
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
            xAxis: {
                type: 'category'
            },
            title: {
                @if ($tahun == 'all')
                    text: ('<strong>TOTAL final KPI ' + unit_title + ' Per Specialist</strong>'),
                @else
                    text: ('<strong>TOTAL final KPI {{ $tahun }} ' + unit_title +
                        ' Per Specialist</strong>'),
                @endif
                // text: ('<strong>Total FINAL KPI '+unit_title+' {{ $tahun }} </strong>'),
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
            exporting: {
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

            series: [
                @if ($title == 'IT Assets' || $title == 'IT Services')
                    {
                        name: 'IT Asset',
                        // colorByPoint: true,
                        data: [
                            @foreach ($chart_index_awal_bawah as $i => $value)
                                {
                                    name: '{{ $all_site_name[$i] }}',
                                    y: {{ $chart_index_awal_bawah[$i][0] }},

                                    drilldown: 'drilldownasset{{ $all_site_name[$i] }}',
                                },
                            @endforeach
                        ],
                    },
                @endif

                @if ($title == 'IT Helpdesk')
                    {
                        name: 'IT Helpdesk',
                        colorByPoint: true,
                        data: [{
                            name: 'Jakarta',
                            y: {{ $chart_index_awal_bawah[1][0] }},
                            drilldown: 'drilldownhelpdeskJakarta',
                        }, ],
                    },
                @elseif ($title == 'IT Services') {
                        name: 'IT Helpdesk',
                        data: [{
                            name: 'Jakarta',
                            y: {{ $chart_index_awal_bawah[1][2] }},
                            drilldown: 'drilldownhelpdeskJakarta',
                        }, ],
                    },
                @endif

                @if ($title == 'IT Support')
                    {
                        name: 'IT Support',
                        colorByPoint: true,
                        // color: '#00b300',

                        data: [
                            @foreach ($chart_index_awal_bawah as $i => $value)
                                {
                                    name: '{{ $all_site_name[$i] }}',
                                    y: {{ $chart_index_awal_bawah[$i][0] }},
                                    drilldown: 'drilldownsupport{{ $all_site_name[$i] }}',
                                },
                            @endforeach
                        ],
                    },
                @elseif ($title == 'IT Services') {
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
                    },
                @endif
            ],

            drilldown: {
                drillUpButton: {
                    relativeTo: 'spacingBox',
                    position: {
                        y: 0,
                        x: 0

                    }
                },

                series: [
                    @if ($title == 'IT Assets' || $title == 'IT Services')
                        @foreach ($array_asset as $i => $value)
                            {
                                name: 'IT Asset {{ $all_site_name[$i] }}',
                                color: '{{ $color[$i] }}',
                                id: 'drilldownasset{{ $all_site_name[$i] }}',
                                data: [
                                    @foreach ($array_asset[$i] as $i1 => $value1)
                                        {
                                            name: '{{ $array_asset[$i][$i1]->m_name }}',
                                            y: {{ $chart_index_kedua_bawah_count_asset[$i][$i1] }},
                                            {{-- color: '{{ $color[$i] }}', --}}
                                            drilldown: 'asset{{ $array_asset_id[$i][$i1]->m_id }}'
                                        },
                                    @endforeach
                                ]
                            },
                        @endforeach
                    @endif
                    @if ($title == 'IT Helpdesk' || $title == 'IT Services')
                        {
                            name: 'IT Helpdesk Jakarta',
                            id: 'drilldownhelpdeskJakarta',
                            data: [
                                @foreach ($array_helpdesk as $i => $value)
                                    @if ($chart_index_kedua_bawah_count_helpdesk == 0)
                                        {
                                            name: '0',
                                            y: 0,
                                            drilldown: 'helpdesk'
                                        },
                                    @else
                                        {
                                            name: '{{ $array_helpdesk[$i]->m_name }}',
                                            y: {{ $chart_index_kedua_bawah_count_helpdesk[$i] }},
                                            drilldown: 'helpdesk{{ $array_helpdesk_id[$i]->m_id }}'
                                        },
                                    @endif
                                @endforeach
                            ]
                        },
                    @endif
                    @if ($title == 'IT Support' || $title == 'IT Services')
                        @foreach ($array_support as $i => $value)
                            {
                                name: 'IT Support {{ $all_site_name[$i] }}',
                                id: 'drilldownsupport{{ $all_site_name[$i] }}',
                                data: [
                                    @foreach ($array_support[$i] as $i1 => $value1)
                                        {
                                            name: '{{ $array_support[$i][$i1]->m_name }}',
                                            y: {{ $chart_index_kedua_bawah_count_support[$i][$i1] }},
                                            drilldown: 'Support{{ $array_support_id[$i][$i1]->m_id }}'
                                        },
                                    @endforeach
                                ]
                            },
                        @endforeach
                    @endif
                    @if ($title == 'IT Assets' || $title == 'IT Services')
                        @foreach ($chart_index_kedua_bawah_count_nilai_asset as $i => $value)
                            @if (count($array_asset_id[$i]) == 0)
                                @for ($k = 0; $k < 1; $k++)
                                    {
                                        name: 'Kosong',
                                        id: 'Kosong',
                                        data: [
                                            @for ($j = 0; $j < count($nilai); $j++)
                                                {
                                                    name: '{{ $nilai[$j] }}',
                                                    color: '{{ $color[$j] }}',
                                                    y: 0,
                                                    // drilldown: 'a'
                                                },
                                            @endfor
                                        ]
                                    },
                                @endfor
                            @else
                                @foreach ($chart_index_kedua_bawah_count_nilai_asset[$i] as $i1 => $value1)
                                    {
                                        name: 'Total {{ $array_asset[$i][$i1]->m_name }}',
                                        id: 'asset{{ $array_asset_id[$i][$i1]->m_id }}',
                                        data: [
                                            @foreach ($chart_index_kedua_bawah_count_nilai_asset[$i][$i1] as $i2 => $value2)
                                                {
                                                    name: '{{ $nilai[$i2] }}',
                                                    color: '{{ $color[$i2] }}',
                                                    y: {{ $chart_index_kedua_bawah_count_nilai_asset[$i][$i1][$i2] }},
                                                    // drilldown: 'a'
                                                },
                                            @endforeach
                                        ]
                                    },
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    @if ($title == 'IT Helpdesk' || $title == 'IT Services')
                        @foreach ($chart_index_kedua_bawah_count_nilai_helpdesk as $i => $value)
                            @if (count($chart_index_kedua_bawah_count_nilai_helpdesk) == 1)
                            @else
                                {
                                    name: 'Total {{ $array_helpdesk[$i]->m_name }}',
                                    id: 'helpdesk{{ $array_helpdesk_id[$i]->m_id }}',
                                    data: [
                                        @foreach ($chart_index_kedua_bawah_count_nilai_helpdesk[$i] as $i1 => $value1)
                                            {
                                                name: '{{ $nilai[$i1] }}',
                                                y: {{ $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$i1] }},
                                                color: '{{ $color[$i1] }}'
                                                // drilldown: 'a'
                                            },
                                        @endforeach
                                    ]
                                },
                            @endif
                        @endforeach
                    @endif
                    @if ($title == 'IT Support' || $title == 'IT Services')
                        @foreach ($chart_index_kedua_bawah_count_nilai_support as $i => $value)
                            @if (count($array_support[$i]) == 0)
                                @for ($k = 0; $k < 1; $k++)
                                    {
                                        name: 'Kosong',
                                        id: 'Kosong',
                                        data: [
                                            @for ($j = 0; $j < count($nilai); $j++)
                                                {
                                                    name: '{{ $nilai[$j] }}',
                                                    y: 0,
                                                    color: '{{ $color[$j] }}'
                                                    // drilldown: 'a'
                                                },
                                            @endfor
                                        ]
                                    },
                                @endfor
                            @else
                                @foreach ($chart_index_kedua_bawah_count_nilai_support[$i] as $i1 => $value1)
                                    {
                                        name: 'Total {{ $array_support[$i][$i1]->m_name }}',
                                        id: 'Support{{ $array_support_id[$i][$i1]->m_id }}',
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
                            @endif
                        @endforeach
                    @endif
                ]
            }
        })
    });
</script>
