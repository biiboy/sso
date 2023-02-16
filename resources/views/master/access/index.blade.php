@extends('master')

@push('title')
    Master
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Master Access</h3>
            <a href="{{ route('master_access_create') }}" class="btn btn-success align-items-center">
                <i class="fs-3 ti-plus me-1"></i>
                Add Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>Job Id</th>
                            <th>Job Role</th>
                            <th>Menu Access</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $element)
                            <tr>
                                <td>{{ $element->role_id }}</td>
                                <td>{{ $element->u_name }}</td>
                                <td>
                                    @foreach ($data_menu as $ee)
                                        @if ($element->role_id == $ee->role_id)
                                            ,{{ $ee->menu_name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning p-2 me-1"
                                            href="{{ route('master_access_edit', ['id' => $element->role_id]) }}"><i
                                                class="ti-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger p-2 ms-1"
                                            onclick="del({{ $element->role_id }})"><i class="ti-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        });
    </script>
@endpush
