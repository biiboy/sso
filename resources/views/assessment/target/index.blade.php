@extends('master')

@push('title')
    KPI Target
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white"><strong>KPI Target Details</strong></h4>
        </div>
        <div class="card-body">
            <div class="text-right mb-3">
            </div>

            <div class="row mb-3">
                <div class="col-md-10">
                    @if (auth()->user()->m_flag == 1)
                        <a href="{{ route('assessment_target_create') }}" class="btn btn-success">
                            <i class="ti-plus me-1"></i>
                            Add KPI Target
                        </a>
                    @endif
                </div>
            </div>

            <div class="table-responsive drop_here_table_index">
                <table id="zero_config" class="table table-vcenter card-table rounded border">
                    <thead>
                        <tr>
                            <th>
                                <strong>
                                    <center>Year</center>
                                </strong>
                            </th>
                            <th width="100px">
                                <strong>
                                    <center>Title</center>
                                </strong>
                            </th>
                            <th width="500px">
                                <strong>
                                    <center>Detail Description</center>
                                </strong>
                            </th>
                            <th>
                                <strong>
                                    <center>Status</center>
                                </strong>
                            </th>
                            <th>
                                <strong>
                                    <center>Created Date</center>
                                </strong>
                            </th>
                            <th width="100px">
                                <strong>
                                    <center>Action</center>
                                </strong>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $element)
                            <tr>
                                <td align="center">{{ $element->kpdf_period }}</td>
                                <td align="center">{{ $element->kpdf_title }}</td>
                                <td class="text-justify">{!! $element->kpdf_dec !!}</td>
                                <td align="Center">
                                    @if ($element->kpdf_status_id == 21)
                                        Publish
                                    @elseif ($element->kpdf_status_id == 22)
                                        Draft
                                    @endif
                                </td>
                                <td align="center">
                                    {{ date('d-M-Y', strtotime($element->kpdf_created_at)) }}<br>{{ date('H:i A', strtotime($element->kpdf_created_at)) }}
                                </td>

                                <td>
                                    <center>
                                        @if ($element->kpdf_status_id == 22)
                                            <div class="col mb-1">
                                                <a class="btn btn-sm btn-warning tombol"
                                                    href="{{ route('assessment_target_edit', ['id' => $element->kpdf_id]) }}"
                                                    Style="width: 100px;">
                                                    <i class="ti-pencil-alt me-1"></i>
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="col mb-1">
                                                <a class="btn btn-sm btn-primary tombol"
                                                    href="{{ route('assessment_target_view', ['id' => $element->kpdf_id]) }}"
                                                    Style="width: 100px;">
                                                    <i class="ti-eye me-1"></i>
                                                    View
                                                </a>
                                            </div>
                                            <div class="col mb-1">
                                                <button type="button" class="btn btn-sm btn-danger tombol"
                                                    onclick="delete_file({{ $element->kpdf_id }})" Style="width: 100px;">
                                                    <i class="ti-trash me-1"></i>
                                                    Delete
                                                </button>
                                            </div>
                                        @endif
                                        @if ($element->kpdf_status_id == 21)
                                            <div class="col">
                                                <a class="btn btn-sm btn-primary tombol"
                                                    href="{{ route('assessment_target_view', ['id' => $element->kpdf_id]) }}"
                                                    Style="width: 100px;">
                                                    <i class="ti-eye me-1"></i>
                                                    View
                                                </a>
                                            </div>
                                        @endif
                                    </center>
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
        let table;
        $(document).ready(function() {
            table = $("#zero_config").DataTable({
                pageLength: 100,
                processing: true,
                lengthMenu: [
                    [100, 10, 25, 50, -1],
                    [100, 10, 25, 50, "Semua"],
                ],
            });
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        });

        function delete_file(argument) {
            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Confirmation',
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Yes</button>',
                        function(instance, toast) {
                            $('.preloader').show();

                            $.ajax({
                                url: ('{{ route('assessment_target_delete') }}'),
                                type: "get",
                                data: '&id=' + argument,
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            position: 'topRight',
                                            message: 'Successfully Deleted!'
                                        });
                                        location.href = '{{ route('assessment_target') }}'
                                    }
                                }
                            });

                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ],
                    [
                        '<button style="background-color:#d83939;color:white;">No</button>',
                        function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ]
                ]
            });
        }
    </script>
@endpush
