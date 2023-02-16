@extends('master')

@push('title')
    View KPI
@endpush

@push('styles')
    <style>
        input[type=text_dd] {
            background-color: #3CBC8D;
            color: red;
            font-weight: bold;
        }
    </style>
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        @if ($data_edit->k_status_id == 1)
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
                        <b>
                            Status
                        </b>
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
                        <b>
                            Collaboration
                        </b>
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
                                    value="Collaboration With IT Asset dan Helpdes"

                                    @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                        $data_edit->k_collab_assets == null &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="Collaboration With IT Support dan IT Helpdes"

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
                                    value="Collaboration With IT Asset dan IT Suppor"

                                    @elseif ($data_edit->k_collab_helpdesk == null &&
                                        $data_edit->k_collab_assets == null &&
                                        $data_edit->k_collab_support == 'ya')
                                    value="Collaboration With IT Suppor" @endif
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
                        <textarea class="form-control mymce" type="text" name="k_goal" id="mymce" placeholder="Goal (WHAT)">{!! $data_edit->k_goal !!}</textarea>
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
                        {{-- hidden --}}
                        <input type="hidden" name="no_index" value="{{ $index }}">
                        <div class="modal fade comment_modal_{{ $index }}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title ms-auto">Add Comment</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $readonlyComment = $data_edit->k_created_by == auth()->user()->m_id ? '' : 'readonly';
                                        ?>
                                        <textarea class="form-control add_comment_{{ $index }} add_comment_value_{{ $element->kd_id }}" rows="3"
                                            name="add_comment" @if ($element->kd_status_id != 'Completed') @else readonly="" @endif placeholder="Text Here..."
                                            {{ $readonlyComment }}>{{ $element->kd_comment }}</textarea>
                                        <br>
                                        <span style="color:red;font-weight:bold;font-size: 12px" class="important">
                                            *Max 50MB Per file
                                        </span>

                                        @if ($check_total_file[$index] == 0)
                                            <div class="row form-group preview_div">
                                                <div class="col-lg-11">
                                                    <div class="file-upload upl_1">
                                                        <div class="file-select"
                                                            style="pointer-events:none;background-color: lightgrey;">
                                                            <div class="file-select-button fileName">File</div>
                                                            <div class="file-select-name noFile tag_image_1">Choose
                                                                File</div>
                                                            <input type="hidden"
                                                                class="noFile_val file_check_{{ $element->kd_id }} file_checking_0">
                                                            <input type="hidden" name="file_upload_value"
                                                                class="file_upload_value" value="{{ $element->kd_id }}">
                                                            <input type="hidden" name="file_upload_value_index"
                                                                class="file_upload_value_index"
                                                                value="{{ $index }}">
                                                            <input type="file" class="chooseFile" name="file1[]"
                                                                disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 file_plus_{{ $index }}">
                                                    <button type="button" class="btn btn-primary add_file_plus"
                                                        value="{{ $element->kd_id }}" disabled="">
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
                                                                <div class="file-select-name noFile tag_image_1"
                                                                    disabled="">Choose File</div>
                                                                <input type="hidden"
                                                                    class="noFile_val file_check_{{ $element->kd_id }}">
                                                                <input type="hidden" name="file_upload_value"
                                                                    class="file_upload_value"
                                                                    value="{{ $element->kd_id }}">
                                                                <input type="hidden" name="file_upload_value_index"
                                                                    class="file_upload_value_index"
                                                                    value="{{ $index }}">
                                                                <input type="file" class="chooseFile" name="file1[]"
                                                                    disabled="">
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
                                            @endif
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if ($element->kd_status_id != 'Completed')
                                            <button type="button" class="btn btn-success" data-id="{{ $index }}"
                                                disabled="">
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
                                                        <option value="{{ $el->dm_id }}">{
                                                            { $el->dm_name }}
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
                                            <label class="control-label"
                                                style="margin-right: -80px;"><b>Status</b></label>

                                            <select
                                                @if ($element->kd_status_id == 'Completed') name="kd_status_id[]" readonly="" style="pointer-events: none"
                                                    id="status" name="status" class="form-control" @elseif ($data_edit->k_status_id == 1) name="kd_status_id[]" disabled="" id="status"
                                                        onchange="status_update({{ $element->kd_id }})" name="status"
                                                        class="form-control status_{{ $element->kd_id }}" @else name="kd_status_id[]" id="status"
                                                            onchange="status_update({{ $element->kd_id }})"
                                                            name="status" style="pointer-events: none"
                                                            class="form-control status_{{ $element->kd_id }}" @endif>


                                                @if ($element->kd_status_id == 'N/A')
                                                    <option selected="" value="" disabled="disabled">
                                                        <b>N/A</b>
                                                    </option>
                                                    <option value="In Progress"><b>In Progress</b></option>
                                                    <option value="Completed"><b>Complete</b></option>
                                                @elseif($element->kd_status_id == 'Pending')
                                                    <option value="N/A"><b>N/A</b></option>
                                                    <option value="In Progress"><b>In Progress</b></option>
                                                    <option value="Completed"><b>Complete</b></option>
                                                @elseif($element->kd_status_id == 'In Progress')
                                                    <option selected="" hidden><b>In Progress on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                    <option value="N/A"><b>N/A</b></option>
                                                    <option value="In Progress"><b>In Progress on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                    <option value="Completed"><b>Complete</b></option>
                                                @elseif($element->kd_status_id == 'Completed')
                                                    <option value="N/A"><b>N/A</b></option>
                                                    <option value="In Progress"><b>In Progress</b></option>
                                                    <option selected="" value="Completed"><b>Completed on
                                                            {{ date('d-M-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                    </option>
                                                @else
                                                    <option selected="" value="N/A"><b>N/A</b></option>
                                                    <option value="In Progress"><b>In Progress</b></option>
                                                    <option value="Completed"><b>Complete</b></option>
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
                    <h5 class="card-header">Self Assessment</h5>
                    <div class="card-body">
                        <textarea class="form-control assessment_self" rows="3" name="add_comment"
                            @if ($element->kd_status_id != 'Completed') @else readonly="" @endif placeholder="Text Here..." {{ $readonlyComment }}>{{ $data_edit->k_selfassessment }}</textarea>
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
            });
            tinymce.activeEditor.setMode('readonly');
        })

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
                            if (data.file[keying - 1].kd_status_id != 'Completed') {} else {
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
        
        $('.close_button').click(function(){
            $('.comment_modal_'+$(this).data('id')).modal('toggle');
        })
    </script>
@endpush
