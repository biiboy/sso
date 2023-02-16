@extends('master')

@push('title')
    Assesment > My KPI
@endpush

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">KPI Details</h3>
            <a href="{{ route('assessment_kpi_create') }}" class="btn btn-success align-items-center">
                <i class="fs-3 ti-plus me-1"></i>
                Add KPI
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label for="name"><strong>Full Name</strong></label>
                        <input type="text" class="form-control" value="{{ session('name') }}"
                            style="pointer-events: none;background: #D3D3D3">
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="form-group">
                        <label for="role"><strong>Job Role</strong></label>
                        <input type="text" value="{{ session('role') }}" class="form-control"
                            style="pointer-events: none;background: #D3D3D3">
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label><strong>Year</strong></label>
                        <select class="form-control form-select year" name="year" onchange="filter(),year()">
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
            <div class="row">
                @if (session('coor') != null)
                    @if (auth()->user()->m_flag != 3)
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label><strong>Coordinator Name</strong></label>
                                <input type="text" class="form-control" value="{{ session('coor') }}"
                                    style="pointer-events: none;background: #D3D3D3">
                            </div>
                        </div>
                    @endif
                @endif
                @if (session('lead') != null)
                    @if (auth()->user()->m_flag != 2)
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label><strong>Lead Name</strong></label>
                                <input type="text" class="form-control" value="{{ session('lead') }}"
                                    style="pointer-events: none;background: #D3D3D3">
                            </div>
                        </div>
                    @endif
                @endif
                @if (session('manager') != null)
                    @if (auth()->user()->m_flag != 1)
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label><strong>Manager Name</strong></label>
                                <input type="text" class="form-control" value="{{ session('manager') }}"
                                    style="pointer-events: none;background: #D3D3D3">
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="row mt-2">
                <div class="col-md-10">
                    <h4><strong>TOTAL KPI = <kk class="total_kpi">{{ $total }}</kk></strong></h4>
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
                            <th>Collaboration</th>
                            <th>Submit Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                ajax: {
                    url: baseUrl + "/assessment/datatable_assessment_kpi",
                    type: "GET",
                    data: {
                        tahun() {
                            return $('.year').val();
                        },
                    }

                },
                columns: [{
                        data: "k_label",
                        className: "text-center",
                    },
                    {
                        data: "goal",
                        name: 'k_goal',
                        searchable: true,
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
                        data: "submittedDate",
                        className: "text-center",
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: true
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

        function year(argument) {
            var tahun = $('.year').val();
            $.ajax({
                url: baseUrl + '/assessment/assessment_kpi/total_kpi',
                type: 'get',
                data: '&tahun=' + tahun,
                success: function(data) {
                    $('.total_kpi').html(data);
                },
            })
        }

        function deleteData(params) {
            var this_val = $('.delete').val();

            iziToast.question({
                theme: 'dark',
                overlay: true,
                timeout: false,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                backgroundColor: '#1f1f22',
                icon: 'fa fa-info-circle',
                title: 'Confirmation',
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button style="background-color:red;"> Delete </button>', function(instance, toast) {
                        $.ajax({
                            url: baseUrl + '/assessment/assessment_kpi/delete/' + this_val,
                            type: 'get',
                            success: function(data) {
                                if (data.status == 'sukses') {
                                    iziToast.success({
                                        position: 'center',
                                        message: 'Successfully Deleted!'
                                    });
                                    window.location = ('{{ route('assessment_kpi') }}')
                                } else {
                                    iziToast.error({
                                        position: 'center',
                                        message: 'Error Check your data! '
                                    });
                                }
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

        function resubmitData(params) {
            iziToast.question({
                theme: 'dark',
                overlay: true,
                timeout: false,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                backgroundColor: '#1f1f22',
                icon: 'fa fa-info-circle',
                title: 'Confirmation',
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button style="background-color:red;"> Resubmit </button>', function(instance,
                        toast) {
                        $.ajax({
                            url: baseUrl + '/assessment/assessment_kpi/resubmit/' +
                                params,
                            type: 'get',
                            success: function(data) {
                                iziToast.success({
                                    position: 'center',
                                    message: '<strong>Successfully Loaded!</strong>'
                                });
                                window.location = (baseUrl +
                                    '/assessment/assessment_kpi/resubmit/' +
                                    params);
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
                                    closedBy
                                ); // The return will be: 'closedBy: buttonName'
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
        }

        function deleteData(params) {
            var this_val = $('.delete').val();

            iziToast.question({
                theme: 'dark',
                overlay: true,
                timeout: false,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                backgroundColor: '#1f1f22',
                icon: 'fa fa-info-circle',
                title: 'Confirmation',
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    ['<button style="background-color:red;"> Delete </button>', function(instance,
                        toast) {
                        $.ajax({
                            url: baseUrl + '/assessment/assessment_kpi/delete/' + this_val,
                            type: 'get',
                            success: function(data) {
                                if (data.status == 'sukses') {
                                    iziToast.success({
                                        position: 'center',
                                        message: 'Successfully Deleted!'
                                    });
                                    window.location = (
                                        '{{ route('assessment_kpi') }}')
                                } else {
                                    iziToast.error({
                                        position: 'center',
                                        message: 'Error Check your data! '
                                    });
                                }
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
                                console.info('closedBy: ' +
                                    closedBy
                                );
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
                        closedBy);
                }
            });
        }
    </script>
@endpush
