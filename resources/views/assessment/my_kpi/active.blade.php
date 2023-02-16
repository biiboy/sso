@extends('master')

@push('title')
    View KPI
@endpush

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        input[type=text_dd] {
            background-color: #3CBC8D;
            color: red;
            font-weight: bold;
        }

        .red {
            color: red;
            font-weight: bold;
        }
    </style>
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        @if ($data_edit->k_status_id == 1)
            <button class="btn btn-success" type="button" onclick="complete()">
                <i class="ti-check me-1"></i>
                Complete
            </button>
        @elseif ($data_edit->k_status_id == 2 ||
            $data_edit->k_status_id == 4 ||
            $data_edit->k_status_id == 5 ||
            $data_edit->k_status_id == 6)
            <a class="btn btn-md btn-warning" href="{{ route('assessment_kpi_edit', ['id' => $data_edit->k_id]) }}">
                <i class="ti-pencil me-1"></i>
                Edit
            </a>
        @endif
    </div>
@endpush

@section('content')
    <div class="card border">
        <form method="POST" id="save" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                <input type="hidden" name="hidden_id_header" id="hidden_id_header" value="{{ $data_edit->k_id }}">
                <input type="hidden" value="{{ $data_edit->k_collab_assets }}" name="k_collab_assets">
                <input type="hidden" value="{{ $data_edit->k_collab_helpdesk }}" name="k_collab_helpdesk">
                <input type="hidden" value="{{ $data_edit->k_collab_support }}" name="k_collab_support">
                <input type="hidden" value="{{ $data_edit->k_created_by }}" name="k_created_by">

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Status</b>
                    </label>
                    <div class="col-10">
                        @php
                            $value = '';
                            
                            if ($data_edit->k_status_id == 1) {
                                $value = 'Active';
                            } elseif ($data_edit->k_status_id == 2 || $data_edit->k_status_id == 4 || $data_edit->k_status_id == 5 || $data_edit->k_status_id == 6) {
                                $value = 'Draft';
                            } elseif ($data_edit->k_status_id == 3) {
                                $value = 'Final';
                            } elseif ($data_edit->k_status_id == 10) {
                                if (auth()->user()->m_flag == 3) {
                                    $value = 'Waiting for Approval ' . session('coor');
                                } else {
                                    $value = 'Waiting for Approval ' . session('coor');
                                }
                            } elseif ($data_edit->k_status_id == 11) {
                                if (auth()->user()->m_flag == 3) {
                                    $value = 'In review by ' . session('coor');
                                } else {
                                    $value = 'In review by ' . session('coor');
                                }
                            } elseif ($data_edit->k_status_id == 12) {
                                $value = 'Rejected ' . session('coor');
                            } elseif ($data_edit->k_status_id == 13) {
                                if (auth()->user()->m_flag == 2) {
                                    $value = 'Waiting for Approval ' . session('lead');
                                } else {
                                    $value = 'Waiting for Approval ' . session('lead');
                                }
                            } elseif ($data_edit->k_status_id == 14) {
                                if (auth()->user()->m_flag == 2) {
                                    $value = 'In review by ' . session('lead');
                                } else {
                                    $value = 'In review by ' . session('lead');
                                }
                            } elseif ($data_edit->k_status_id == 15) {
                                $value = 'Rejected ' . session('lead');
                            } elseif ($data_edit->k_status_id == 16) {
                                if (auth()->user()->m_flag == 1) {
                                    $value = 'Waiting for Approval ' . session('manager');
                                } else {
                                    $value = 'Waiting for Approval ' . session('manager');
                                }
                            } elseif ($data_edit->k_status_id == 17) {
                                if (auth()->user()->m_flag == 1) {
                                    $value = 'In review by ' . session('manager');
                                } else {
                                    $value = 'In review by ' . session('manager');
                                }
                            } elseif ($data_edit->k_status_id == 18) {
                                $value = 'Rejected ' . session('manager');
                            }
                        @endphp

                        <input class="form-control" type="text" name="k_name" id="k_name"
                            style="pointer-events: none;background: lightgrey" value="{{ $value }}">

                        @if ($data_edit->k_status_id == 3)
                            @if ($element->k_finalresult_text == 'Good')
                                <span class="label label-rounded label-info">Good</span>
                            @elseif($element->k_finalresult_text == 'Need Improvement')
                                <span class="label label-rounded label-warning">Need Improvement</span>
                            @elseif($element->k_finalresult_text == 'Outstanding')
                                <span class="label label-rounded label-success">Outstanding</span>
                            @elseif($element->k_finalresult_text == 'Unacceptable')
                                <span class="label label-rounded label-danger">Unacceptable</span>
                            @elseif($element->k_finalresult_text == 'N/A')
                                <span class="label label-rounded label-info"
                                    style="background-color: #999 !important">N/A</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Collaboration</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" style="pointer-events: none;background: lightgrey"
                            placeholder="Key Result Area"
                            @if ($data_edit->k_collab_helpdesk == 'ya' &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == null) value="Collab With IT Helpdesk"

                                    @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                        $data_edit->k_collab_assets == 'ya' &&
                                        $data_edit->k_collab_support == null)
                                    value="Collaboration With IT Asset dan Helpdesk"

                                    @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                        $data_edit->k_collab_assets == null &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="Collaboration With IT Support dan IT Helpdesk"

                                    @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                        $data_edit->k_collab_assets == 'ya' &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="All IT Service" @endif
                            {{-- Collab sama IT ASset --}}
                            @if ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == 'ya' &&
                                $data_edit->k_collab_support == null) value="Collab With IT Asset"

                                    @elseif ($data_edit->k_collab_helpdesk == null &&
                                        $data_edit->k_collab_assets == 'ya' &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="Collaboration With IT Asset dan IT Support"

                                    @elseif ($data_edit->k_collab_helpdesk == null &&
                                        $data_edit->k_collab_assets == null &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="Collaboration With IT Support" @endif
                            @if ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == null) value="-" @endif>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">
                        Key Result Area
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" name="k_label" id="k_label" value="{{ $data_edit->k_label }}"
                            style="pointer-events:none;background-color: lightgrey;">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">
                        Goal
                    </label>
                    <div class="col-sm-10">
                        <textarea class="form-control mymce" id="mymce" name="k_goal">{!! $data_edit->k_goal !!}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label font-weight-bold">
                        Target Date
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" name="k_targetdate" id="k_targetdate"
                            value="{{ date('d-M-Y', strtotime($data_edit->k_targetdate)) }}"
                            style="pointer-events:none;background-color: lightgrey;">
                    </div>
                </div>

                <div class="drop_here">
                    @foreach ($data as $index => $element)
                        <input type="hidden" name="no_index" value="{{ $index }}">
                        <div class="modal fade comment_modal_{{ $index }}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header px-4">
                                        <h4 class="modal-title ms-auto">Add Comment</h4>
                                    </div>
                                    <div class="modal-body">
                                        <textarea class="form-control add_comment_{{ $index }} add_comment_value_{{ $element->kd_id }}" rows="3"
                                            name="add_comment" @if ($element->kd_status_id != 'Completed') @else readonly="" @endif placeholder="Text Here..."
                                            {{ $data_edit->k_created_by == Auth::user()->m_id ? '' : 'readonly' }}>{{ $element->kd_comment }}</textarea>
                                        <br>
                                        <span style="color:red;font-weight:bold;font-size: 12px" class="important">
                                            *Max 50MB Per file
                                        </span>

                                        @if ($check_total_file[$index] == 0)
                                            <div class="row form-group preview_div">
                                                <div class="col-lg-11">
                                                    <div class="file-upload upl_1">
                                                        <div class="file-select">
                                                            <div class="file-select-button fileName">File</div>
                                                            <div class="file-select-name noFile tag_image_1">Choose File
                                                            </div>
                                                            <input type="hidden"
                                                                class="noFile_val file_check_{{ $element->kd_id }} file_checking_0">
                                                            <input type="hidden" name="file_upload_value"
                                                                class="file_upload_value" value="{{ $element->kd_id }}">
                                                            <input type="hidden" name="file_upload_value_index"
                                                                class="file_upload_value_index"
                                                                value="{{ $index }}">
                                                            <input type="file" class="chooseFile" name="file1[]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 file_plus_{{ $index }}">
                                                    <button type="button" class="btn btn-primary add_file_plus"
                                                        value="{{ $element->kd_id }}">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="drop_here_add_file_plus"></div>
                                        @else
                                            <div class="drop_show_file">
                                            </div>
                                            @if ($element->kd_status_id != 'Completed')
                                                <div class="row form-group preview_div">
                                                    <div class="col-lg-11">
                                                        <div class="file-upload upl_1">
                                                            <div class="file-select">
                                                                <div class="file-select-button fileName">File</div>
                                                                <div class="file-select-name noFile tag_image_1">Choose
                                                                    File</div>
                                                                <input type="hidden"
                                                                    class="noFile_val file_check_{{ $element->kd_id }}">
                                                                <input type="hidden" name="file_upload_value"
                                                                    class="file_upload_value"
                                                                    value="{{ $element->kd_id }}">
                                                                <input type="hidden" name="file_upload_value_index"
                                                                    class="file_upload_value_index"
                                                                    value="{{ $index }}">
                                                                <input type="file" class="chooseFile" name="file1[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 file_plus_{{ $index }}">
                                                        <button type="button" class="btn btn-primary add_file_plus"
                                                            value="{{ $element->kd_id }}">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="drop_here_add_file_plus"></div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if ($element->kd_status_id != 'Completed')
                                            <button type="button" class="btn btn-success"
                                                onclick="save_proof_doc({{ $index }},{{ $element->kd_id }})"
                                                data-id="{{ $index }}">
                                                <i class="ti-save me-1"></i>
                                                Save
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-danger close_button"
                                            data-id="{{ $index }}">
                                            <i class="ti-close me-1"></i>
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="id_old" name="id_old[]" value="{{ $element->kd_id }}">
                        <div class="card mb-3">
                            <div class="card-header" style="font-size: 30px;">
                                <b>Tactical Step {{ $index + 1 }}</b>
                                <div class="cc ms-auto">
                                    @if ($check_total_file[$index] == 0)
                                        @if ($data_edit->k_status_id == 1)
                                            <button type="button" class="btn btn-primary comment_modal_btn"
                                                data-bs-toggle="modal"
                                                data-bs-target=".comment_modal_{{ $index }}"
                                                style="float: right;">
                                                Proof Documents
                                            </button>
                                        @endif
                                    @else
                                        <button type="button"
                                            class="btn btn-warning btn_show data_idheader_{{ $element->kd_id }}"
                                            data-id="{{ $index }}" data-idheader="{{ $data_edit->k_id }}"
                                            data-iddetail="{{ $element->kd_id }}" style="float: right;">
                                            <i class="ti-file me-1"></i>
                                            View Documents
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="kd_tacticalstep[]" rows="3" style="background: lightgrey"
                                        readonly="">{{ $element->kd_tacticalstep }}</textarea>
                                </div>

                                <form>
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="control-label">
                                                <b>Measured By</b>
                                            </label>
                                            <select class="form-control" disabled="" name="kd_measure_id[]">
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
                                        <div class="col-3">
                                            <label class="control-label">
                                                <b>Due Date</b>
                                            </label>
                                            @if (date('Y-m-d') == date('Y-m-d', strtotime('-7 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-6 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-5 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-4 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-3 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-2 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('-1 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @elseif (date('Y-m-d') == date('Y-m-d', strtotime('0 days', strtotime($element->kd_duedate))) &&
                                                $element->kd_status_id != 'Completed')
                                                <input type="text_dd" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @else
                                                <input type="text" name="kd_duedate[]" disabled=""
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @endif
                                        </div>

                                        <div class="col-2">
                                            <label class="control-label">
                                                <b>Result</b>
                                            </label>
                                            <input type="text" name="kd_result_id[]" disabled="" readonly=""
                                                value="N/A" class="result form-control" placeholder="Result">
                                        </div>
                                        <div class="col-4">
                                            <label class="control-label" style="margin-right: -80px;">
                                                <b>Status</b>
                                            </label>

                                            <select name="kd_status_id[]"
                                                @if ($element->kd_status_id == 'Completed') readonly="" class="form-control"
                                                            style="pointer-events: none" @elseif ($data_edit->k_status_id == 1) onchange="status_update({{ $element->kd_id }})" disable="disable" class="form-control red status_{{ $element->kd_id }}" @else onchange="status_update({{ $element->kd_id }})" readonly="" style="pointer-events: none" disable="disable"
                                                                        class="form-control status_{{ $element->kd_id }}" @endif
                                                id="status" name="status">
                                                @if ($element->kd_status_id == 'N/A')
                                                    <option selected="" value="" disabled="disabled">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress">
                                                        <b>In Progress</b>
                                                    </option>
                                                    <option value="Completed">
                                                        <b>Complete</b>
                                                    </option>
                                                @elseif($element->kd_status_id == 'Pending')
                                                    <option value="N/A">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress">
                                                        <b>In Progress</b>
                                                    </option>
                                                    <option value="Completed">
                                                        <b>Complete</b>
                                                    </option>
                                                @elseif($element->kd_status_id == 'In Progress')
                                                    <option selected="" hidden>
                                                        <b>In Progress on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                    <option value="N/A">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress">
                                                        <b>In Progress on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                    <option value="Completed">
                                                        <b>Complete</b>
                                                    </option>
                                                @elseif($element->kd_status_id == 'Completed')
                                                    <option value="N/A">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress">
                                                        <b>In Progress</b>
                                                    </option>
                                                    <option selected="" value="Completed">
                                                        <b>Completed on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                @else
                                                    <option selected="" value="N/A">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress">
                                                        <b>In Progress</b>
                                                    </option>
                                                    <option value="Completed">
                                                        <b>Complete</b>
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card">
                    <h5 class="card-header">
                        Self Assessment
                        <span style="color:red;font-weight:bold"class="important">
                            *
                        </span>
                    </h5>
                    <div class="card-body">
                        <textarea class="form-control assessment_self" name="assessment_self" rows="3" placeholder="Text Here">{{ $data_edit->k_selfassessment }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            tinymce.init({
                selector: 'textarea#mymce',
                height: 150,
                toolbar: 'mybutton',
                menubar: false,
                readonly: 1,
                content_css: [
                    'https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.1.6/skins/content/default/content.min.css'
                ],
            });
            tinymce.activeEditor.setMode('readonly');
        })

        function complete() {
            tinyMCE.triggerSave();

            if (('{{ auth()->user()->m_flag }}') == 1) {
                $id = 1;
            } else if (('{{ auth()->user()->m_flag }}') == 2) {
                $id = 16;
            } else if (('{{ auth()->user()->m_flag }}') == 3) {
                $id = 13;
            } else if (('{{ auth()->user()->m_flag }}') == 4) {
                $id = 10;
            }

            if ($('.assessment_self').val() == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    title: 'Error!',
                    message: 'Self Assessment Is Empty',
                });
                $('.assessment_self').focus();
                return false;
            }

            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Confirmation',
                message: 'Make sure all Tactical Steps have been completed. Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Submit</button>',
                        function(instance, toast) {
                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', $id);
                            formdata.append('hidden_id_header', $('#hidden_id_header').val());
                            formdata.append('k_selfassessment', $('.assessment_self').val());

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_kpi_complete_on_show') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'KPI has been Completed',
                                        });

                                        location.href = '{{ route('assessment_kpi') }}';
                                    } else if (data.status == 'ada') {
                                        iziToast.warning({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Error!',
                                            message: 'Level Sudah Terpakai',
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

        function save_proof_doc(argument, val) {
            var form = $('#save');
            formdata = new FormData(form[0]);
            formdata.append('kd_id', val);
            formdata.append('kd_comment', $('.add_comment_value_' + val).val());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{ route('assessment_all_approval_save_proof_doc') }}',
                data: formdata ? formdata : form.serialize(),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        iziToast.success({
                            icon: 'fa fa-save',
                            position: 'center',
                            title: 'Success!',
                        });
                        location.reload();
                    }
                }
            });
        }

        function delete_files(argument) {
            iziToast.show({
                overlay: true,
                close: false,
                timeout: false,
                color: 'dark',
                icon: 'fas fa-question-circle',
                title: 'Delete!',
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Yes</button>',
                        function(instance, toast) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "get",
                                url: ('{{ route('assessment_kpi_deleting_file') }}'),
                                data: '&filename=' + argument,
                                processData: false,
                                async: false,
                                contentType: false,

                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        $(".value_to_remove_" + data.idd).remove();
                                        location.reload();
                                        iziToast.hide({
                                            transitionOut: 'fadeOutUp'
                                        }, toast);
                                    }
                                },
                                error: function() {
                                    iziToast.error({
                                        icon: 'fa fa-info',
                                        position: 'topRight',
                                        title: 'Error!',
                                        message: 'Unable to delete',
                                    });
                                }
                            });
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

        $('.cc .btn_show').click(function() {
            var keying = 1;
            $.ajax({
                url: baseUrl + '/assessment/assessment_kpi/show_file',
                data: '&id=' + $(this).data('id') + '&idheader=' + $(this).data('idheader') + '&iddetail=' +
                    $(this).data('iddetail'),
                type: 'get',
                success: function(data) {
                    $('.drop_show_file').empty();
                    if (data.status == 'sukses') {
                        Object.keys(data.file).forEach(function() {
                            var formattedDate = new Date(data.file[keying - 1].kpf_updated_at);
                            var d = ('0' + formattedDate.getDate()).slice(-2);
                            var MM = formattedDate.getMonth();
                            MM += 01; // JavaScript months are 0-11
                            var F = '';
                            if (MM == 1) {
                                F = 'Jan';
                            } else if (MM == 2) {
                                F = 'Feb';
                            } else if (MM == 3) {
                                F = 'Mar';
                            } else if (MM == 4) {
                                F = 'Apr';
                            } else if (MM == 5) {
                                F = 'May';
                            } else if (MM == 6) {
                                F = 'Jun';
                            } else if (MM == 7) {
                                F = 'Jul';
                            } else if (MM == 8) {
                                F = 'Aug';
                            } else if (MM == 9) {
                                F = 'Sep';
                            } else if (MM == 10) {
                                F = 'Oct';
                            } else if (MM == 11) {
                                F = 'Nov';
                            } else if (MM == 12) {
                                F = 'Dec';
                            }
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var i = formattedDate.getMinutes();
                            if (H < 10) {
                                H = '0' + H;
                            } else {
                                H = H;
                            }
                            if (data.file[keying - 1].kd_status_id != 'Completed') {
                                // var style = 'display:block';
                            } else {
                                var style = 'display:none';
                            }
                            $('.drop_show_file').append(
                                `
                                <div class="form-group preview_div remove_show_file text-right value_1 value_to_remove_${data.file[keying - 1].kpf_id}">
                                    <div class="form-group preview_div">
                                        <div class="file-upload upl_1" style="width: 100%;">
                                            <div class="file-select">
                                                <div class="file-select-button fileName" >File</div>
                                                <input type="hidden" value="${data.file[keying - 1].kpf_file}"
                                                    class="noFile_val file_check_${data.file[keying - 1].kpf_ref_id} file_checking_${data.file[keying - 1].kpf_ref_iddt}_0">
                                                    <div class="file-select-name noFile tag_image_1" value="">${data.file[keying-1].kpf_file.substr(0, 35)} ...</div>
                                                <input type="file" class="chooseFile" value="" disabled
                                                    name="file1[]">
                                            </div>
                                        </div>
                                    </div>
                                    <small> Updated Date : ${(d + "-" + F + "-" + y + " " + H + ":" + i)}</small>
                                    <div class="w-full text-end mb-3">
                                        <button style="margin:5px; ${style}" type="button"
                                            onclick="delete_files('${data.file[keying - 1].kpf_file}')" class="btn btn-danger ms-auto"><i
                                                class="ti-close me-1"></i> Delete</button>
                                        <a href="${baseUrl}/storage/${data.file[keying - 1].kpf_file.replace('public/','')}" target="_blank"
                                            class="btn btn-warning ms-auto"><i class="ti-file me-1"></i> View Documents</a>
                                    </div>
                                </div>
                                `);
                            keying++;
                        });
                    }
                },
                error: function(data) {}
            })
            $('.comment_modal_' + $(this).data('id')).modal('show');
        })


        $('.close_button').click(function() {
            $('.comment_modal_' + $(this).data('id')).modal('toggle');
        })

        $('.add_file_plus').click(function() {
            $('.drop_here_add_file_plus').append(`
            <div class="parents_add_file my-3">
                <div class="row form-group preview_div">
                    <div class="col-lg-11">
                        <div class="file-upload upl_1">
                            <div class="file-select">
                                <div class="file-select-button fileName">File</div>
                                <div class="file-select-name noFile tag_image_1">Choose File</div>
                                <input type="hidden" class="noFile_val">
                                <input type="file" class="chooseFile" name="file1[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-danger remove_file_plus"><i class="ti-minus"></i></button>
                    </div>
                </div>
            </div>

            `);
            $('.remove_file_plus').on('click', function() {
                var parents = $(this).parents('.parents_add_file').remove();
            });
            $('.chooseFile').bind('change', function() {
                var filename = $(this).val();
                var fsize = $(this)[0].files[0].size;
                var ftype = $(this)[0].files[0].type;
                // console.log(fsize);
                // console.log(ftype);
                if (ftype != "application/pdf") {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        message: 'Pdf Only!',
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
                    $(parent).find(".noFile").text("No file choosen...");
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
                    $(parent).find(".file-select").append('<i class="ti-check"></i>');
                    $(parent).find(".noFile_val").val(str);
                }
                load(parent, this);
            });
        })

        $('.chooseFile').bind('change', function() {
            var filename = $(this).val();
            var fsize = $(this)[0].files[0].size;
            var ftype = $(this)[0].files[0].type;
            if (ftype != "application/pdf") {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Pdf Only!',
                    position: 'center',
                    title: 'Warning',
                });
                return false;
            }

            if (fsize > 104857600) //do something if file size more than 1 mb (1048576)
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
                $(parent).find(".noFile").text("No file chosen...");
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
                $(parent).find(".file-select").append('<i class="ti-check"></i>');
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

        function status_update(argument) {
            var commentt = $('.add_comment_value_' + argument).val();

            // alert(commentt);
            if ($('.status_' + argument).val() == 'Completed') {
                // alert($('.file_checking_0').val());
                // alert($('.file_checking_'+argument+'_0').val());
                // alert(argument);
                //     if ($('.file_checking_'+argument+'_0').val() != '') {
                //         alert('tdk koson');
                //    }else{
                //         iziToast.warning({
                //                 icon: 'fa fa-info',
                //                 position:'center',
                //                 title: 'Error!',
                //                 message:'Upload your Proof Documents',
                //             });
                //            $('.status_'+argument).val('N/A');
                //            console.log($('.file_check_'+argument).val());
                //            return false;

                //         if ($('.file_checking_0').val() == '') {
                //            iziToast.warning({
                //                 icon: 'fa fa-info',
                //                 position:'center',
                //                 title: 'Error!',
                //                 message:'Upload your Proof Documents',
                //             });
                //            $('.status_'+argument).val('N/A');
                //            console.log($('.file_check_'+argument).val());
                //            return false;
                //        }
                //    }

                $.ajax({
                    type: "get",
                    url: '{{ route('assessment_kpi_checking_file') }}',
                    data: '&id=' + argument,
                    success: function(data) {

                        total_data = data.total_data;

                        if (total_data == 0) {
                            iziToast.warning({
                                icon: 'fa fa-info',
                                position: 'center',
                                title: 'Error!',
                                message: 'Upload your Proof Documents',
                            });
                            $('.status_' + argument).val('N/A');
                            return false;
                        } else {

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
                                            formdata.append('k_status', 'Completed');
                                            formdata.append('kd_id', argument);
                                            formdata.append('kd_comment', commentt);

                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $(
                                                        'meta[name="csrf-token"]').attr(
                                                        'content')
                                                }
                                            });

                                            $.ajax({
                                                type: "post",
                                                url: '{{ route('assessment_all_approval_update_status_to_complete') }}',
                                                data: formdata ? formdata : form
                                                .serialize(),
                                                processData: false,
                                                contentType: false,
                                                success: function(data) {
                                                    if (data.status == 'sukses') {
                                                        iziToast.success({
                                                            icon: 'fa fa-save',
                                                            position: 'center',
                                                            title: 'Success!',
                                                            message: 'Saved!',
                                                        });
                                                        $('.status_' + argument).attr(
                                                            'disabled', 'disabled');
                                                        location.reload();
                                                        {{-- location.href = '{{ route('assessment_all_approval') }}' --}}
                                                    } else if (data.status == 'ada') {
                                                        iziToast.warning({
                                                            icon: 'fa fa-save',
                                                            position: 'center',
                                                            title: 'Error!',
                                                            message: 'Level Sudah Terpakai',
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

                    },
                    error: function() {
                        iziToast.error({
                            icon: 'fa fa-info',
                            position: 'topRight',
                            title: 'Error!',
                            message: 'Call Admin To resolve!',
                        });
                    }
                });



            } else {
                var ars = $('.status_' + argument).val();

                $('.preloader').show();
                var form = $('#save');
                formdata = new FormData(form[0]);
                formdata.append('k_status', ars);
                formdata.append('kd_id', argument);
                formdata.append('kd_comment', commentt);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: '{{ route('assessment_all_approval_update_status_to_complete') }}',
                    // data: '&k_status='+ars+'&kd_id='+argument,
                    data: formdata ? formdata : form.serialize(),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.status == 'sukses') {
                            iziToast.success({
                                icon: 'fa fa-save',
                                position: 'center',
                                title: 'Success!',
                                message: 'Saved',
                            });
                            location.reload();
                        } else if (data.status == 'ada') {
                            iziToast.warning({
                                icon: 'fa fa-save',
                                position: 'center',
                                title: 'Error!',
                                message: 'Level Sudah Terpakai',
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
            }
        }
        
    </script>
@endpush
