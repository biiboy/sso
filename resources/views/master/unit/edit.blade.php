@extends('master')

@push('title')
    Master
@endpush
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Edit Unit</h3>
            <a href="{{ route('master_unit') }}" class="btn btn-warning align-items-center">
                <i class="fs-3 ti-arrow-left me-1"></i>
                kembali
            </a>
        </div>
        <div class="card-body">
            <form id="save" method="POST">
                <div class="form-group row">
                    <label for="u_name" class="col-2 col-form-label">Name</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="u_name" value="{{ $unit->u_name }}"
                            id="u_name">
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn btn-primary" type="button" onclick="save()"><i class="fas fa-share"> </i> Save</button>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('extra_scripts')
    <script type="text/javascript">
        function save() {
            iziToast.show({
                overlay: true,
                close: false,
                timeout: 20000,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Save Data!',
                message: 'Apakah Anda Yakin ?!',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Save</button>',
                        function(instance, toast) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'get',
                                url: '{{ route("master_unit_update", ["id"=> $unit->u_id]) }}',
                                data: $('#save').serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    // console.log("taii");
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'topRight',
                                            title: 'Success!',
                                            message: 'Data Berhasil Disimpan!',
                                        });

                                        location.href = '{{ route('master_unit') }}'
                                    } else if (data.status == 'ada') {
                                        iziToast.warning({
                                            icon: 'fa fa-save',
                                            position: 'topRight',
                                            title: 'Error!',
                                            message: 'Level Sudah Terpakai',
                                        });

                                    }
                                },
                                error: function() {
                                    iziToast.error({
                                        icon: 'fa fa-info',
                                        position: 'topRight',
                                        title: 'Error!',
                                        message: data.message,
                                    });
                                }
                            });
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ],
                    [
                        '<button style="background-color:#d83939;color:white;">Cancel</button>',
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
