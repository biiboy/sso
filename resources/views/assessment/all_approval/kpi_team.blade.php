@extends('master')

@push('title')
    {{ $tittle }}
@endpush

@push('styles')
    <style type="text/css">
        .table>tbody>tr>td {
            vertical-align: middle
        }
    </style>
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white"><b>Information Details KPI Team</b></h4>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Year</label>
                            <select class="form-control form-select year" onchange="filter()">
                                <option value="ALL">All</option>
                                @foreach ($year as $element)
                                    <option @if ($element->p_year == date('Y')) selected @endif
                                        value="{{ $element->p_year }}">
                                        {{ $element->p_year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive drop_here_table_index mt-3">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>
                                Submitted By
                            </th>
                            <th>
                                Key Result Area
                            </th>
                            <th>
                                Goals
                            </th>
                            <th>
                                Target Date
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var urlDatatable = 'kosong';
        if ("{!! $tittle !!}" == 'Assessment > KPI Team > All IT Services') {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_all_services_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > All IT Asset") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_all_asset_datatable";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Asset Gempol") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_gmp_asset_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Asset Jakarta") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_jkt_asset_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Asset Surabaya") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_sby_asset_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Asset Kediri") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_kdr_asset_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Helpdesk Jakarta") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_jkt_helpdesk_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > All IT Support") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_all_support_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Support Gempol") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_gmp_support_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Support Kediri") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_kdr_support_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Support Surabaya") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_sby_support_datatables";
        } else if ("{!! $tittle !!}" == "Assessment > KPI Team > IT Support Jakarta") {
            var urlDatatable = baseUrl + "/assessment/assessment_all_approval/filter_jkt_support_datatables";
        }

        var table;

        if (urlDatatable == 'kosong') {
            alert('Datatable route tidak ditemukan');
        }

        $(document).ready(function() {
            table = $("#zero_config").DataTable({
                pageLength: 100,
                processing: true,
                lengthMenu: [
                    [100, 10, 50, 100, -1],
                    [100, 10, 25, 50, "Show All"],
                ],
                ajax: {
                    url: urlDatatable,
                    type: "GET",
                    data: {
                        tahun() {
                            return $('.year').val();
                        },
                    }
                },
                columns: [{
                        data: "submitter",
                        className: "text-center"
                    },
                    {
                        data: "k_label",
                        className: "text-left"
                    },
                    {
                        data: "goal",
                        className: "text-justify",
                        name: 'k_goal',
                        searchable: true,
                    },
                    {
                        data: "date",
                        name: "k_targetdate",
                        className: "text-center",
                    },
                    {
                        data: "status",
                        className: "text-center",
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: true
                    },
                ],
                buttons: [{
                        extend: "print",
                        text: "Print Semua",
                        exportOptions: {
                            modifier: {
                                selected: null,
                            },
                            columns: ":visible",
                        },
                        messageTop: "Dokumen dikeluarkan tanggal " + moment().format("L"),
                        header: true,
                    },
                    {
                        extend: "csv",
                    },
                    {
                        extend: "print",
                        text: "Print Yang Dipilih",
                        exportOptions: {
                            columns: ":visible",
                        },
                    },
                    {
                        extend: "excelHtml5",
                        exportOptions: {
                            columns: ":visible",
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        exportOptions: {
                            columns: [0, 1, 2, 5],
                        },
                    },
                    {
                        extend: "colvis",
                        postfixButtons: ["colvisRestore"],
                        text: "Sembunyikan Kolom",
                    },
                ],
            });
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        });

        function filter() {
            table.ajax.reload(null, false);
        }
    </script>
@endpush
