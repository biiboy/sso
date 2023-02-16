@extends('master')

@push('title')
    Master
@endpush
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Edit Role</h3>
            <a href="{{ route('master_access') }}" class="btn btn-warning align-items-center">
                <i class="fs-3 ti-arrow-left me-1"></i>
                kembali
            </a>
        </div>
        <div class="card-body">
            <form id="save">
                <div class="form-group row mb-3">
                    <label for="job_role" class="col-2 col-form-label">Job Role</label>
                    <div class="col-10">
                        <select class="form-control" name="job_role" id="job_role">
                            @foreach ($job_role as $element)
                            @if ($element->u_id == $data[0]->u_id)
                                <option value="{{ $element->u_id }}" selected="">{{ $element->u_id }} / {{ $element->u_name }}</option>
                            @else
                                <option value="{{ $element->u_id }}">{{ $element->u_id }} / {{ $element->u_name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="menu" class="col-2 col-form-label">Menu</label>
                    <div class="col-10">
                        <select multiple="" name="menu[]" class="form-control" id="exampleFormControlSelect2" style="height: 300px;">
                            @foreach ($menu as $element => $value)
                                @if ($data->contains('menu_id', $value->menu_id))
                                <option value="{{ $value->menu_id }}" selected>{{ $value->menu_id }} / {{ $value->menu_name }}</option>
                                @else
                                <option value="{{ $value->menu_id }}">{{ $value->menu_id }} / {{ $value->menu_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="m_status" class="col-2 col-form-label">Status</label>
                    <div class="col-10">
                        <select class="form-control" name="m_status" id="m_status">
                            <option selected="" disabled="">- Chose -</option>
                            <option value="aktif" @if ($data[0]->role_status == 'aktif')
                                {{ "selected" }}
                            @endif>Active</option>
                            <option value="tidak" @if ($data[0]->role_status == 'tidak')
                                {{ "selected" }}
                            @endif>Inactive</option>
                        </select>
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
                function (instance, toast) {

                  $.ajaxSetup({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "get",
                        url:'{{ route('master_access_update') }}',
                        data: $('#save').serialize(),
                        processData: false,
                        contentType: false,
                      success:function(data){
                        if (data.status == 'sukses') {
                            iziToast.success({
                                icon: 'fa fa-save',
                                position:'topRight',
                                title: 'Success!',
                                message: 'Data Berhasil Disimpan!',
                            });

                            location.href = '{{ route('master_access') }}'
                        }else if (data.status == 'ada') {
                            iziToast.warning({
                                icon: 'fa fa-save',
                                position:'topRight',
                                title: 'Error!',
                                message:'Level Sudah Terpakai',
                            });

                        }
                      },error:function(){
                        iziToast.error({
                            icon: 'fa fa-info',
                            position:'topRight',
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
                function (instance, toast) {
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
