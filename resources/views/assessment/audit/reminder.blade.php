@extends('master')
@push('title')
    Audit Log
@endpush
@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="m-b-0 text-white"><strong>Details Log</strong></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive drop_here_table_index">
                <table id="zero_config" class="table table-vcenter card-table rounded border dataTable no-footer">
                    <thead>
                        <tr>
                            <th width="300px">
                                    ID
                            </th>
                            <th width="300px">
                                    ID KPI
                            </th>
                            <th width="300px">
                                    ID TACTICAL STEP
                            </th>
                            <th width="800px">
                                    TACTICAL STEP
                            </th>
                            <th width="300px">
                                    DUE DATE
                            </th>
                            <th width="300px">
                                    CREATED AT
                            </th>
                            <th width="300px">
                                    REMINDER
                            </th>
    
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($reminder as $element)
                            <tr>
                                <td class="text-justify">{{ $element->dlr_id }}</td>
                                <td>{{ $element->dlr_kpi_id }}</td>
                                <td align="center">{{ $element->dlr_kpid_id }}</td>
                                <td class="text-justify">{{ $element->dlr_tacticalstep }}</td>
                                <td align="Center">
                                    {{ date('d-M-Y', strtotime($element->dlr_duedate)) }}<br>
                                    {{-- {{ date('H:i:s A',strtotime($element->dl_created_at)) }} --}}
                                </td>
    
                                <td align="center">{{ $element->dlr_created_at }}</td>
                                {{-- <td align="Center">
                                        {{ date('d-M-Y',strtotime($element->dlr_created_at)) }}<br>
                                        {{ date('H:i:s A',strtotime($element->dlr_created_at)) }}
                                    </td> --}}
                                <td align="Center">{{ $element->dlr_send_to }}</td>
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
            'order': [
                [5, 'desc']
            ],
            'aLengthMenu': [10, 25, 50, 100]
        });
        $(".dataTables_length select").addClass("form-select mb-2");
        $(".dataTables_filter input").addClass("mb-2");
        $(".dataTables_filter input").removeClass("form-control-sm");
    </script>
@endpush
