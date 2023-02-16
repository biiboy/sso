@extends('master')

@push('title')
    Master
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Master Unit</h3>
            <a href="{{ route('master_unit_create') }}" class="btn btn-success align-items-center">
                <i class="fs-3 ti-plus me-1"></i>
                Add Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive p-1">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                            <tr>
                                <td>{{ $unit->u_id }}</td>
                                <td>{{ $unit->u_name }}</td>
                                <td>{{ $unit->u_created_at }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning p-2 me-1"
                                            href="{{ route('master_unit_edit', ['id' => $unit->u_id]) }}"><i
                                                class="ti-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger p-2 ms-1"
                                            onclick="del({{ $unit->u_id }})"><i class="ti-trash"></i></button>
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
            $('#zero_config').DataTable();
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
            $('.delete').on('click', function() {
                var this_val = $(this).val();
                iziToast.question({
                    theme: 'dark',
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    backgroundColor: '#1f1f22',
                    icon: 'fa fa-info-circle',
                    title: 'Are you Sure!',
                    message: '',
                    position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    progressBarColor: 'rgb(0, 255, 184)',
                    buttons: [
                        ['<button style="background-color:red;"> Delete </button>', function(
                            instance, toast) {

                            $.ajax({
                                url: baseUrl + '/master' + '/master_unit/delete/' +
                                    this_val,
                                type: 'get',
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            position: 'topRight',
                                            message: 'Successfully Deleted!'
                                        });
                                        window.location = (
                                            '{{ route('master_unit') }}')
                                    } else {
                                        iziToast.error({
                                            position: 'topRight',
                                            message: 'Error Check your data! '
                                        });
                                    }
                                },
                                error: function(data) {

                                }

                            })

                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }, true], // true to focus
                        ['<button> Cancel </button>', function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp',
                                onClosing: function(instance, toast, closedBy) {
                                    console.info('closedBy: ' +
                                    closedBy); // The return will be: 'closedBy: buttonName'
                                }
                            }, toast, 'buttonName');
                            instance.hide({
                                transitionOut: 'fadeOut'
                            }, toast, 'button');
                        }]
                    ],
                    onOpening: function(instance, toast) {
                        console.info('callback abriu!');
                    },
                    onClosing: function(instance, toast, closedBy) {
                        console.info('closedBy: ' +
                        closedBy); // tells if it was closed by 'drag' or 'button'
                    }
                });

            });
        });
    </script>
@endpush
