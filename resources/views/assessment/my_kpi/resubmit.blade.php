@extends('master')

@push('title')
    Resubmit KPI
@endpush

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; }
        #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; }
        html>body #sortable li { line-height: 1.2em; }
        .ui-state-highlight { line-height: 1.2em; }
    </style>
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        <button class="btn btn-warning me-2" type="button" onclick="draft()">
            <i class="ti-save me-1"></i>
            Save
        </button>
        <button class="btn btn-success me-2" type="button" onclick="save()">
            <i class="ti-email me-1"></i>
            Submit
        </button>
        <button class="btn btn-danger me-2" type="button" onclick="cancel()">
            <i class="ti-close me-1"></i>
            Cancel
        </button>
        <button class="btn btn-primary btnAdd" type="button">
            <i class="ti-plus me-1"></i>
            Add Tactical Step
        </button>
    </div>
@endpush

@section('content')
    <div class="card">
        <form id="save">
            <div class="card-body">
                <input type="hidden" name="hidden_id_header" id="hidden_id_header" value="{{ $data_edit->k_id }}">
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label"><b>Collaboration</b></label>
                    <div class="col-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="k_collab_assets" type="checkbox" id="k_collab_assets"
                                value="{{ $data_edit->k_collab_assets }}">
                            <label class="form-check-label" for="inlineCheckbox1">IT Asset</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="k_collab_helpdesk" type="checkbox" id="k_collab_helpdesk"
                                value="{{ $data_edit->k_collab_helpdesk }}">
                            <label class="form-check-label" for="inlineCheckbox2">IT Helpdesk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="k_collab_support" type="checkbox" id="k_collab_support"
                                value="{{ $data_edit->k_collab_support }}">
                            <label class="form-check-label" for="inlineCheckbox3">IT Support</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Key Result Area</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>

                    <div class="col-10">
                        <input class="form-control" type="text" name="k_label" id="k_label"
                            value="{{ $data_edit->k_label }}">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label">
                        <b>Goal</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>
                    <div class="col-10">
                        <textarea class="form-control mymce" type="text" name="k_goal" id="mymce" name="mymce">{!! $data_edit->k_goal !!}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_targetdate" class="col-2 col-form-label">
                        <b>Target Date</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>
                    <div class="col-10">
                        @if ($data_edit->k_targetdate < date('Y-m-d'))
                            <input class="form-control datepicker-autoclose_hd date_req_target merah" type="text"
                                name="k_targetdate" id="k_targetdate"
                                value="{{ date('d-F-Y', strtotime($data_edit->k_targetdate)) }}">
                        @else
                            <input class="form-control datepicker-autoclose_hd date_req_target" type="text"
                                name="k_targetdate" id="k_targetdate"
                                value="{{ date('d-F-Y', strtotime($data_edit->k_targetdate)) }}">
                        @endif
                    </div>
                </div>

                <div class="drop_here_delete"></div>

                <ul class="drop_here" id="sortable">
                    @foreach ($data as $index => $element)
                        <li class="card text-left gg mb-3 ui-state-default bg-white">
                            <input type="hidden" value="1" class="key_k">
                            <div class="card-header" style="font-size: 30px;">
                                <b class='fz_18'>Tactical Step {{ $index + 1 }}</b>
                                <input type="hidden" class="id" name="id[]" value="{{ $element->kd_id }}">
                                <div class="ms-auto">
                                    <div class="dropdown d-inline-block">
                                        <div class="text-right">
                                            <input type="button" class="btn btn-danger btnRemove" value="Remove">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <textarea class="form-control" rows="3" name="kd_tacticalstep[]">{{ $element->kd_tacticalstep }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label"><b>Meassured By</b></label>
                                        <select class="form-control form-select" name="kd_measure_id[]">
                                            @foreach ($measure as $el)
                                                @if ($el->dm_id == $element->kd_measure_id)
                                                    <option value="{{ $el->dm_id }}" selected="">
                                                        {{ $el->dm_name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $el->dm_id }}">
                                                        {{ $el->dm_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($element->kd_duedate < date('Y-m-d'))
                                        <div class="form-group col-md-3">
                                            <label class="control-label"><b>Due Date </b></label>
                                            <input type="text" name="kd_duedate[]"
                                                data-dateold="{{ $element->kd_duedate }}"
                                                value="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}"
                                                id="firstName"
                                                class="form-control datepicker-autoclose_hd date_req merah">
                                            <input type="hidden" name="kd_duedate_dt[]" id="duedate"
                                                class="form-control date_req_dt_{{ $index }} datepicker-autoclose_dt date_{{ $index }}"
                                                placeholder="">
                                        </div>
                                    @else
                                        <div class="form-group col-md-3">
                                            <label class="control-label"><b>Due Date</b></label>
                                            <input type="text" name="kd_duedate[]"
                                                data-dateold="{{ $element->kd_duedate }}"
                                                value="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}"
                                                id="firstName" class="form-control datepicker-autoclose_hd date_req"
                                                placeholder="">
                                            <input type="hidden" name="kd_duedate_dt[]" id="duedate"
                                                class="form-control date_req_dt_{{ $index }} datepicker-autoclose_dt date_{{ $index }}"
                                                placeholder="">
                                        </div>
                                    @endif


                                    <div class="form-group col-md-2">
                                        <label class="control-label"><b>Result</b></label>
                                        <input type="text" name="kd_result_id[]" readonly="" value="N/A"
                                            class="result form-control" placeholder="Result">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label class="control-label"><b>Status</b></label>
                                        <input type="text" name="kd_status_id[]" readonly="" id="status"
                                            class="form-control form-control-danger" value="N/A" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            tinymce.init({
                selector: "textarea#mymce",
                entity_encoding: "raw",
                apply_source_formatting: false,
                verify_html: false,
                allow_html_in_named_anchor: false,
                forced_root_block: '',
                element_format: false,
                theme: "modern",
                fontsize_formats: "8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
                elementpath: true,
                height: 200,
                statusbar: true,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor charactercount"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | sizeselect | bold italic | fontselect |  fontsizeselect ",
            });

            $(".datepicker-autoclose_hd").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd-MM-yyyy',

            })
            $('.datepicker-autoclose_hd').change(function(argument) {
                var today = new Date();
                var todayString = moment(today).format("YYYY-MM-DD");
                var valdate = moment($(this).val(), 'DD-MMMM-YYYY').format("YYYY-MM-DD");

                if (valdate < todayString) {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        displayMode: 'once',
                        position: 'center',
                        title: 'Warning!',
                        message: 'Target Date less than Now',
                    });
                    $(this).val('.datepicker-autoclose_hd').val('');
                }
            })
            $( "#sortable" ).sortable({
                placeholder: "ui-state-highlight",
                update: function () {
                    $('.fz_18').each(function(index) {
                        $(this).text('Tactical Step ' + (index+1));
                    });
                },
            });
            $( "#sortable" ).disableSelection();
        })


        function draft() {
            if (('{{ auth()->user()->m_flag }}') == 1) {
                $id_draft = 6;
            } else if (('{{ auth()->user()->m_flag }}') == 2) {
                $id_draft = 5;
            } else if (('{{ auth()->user()->m_flag }}') == 3) {
                $id_draft = 4;
            } else if (('{{ auth()->user()->m_flag }}') == 4) {
                $id_draft = 2;
            }
            tinyMCE.triggerSave();
            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Confirmation',
                message: 'Are you sure1?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Save</button>',
                        function(instance, toast) {

                            $('.preloader').show();

                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', $id_draft);


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_kpi_save') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'Data saved',
                                        });

                                        $('.preloader').hide();
                                        location.href = '{{ route('assessment_kpi') }}'
                                    } else if (data.status == 'ada') {
                                        iziToast.warning({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Error!',
                                            message: 'Level Sudah Terpakai',
                                        });
                                        $('.preloader').hide();

                                    }
                                },
                                error: function() {
                                    iziToast.error({
                                        icon: 'fa fa-info',
                                        position: 'center',
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


        function save() {
            if (('{{ auth()->user()->m_flag }}') == 1) {
                $id = 1;
            } else if (('{{ auth()->user()->m_flag }}') == 2) {
                $id = 16;
            } else if (('{{ auth()->user()->m_flag }}') == 3) {
                $id = 13;
            } else if (('{{ auth()->user()->m_flag }}') == 4) {
                $id = 10;
            }
            tinyMCE.triggerSave();
            if ($('#k_label').val() == null || $('#k_label').val() == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Key Result Area Required!',
                });
                $('#k_label').focus();
                return false;
            } else if ($('#mymce').val() == null || $('#mymce').val() == '') {
                iziToast.warning({
                    displayMode: 'once',
                    icon: 'fa fa-info',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Goal Required!',
                });

                $('#mymce').focus();
                return false;
            } else if ($('#k_targetdate').val() == null || $('#k_targetdate').val() == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Target date Required!',
                });
                $('#k_targetdate').focus();
                return false;
            }

            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Confirmation',
                message: 'Are you sure3?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Submit</button>',
                        function(instance, toast) {
                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', $id);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_kpi_save') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'KPI has been submitted',
                                        });

                                        location.href = '{{ route('assessment_kpi') }}'
                                    } else if (data.status == 'Validasi') {
                                        iziToast.warning({
                                            icon: 'fa fa-info',
                                            position: 'center',
                                            title: 'Warning!',
                                            message: 'Tactical Step No ' + (data.key + 1) +
                                                ' Empty',
                                        });
                                    } else if (data.status == 'Validasi_date') {
                                        iziToast.warning({
                                            icon: 'fa fa-info',
                                            position: 'center',
                                            title: 'Warning!',
                                            message: 'Due Date No ' + (data.key + 1) +
                                                ' Empty',
                                        });
                                    }
                                },
                                error: function() {
                                    iziToast.error({
                                        icon: 'fa fa-info',
                                        position: 'center',
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

        function cancel() {
            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Confirmation',
                message: 'Are you sure2?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Yes</button>',
                        function(instance, toast) {
                            location.href = '{{ route('assessment_kpi') }}'
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

        $('.btnRemove').on('click', function() {
            var id = $(this).parents('.gg').find('.id').val();
            var parents = $(this).parents('.gg').remove();
            var nilai = 0;
            $('.key_k').each(function(index) {
                var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
                nilai += textBoxVal;
                $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
            });

            $('.drop_here_delete').append('<input type="hidden" value="' + id + '" name="id_remove[]">');
        });

        var key = 1;
        $('.btnAdd').click(function() {
            $('.drop_here').append(
                `
                    <li class="card text-left gg mb-3 ui-state-default bg-white">
                        <input type="hidden" value="1" class="key_k">
                        <div class="card-header" style="font-size: 30px;">
                            <b class="fz_18">Tactical Step ${key}</b><span style="color:red;font-weight:bold"
                                class="important"> *</span>
                            <div class="ms-auto">
                                <div class="dropdown d-inline-block">
                                    <div class="text-right"><input type="button" class="btn btn-danger btnRemove" value="Remove">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <textarea class="form-control rounded-0" rows="3" name="kd_tacticalstep[]" class="kd_tacticalstep"
                                    placeholder="Describe Your Tactical Step"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="input">Measured By<span style="color:red;font-weight:bold" class="important">
                                            *</span></label>
                                    <select class="form-control kd_measure_id" name="kd_measure_id[]"
                                        >
                                        @foreach ($measure as $element)
                                            <option value="{{ $element->dm_id }}">{{ $element->dm_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputZip">Due Date<span style="color:red;font-weight:bold" class="important">
                                            *</span></label>
                                    <input id="kd_duedate_${key}" type="text" name="kd_duedate[]"
                                        data-key="${key}"
                                        class="form-control date_req datepicker-autoclose_dt date_${key}"
                                        placeholder="Format date dd-mmm-yyyy">
                                    <input type="hidden" name="kd_duedate_dt[]"
                                        class="form-control date_req_dt_${key} datepicker-autoclose_dt date_${key}"
                                        placeholder="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Result</label>
                                    <input type="text" name="kd_result_id[]" readonly class="form-control" placeholder="N/A">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputZip">Status</label>
                                    <input type="text" name="kd_status_id[]" readonly class="form-control form-control-danger"
                                        value="N/A" placeholder="">
                                </div>
                            </div>
                        </div>
                    </li>
                `
            );

            var today = new Date();
            var todayString = moment(today).format("YYYY-MM-DD");
            jQuery('.datepicker-autoclose_dt').datepicker({
                format: 'dd-MM-yyyy',
                autoclose: true,
                todayHighlight: true,
                onSelect: function(dateText) {
                    $(this).change();
                }
            });

            $('.btnRemove').on('click', function() {
                var parents = $(this).parents('.gg').remove();
                var nilai = 0;
                $('.key_k').each(function(index) {
                    var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
                    nilai += textBoxVal;
                    $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
                });
            });
            var nilai = 0;
            $('.key_k').each(function(index) {
                var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
                nilai += textBoxVal;
                $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
            });
            key++;
            $('.date_req').on('change', function(argument) {
                var k_targetdates = $('#k_targetdate').val();
                var valdate = $(this).parents('.gg').find('.date_req').val();
                var this_date = moment(valdate, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
                var k_targetdate = moment(k_targetdates, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
                if (k_targetdate == '') {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        displayMode: 'once',
                        position: 'center',
                        title: 'Warning!',
                        message: 'Target Date Empty',
                    });
                    $('#k_targetdate').focus();
                    $(this).parents('.gg').find('.date_req').val('');
                } else if (this_date > k_targetdate) {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        displayMode: 'once',
                        position: 'center',
                        title: 'Warning!',
                        message: 'Due Date more than target date',
                    });
                    $(this).parents('.gg').find('.date_req').val('');
                } else if (this_date < todayString) {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        displayMode: 'once',
                        position: 'center',
                        title: 'Warning!',
                        message: 'Due Date less than Date Now',
                    });
                    $(this).parents('.gg').find('.date_req').val('');
                }
                $(this).parents('.gg').find('.date_req').removeClass('merah');
                $(this).parents('.gg').find('.date_req').addClass('hitam');
            })
        });

        $('.date_req').on('change', function(argument) {
            var k_targetdates = $('#k_targetdate').val();
            var valdate = $(this).parents('.gg').find('.date_req').val();
            var this_date = moment(valdate, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
            var k_targetdate = moment(k_targetdates, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
            if (k_targetdate == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Target Date Empty',
                });
                $('#k_targetdate').focus();
                $(this).parents('.gg').find('.date_req').val('');
            } else if (this_date > k_targetdate) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Due Date more than target date',
                });
                $(this).parents('.gg').find('.date_req').val('');
            } else if (this_date < todayString) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Due Date less than Date Now',
                });
                $(this).parents('.gg').find('.date_req').val('');
            }
            $(this).parents('.gg').find('.date_req').removeClass('merah');
            $(this).parents('.gg').find('.date_req').addClass('hitam');

        })

        $('.date_req_target').on('change', function(argument) {
            var k_targetdates = $('#k_targetdate').val();
            var valdate = $(this).parents('.gg').find('.date_req').val();
            var this_date = moment(valdate, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
            var k_targetdate = moment(k_targetdates, 'DD-MMMM-YYYY').format("YYYY-MM-DD");
            if (k_targetdate == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Target Date Empty',
                });
                $('#k_targetdate').focus();
                $(this).parents('.gg').find('.date_req').val('');
            } else if (k_targetdate > this_date) {
                console.log('ini target date');
                $('.date_req_target').removeClass('merah');
                $('.date_req_target').addClass('hitam');
            }

        })
    </script>
@endpush
