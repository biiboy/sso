@extends('master')

@push('title')
    Master 
@endpush
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">
            <h3 class="card-title">Mail Setting</h3>
        </div>
        <div class="card-body">
            
                @if (session('message'))
                    <div class="alert alert-{{ session('error_message') ? 'danger' : 'success' }}">
                        {{ session('message') }}
                        @if (session('error_message'))
                            Response: <strong>{{ session('error_message') }}</strong>
                        @endif
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('master_email_save') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('host') ? ' has-error' : '' }}">
                        <label for="host" class="col-md-4 control-label">SMTP Host</label>
                        <div class="col-md-6">
                            <input id="host" type="text" class="form-control" name="host" value="{{ old('host') ?: $mailSettings['host'] }}" required autofocus>
                            @if ($errors->has('host'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('host') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
                        <label for="port" class="col-md-4 control-label">SMTP Port</label>
                        <div class="col-md-6">
                            <input id="port" type="number" min="0" class="form-control" name="port" value="{{ old('port') ?: $mailSettings['port'] }}" required>
                            @if ($errors->has('port'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('port') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Timeout (s)</label>
                        <div class="col-md-2">
                            <input id="timeout" class="form-control" type="number" min="60" name="timeout" value="{{ old('timeout') ?: $mailSettings['timeout'] }}">
                        </div>
                        <label class="col-md-2 col-md-offset-1 control-label">Use TLS/SSL</label>
                        <div class="col-md-1">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="encryption" {{ old('encryption') || $mailSettings['encryption'] ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="col-md-4 control-label">Account Username</label>
                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username')  ?: $mailSettings['username'] }}" required>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Account Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" min="0" class="form-control" name="password" value="{{ old('password')  ?: $mailSettings['password'] }}" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    Save & Test Connection
                </button>
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
