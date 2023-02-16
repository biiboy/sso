@extends('master')

@push('title')
    Report > {{ $name_mem }}
@endpush

@push('styles')
    <style>
        #ddd3 {
            height: 400px;
            min-width: 310px;
            max-width: 1400px;
            margin: 0 auto;
        }

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
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white">Report Details</h4>
        </div>
        <div class="card-body">

            <form>
                <label class="col-sm-1">Choose Year</label>
                <select class="col-sm-2 form-select my-1 mr-sm-2 cari_tahun year w-25" name="year">
                    <option value="ALL">ALL</option>
                    @foreach ($year as $element)
                        <option value="{{ $element->p_year }}">{{ $element->p_year }}</option>
                    @endforeach
                </select>
            </form><br>

            <div class="text-left mb-3">

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="card">
                            <div class="card-body drop_here">
                                <div id="ddd"></div><br><br>
                                <div id="ddd3"></div>
                            </div>
                        </div>

                        <div class="drop_here_table_header" style="display:none">
                            <div class="table-responsive" style="display:none">
                                <table id="zero_config" class="table table-striped table-bordered" style="display:none">
                                    <thead>
                                        <tr>
                                            <th><b>
                                                    <center>Full Name</center>
                                                </b></th>
                                            <th><b>
                                                    <center>Unit</center>
                                                </b></th>
                                            <th>
                                                <center><span class="label label-rounded label-info"
                                                        style="background-color: #868e96 !important">N/A</span>
                                                </center>
                                            </th>
                                            <th>
                                                <center><span class="label label-rounded label-danger">Unacceptable</span>
                                                </center>
                                            </th>
                                            <th>
                                                <center><span class="label label-rounded label-warning">Need
                                                        Improvement</span></center>
                                            </th>
                                            <th>
                                                <center><span class="label label-rounded label-info">Good</span>
                                                </center>
                                            </th>
                                            <th>
                                                <center><span class="label label-rounded label-success">Outstanding</span>
                                                </center>
                                            </th>
                                            <th><b>
                                                    <center>Total</center>
                                                </b></th>
                                            <th><b>
                                                    <center>Final Result</center>
                                                </b></th>
                                            <th><b>
                                                    <center>Total KPI</center>
                                                </b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $na = 0;
                                            $unacceptable = 0;
                                            $ni = 0;
                                            $good = 0;
                                            $outstanding = 0;
                                            $total = 0;
                                            $total_kpi = 0;
                                        @endphp

                                        @foreach ($all_site as $element)
                                            <tr>
                                                <td>{{ $element->m_name }}</td>
                                                <td>{{ $element->u_name }}</td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-info"
                                                                style="background-color: #868e96 !important">{{ $element->NA ?? 0 }}</span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-danger">{{ $element->Unacceptable ?? 0 }}</span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-warning">{{ $element->NI ?? 0 }}</span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-info">{{ $element->Good ?? 0 }}</span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-success">{{ $element->Outstanding ?? 0 }}</span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;">
                                                            {{ $element->NA + $element->Unacceptable + $element->NI + $element->Good + $element->Outstanding }}
                                                    </center>
                                                </td>
                                                @php
                                                ($na += $element->NA) ?? 0;
                                                ($unacceptable += $element->Unacceptable)
                                                ?? 0;
                                                ($ni += $element->NI) ?? 0;
                                                ($good += $element->Good) ?? 0;
                                                ($outstanding += $element->Outstanding) ?? 0;
                                                $total += $element->NA + $element->Unacceptable + $element->NI +
                                                $element->Good + $element->Outstanding;
                                                ($total_kpi += $element->ttl_kpi) ?? 0;
                                                @endphp

                                                <td>
                                                    <center>
                                                        <font size="5">
                                                            <span class="label label-rounded label-info"
                                                                style="background-color: #868e96 !important">
                                                                N/A
                                                            </span>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <p style="font-size:1.2em;"><span
                                                                class="label label-rounded label-success">{{ $element->ttl_kpi ?? 0 }}</span>
                                                    </center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">TOTAL</td>
                                            <td class="total_na">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $na }}</p>
                                                </center>
                                            </td>
                                            <td class="total_unacceptable">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $unacceptable }}</p>
                                                </center>
                                            </td>
                                            <td class="total_ni">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $ni }}</p>
                                                </center>
                                            </td>
                                            <td class="total_good">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $good }}</p>
                                                </center>
                                            </td>
                                            <td class="total_outstanding">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $outstanding }}</p>
                                                </center>
                                            </td>
                                            <td class="total_total">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $total }}</p>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <p style="font-size:1.2em;">-</p>
                                                </center>
                                            </td>
                                            <td class="total_total">
                                                <center>
                                                    <p style="font-size:1.2em;">{{ $total_kpi }}</p>
                                                </center>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
        $('#zero_config').DataTable({
            "aLengthMenu": [100, 10, 25, 50],
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
        // Radialize the colors
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
                    y: {{ $na }}
                }, {
                    name: 'Unacceptable',
                    y: {{ $unacceptable }}
                }, {
                    name: 'Need Improvement',
                    y: {{ $ni }}
                }, {
                    name: 'Good',
                    y: {{ $good }}
                }, {
                    name: 'Outstanding',
                    y: {{ $outstanding }}
                }]
            }]
        });

        $('.cari_tahun').change(function(argument) {
            var tahun = $(this).val();
            $.ajax({
                url: '{{ route('filter_specialist_report_chart') }}',
                type: 'get',
                data: '&tahun=' + tahun + '&id=' + '{{ Auth::user()->m_id }}',
                success: function(data) {
                    $('.drop_here').html(data);
                },
                error: function(data) {

                }

            })
        })


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
            credits: {
                enabled: false
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
@endpush
