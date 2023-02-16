@extends('master')
@push('title')
    Audit Log
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white"><strong>Details Log</strong></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive drop_here_table_index">
                <table id="zero_config" class="table table-vcenter card-table rounded border dataTable no-footer">
                    <thead>
                        <tr>
                            <th width="800px">Description</th>
                            <th width="800px">Activity</th>
                            <th>Reference KPI</th>
                            <th>Reference TS</th>
                            <th>Created Date Activity</th>
                            <th>Activity By</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($audit as $element)
                            <tr>
                                <td class="text-justify">{{ $element->dl_name }}</td>
                                <td class="text-justify">{{ $element->dl_desc }}</td>
                                <td align="center">{{ $element->dl_ref_id }}</td>
                                <td align="center">
                                    @if ($element->dl_ref_id_detail == null)
                                        -
                                    @else
                                        {{ $element->dl_ref_id_detail }}
                                    @endif
                                </td>
                                <td align="Center">
                                    {{ date('d-M-Y', strtotime($element->dl_created_at)) }}<br>
                                    {{ date('H:i:s A', strtotime($element->dl_created_at)) }}
                                </td>
                                <td align="Center">{{ $element->m_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#zero_config').dataTable({
            pageLength: 100,
            processing: true,
            lengthMenu: [
                [100, 10, 25, 50, -1],
                [100, 10, 25, 50, "Show All"],
            ],
        });
        $(".dataTables_length select").addClass("form-select mb-2");
        $(".dataTables_filter input").addClass("mb-2");
        $(".dataTables_filter input").removeClass("form-control-sm");
    </script>
@endpush
