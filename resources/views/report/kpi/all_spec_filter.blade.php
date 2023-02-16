<div id="ddd"></div><br><br>
<div id="ddd3"></div>
<style type="text/css">
    #ddd3 {
        height: 400px;
        min-width: 310px;
        max-width: 1400px;
        margin: 0 auto;
    }
</style>
<style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 660px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    #ddd {
        height: 600px;
        min-width: 600px;
        max-width: 1400px;
        margin: 0 auto;
    }
</style>
{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script> --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
    Highcharts.setOptions({
        colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        })
    });

    Highcharts.chart('ddd', {
        chart: {
            backgroundColor: null,
            type: 'pie',
        },
        colors: ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'],
        title: {
            text: ('<strong>Total PENILAIAN KPI {{ $name_mem }}</strong>'),
            style: {
                fontSize: '30px',
                fontWeight: 'bold',
                textTransform: 'uppercase',
            }
        },
        credits: {
            enabled: false
        },
        subtitle: {
            // text: 'Source: WorldClimate.com'
        },

        xAxis: {
            categories: [
                '',
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },

        plotOptions: {
            pie: {
                allowPointSelect: true,
                dataLabels: {
                    enabled: true,
                    connectorShape: 'fixedOffset',
                    format: '<b>Total {point.name}</b>:{point.percentage:.1f} %<br>Total KPI {point.name}: {point.y}',
                },
            }
        },
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data: [{
                name: 'NA',
                y: {{ $pie[0]->NA == null ? 0 : $pie[0]->NA }}
            }, {
                name: 'Unacceptable',
                y: {{ $pie[0]->Unacceptable == null ? 0 : $pie[0]->Unacceptable }}
            }, {
                name: 'Need Improvement',
                y: {{ $pie[0]->NI ?? 0 }}
            }, {
                name: 'Good',
                y: {{ $pie[0]->Good ?? 0 }}
            }, {
                name: 'Outstanding',
                y: {{ $pie[0]->Outstanding ?? 0 }}
            }]
        }]
    });


    Highcharts.chart('ddd3', {
        chart: {
            type: 'line'
        },
        style: {
            fontFamily: 'Dosis, sans-serif'
        },
        colors: ['#ff3300', '#f9ed09', '#00b300', '#225bb7', ],
        title: {

            text: ('<strong>TOTAL FINAL KPI {{ $name_mem }}</strong>'),
            style: {
                fontSize: '30px',
                fontWeight: 'bold',
                textTransform: 'uppercase',
            }
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                @for ($i = 0; $i < count($year); $i++)
                    '{{ $year[$i]->p_year }}',
                @endfor
            ]
        },
        yAxis: {
            title: {
                text: ''
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
            name: '{{ $name_mem }}',
            data: [
                @for ($i = 0; $i < count($line); $i++)
                    {{ $line[$i][0]->total ?? 0 }},
                @endfor
            ],
        }, ],

    });
</script>
