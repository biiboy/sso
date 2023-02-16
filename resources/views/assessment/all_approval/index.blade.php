@extends('master')

@push('title')
    {{ $tittle }}
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white">
                <b>KPI Details</b>
            </h4>
        </div>
        <div class="card-body">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Year</label>
                    <select class="form-control form-select year" onchange="filter()">
                        <option value="ALL">All</option>
                        @foreach ($year as $element)
                            <option @if ($element->p_year == date('Y')) selected @endif value="{{ $element->p_year }}">
                                {{ $element->p_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>
                                Submitted By
                            </th>
                            <th>
                                Submit Date
                            </th>
                            <th>
                                First Due Date
                            </th>
                            <th>
                                Key Result Area
                            </th>
                            <th>
                                Goal
                            </th>
                            <th>
                                Target Date
                            </th>
                            <th>
                                Status
                            </th>

                            <th>
                                Collaboration
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var table

        $(function() {
            table = $("#zero_config").DataTable({
                pageLength: 100,
                processing: true,
                lengthMenu: [
                    [100, 10, 25, 50, -1],
                    [100, 10, 25, 50, "Show All"],
                ],
                ajax: {
                    url: baseUrl + "/assessment/assessment_all_approval_datatables",
                    type: "GET",
                    data: {
                        tahun() {
                            return $('.year').val();
                        },
                    }
                },

                columns: [{
                        data: "submitter"
                    },
                    {
                        data: "created",
                        className: "text-center",
                    },
                    {
                        data: "firstDueDate",
                        className: "text-center",
                    },
                    {
                        data: "k_label"
                    },
                    {
                        data: "goal",
                        className: "text-justify",
                    },
                    {
                        data: "date",
                        className: "text-center",
                    },
                    {
                        data: "status",
                        className: "text-center",
                    },
                    {
                        data: "collab",
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

        })

        function filter() {
            table.ajax.reload(null, false);
        }
    </script>
@endpush
