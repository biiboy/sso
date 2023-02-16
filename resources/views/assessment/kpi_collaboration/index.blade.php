@extends('master')

@push('title')
    Assesment > KPI Collaboration
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">KPI Details Collaboration</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label><strong>Year</strong></label>
                        <select class="form-control form-select year" name="year" onchange="filter()">
                            <option value="">All</option>
                            @foreach ($year as $element)
                                <option value="{{ $element->p_year }}" @if ($element->p_year == date('Y')) selected @endif>
                                    {{ $element->p_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>Key Result Area</th>
                            <th>Goal</th>
                            <th>Target Date</th>
                            <th>Status</th>
                            <th>Submit Date</th>
                            <th>Submit By</th>
                            <th>Collaboration</th>
                            <th>Action</th>
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
    <script type="text/javascript">
        let url = '{{ route('kpi_collaboration_datatable') }}';
        var table = $("#zero_config").DataTable({
            pageLength: 100,
            processing: true,
            lengthMenu: [
                [100, 10, 25, 50, -1],
                [100, 10, 25, 50, "Semua"],
            ],
            ajax: {
                url: url,
                type: "GET",
                data: {
                    tahun() {
                        return $('.year').val();
                    },
                },
            },
            columns: [
                // { data: "code" },
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
                    data: "submited_date",
                    className: "text-center",
                },
                {
                    data: "m_name",
                    className: "text-center",
                },
                {
                    data: "collaboration",
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
                    // messageTop: "Dokumen dikeluarkan tanggal " + moment().format("L"),
                    // footer: true,
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

        function filter() {
            table.ajax.reload(null, false);
        }
    </script>
@endpush
