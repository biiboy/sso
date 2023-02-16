@extends('master')

@push('title')
    Master
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Master Menu Setting</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive p-1">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menu as $element)
                            <tr>
                                <td>{{ $element->menu_name }}</td>
                                <td class="text-center">
                                    <a class="btn waves-effect waves-light btn-sm btn-warning p-2" href="{{ route('setting_menu_edit', ['id' => $element->menu_id]) }}"><i class="ti-pencil"></i></a>
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
            $('#zero_config').DataTable();
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        });
    </script>
@endpush
