@extends('master')

@push('title')
    Add KPI Target
@endpush

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        <button class="btn btn-warning me-2" type="button" onclick="save('save')">
            <i class="ti-save me-1"></i>
            Save
        </button>
        <button class="btn btn-success me-2" type="button" onclick="save('publish')">
            <i class="ti-email me-1"></i>
            Publish
        </button>
        <button class="btn btn-danger me-2" type="button" onclick="cancel()">
            <i class="ti-close me-1"></i>
            Cancel
        </button>
    </div>
@endpush

@section('content')
    <div class="card">
        <form id="save">
            <div class="card-body"><br>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Period</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>
                    <div class="col-10">
                        <select class="form-control form-select year" name="year">
                            <option value="">Select Period</option>
                            @foreach ($year as $element)
                                <option for="year" value="{{ $element->p_year }}">
                                    {{ $element->p_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Title</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title" placeholder="Title"
                            required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label">
                        <b>Details Description</b>
                        <span style="color:red;font-weight:bold" class="important"> *</span>
                    </label>
                    <div class="col-10">
                        <textarea class="form-control mymce" type="text" name="k_goal" id="mymce" placeholder="Goal (WHAT)"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="k_targetdate" class="col-2 col-form-label ">
                        <b>Upload File</b>
                    </label>
                    <div class="col-10">
                        <div class="row form-group preview_div">
                            <div class="col-lg-12">
                                <div class="file-upload upl_1">
                                    <div class="file-select">
                                        <div class="file-select-button fileName">File</div>
                                        <div class="file-select-name noFile tag_image_1">Choose File</div>
                                        <input type="hidden" class="noFile_val file_check">
                                        <input type="hidden" name="file_upload_value" class="file_upload_value"
                                            value="">
                                        <input type="hidden" name="file_upload_value_index" class="file_upload_value_index"
                                            value="">
                                        <input type="file" class="chooseFile" name="file">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.chooseFile').bind('change', function() {
                var filename = $(this).val();
                var fsize = $(this)[0].files[0].size;
                var ftype = $(this)[0].files[0].type;
                if (ftype == "application/pdf" || ftype == "image/jpeg" || ftype == "image/png") {} else {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        message: 'Pdf and image only!',
                        position: 'center',
                        title: 'Warning',
                    });
                    return false;
                }
                if (fsize > 52428800) //do something if file size more than 1 mb (1048576)
                {
                    iziToast.warning({
                        icon: 'fa fa-times',
                        message: 'Pdf Only!',
                        position: 'center',
                        message: 'File is too Large. File must be less than 50 MB!',
                    });
                    return false;
                }
                var parent = $(this).parents(".preview_div");
                if (/^\s*$/.test(filename)) {
                    $(parent).find('.file-upload').removeClass('active');
                    $(parent).find(".noFile").text("No File");
                } else {
                    $(parent).find('.file-upload').addClass('active');
                    var str = filename.replace("C:\\fakepath\\", "");
                    var res = str.substring(0, 30);
                    var rr = str.length;
                    if (rr > 30) {
                        var gg = "...";
                    } else {
                        var gg = "";
                    }
                    $(parent).find(".noFile").text(res + gg);
                    $(parent).find(".noFile_val").val(str);
                }
                load(parent, this);
            });

            function load(parent, file) {
                var fsize = $(file)[0].files[0].size;
                if (fsize > 52428800) //do something if file size more than 1 mb (1048576)
                {
                    iziToast.warning({
                        icon: 'fa fa-times',
                        message: 'Pdf Only!',
                        position: 'center',
                        message: 'File is too Large. File must be less than 50 MB!',
                    });
                    return false;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(parent).find('.output').attr('src', e.target.result);
                };
                reader.readAsDataURL(file.files[0]);
            }
        });


        function save(argument) {
            tinyMCE.triggerSave();
            if ($('.year').val() == null || $('.year').val() == '') {
                iziToast.warning({
                    displayMode: 'once',
                    icon: 'fa fa-info',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Period Required!',
                });
                $('.year').focus();
                return false;
            }
            if ($('#k_title').val() == null || $('#k_title').val() == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    displayMode: 'once',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Title Required!',
                });
                $('#k_title').focus();
                return false;
            }
            if ($('#mymce').val() == null || $('#mymce').val() == '') {
                iziToast.warning({
                    displayMode: 'once',
                    icon: 'fa fa-info',
                    position: 'center',
                    title: 'Warning!',
                    message: 'Details Description Required!',
                });
                $('#mymce').focus();
                return false;
            }

            let id_status;
            if (argument == 'save') {
                id_status = 'save';
            } else {
                id_status = 'publish';
            }

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
                        '<button style="background-color:#17a991;color:white;">Save</button>',
                        function(instance, toast) {
                            $('.preloader').show();
                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', id_status);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_target_save') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: id_status == 'save' ? 'Target KPI Saved!' : 'Target KPI has been Publish',
                                        });
                                        location.href = '{{ route('assessment_target') }}'
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

        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                entity_encoding: "raw",
                apply_source_formatting: false, //added option
                verify_html: false,
                allow_html_in_named_anchor: true,
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

        }

        function cancel() {
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
    </script>
@endpush
