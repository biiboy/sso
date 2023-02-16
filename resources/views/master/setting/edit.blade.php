@extends('master')

@push('title')
    Master
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Master Setting Menu</h4>
                        <h5 class="card-subtitle">Edit</h5>
                        <br>
                        <form id="save">
                            {{-- HIDDEN --}}
                            <input class="form-control" hidden="" type="text" name="menu_id"
                                value="{{ $data->menu_id }}" id="menu_id">
                            {{--  --}}
                            <div class="form-group row mb-3">
                                <label for="menu_name" class="col-2 col-form-label">Name</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="menu_name"
                                        value="{{ $data->menu_name }}" id="menu_name">
                                </div>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary" type="button" onclick="save()">
                                    <i class="ti-save me-1"></i>
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
                                type: "get",
                                url: baseUrl + '/setting/setting_menu/update/' + '{{ $data->menu_id }}',
                                data: $('#save').serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'topRight',
                                            title: 'Success!',
                                            message: 'Data Berhasil Disimpan!',
                                        });

                                        location.href = '{{ route('setting_menu') }}'
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
