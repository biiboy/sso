@extends('master')

@push('title')
    Master
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Master User</h3>
            <a href="{{ route('master_user_create') }}" class="btn btn-success align-items-center">
                <i class="fs-3 ti-plus me-1"></i>
                Add Data
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive p-1">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Last Login</th>
                            <th>Last Logout</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $element)
                            <tr>
                                <td>{{ $element->m_code }}</td>
                                <td>{{ $element->m_username }}</td>
                                <td>{{ $element->m_name }}</td>
                                <td>{{ $element->m_lastlogin }}</td>
                                <td>{{ $element->m_lastlogout }}</td>
                                <td>{{ $element->m_status }}</td>
                                <td>{{ $element->m_created_at }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-sm btn-warning p-2 me-1"
                                            href="{{ route('master_user_edit', ['id' => $element->m_id]) }}"><i
                                                class="ti-pencil"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger p-2 ms-1"
                                            onclick="del({{ $element->m_id }})"><i class="ti-trash"></i></button>
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
        });

        function del(id) {
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
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button style="background-color:red;"> Delete </button>', function(instance, toast) {
                        $.ajax({
                            url: baseUrl + '/master' + '/master_user/delete/' + id,
                            type: 'get',
                            success: function(data) {
                                if (data.status == 'sukses') {
                                    iziToast.success({
                                        position: 'topRight',
                                        message: 'Successfully Deleted!'
                                    });
                                    setTimeout(() => {
                                        window.location = ("{{ route('master_user') }}")
                                    }, 1250);
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
                    }, true],
                    ['<button> Cancel </button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp',
                            onClosing: function(instance, toast, closedBy) {
                                console.info('closedBy: ' + closedBy);
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
                    console.info('closedBy: ' + closedBy);
                }
            });
        }
    </script>
@endpush
