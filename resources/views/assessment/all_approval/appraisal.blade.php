@extends('master')

@push('title')
    View KPI
@endpush

@push('styles')
    <style>
        .card-deck {
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            -ms-flex-flow: row wrap;
            display: flex;
            flex-flow: row wrap;
            margin-bottom: 15px;
            margin-right: -15px;
            margin-left: -15px;
        }

        .card-deck .card {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-flex: 1;
            -ms-flex: 1 0 0%;
            flex: 1 0 0%;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            margin-right: 15px;
            margin-bottom: 0;
            margin-left: 15px;
        }

        .red {
            color: red;
            font-weight: bold;
        }

        textarea.drop_here_text:read-only {
            color: white;
            text-align: center;
            font-size: 30px;
            height: 76px;
        }

        textarea.merah:read-only {
            background-color: #dc3545;
        }

        textarea.kuning:read-only {
            background-color: #FFC107;
        }

        textarea.biru:read-only {
            background-color: #007bff;
        }

        textarea.hijau:read-only {
            background-color: #28A745;

        }

        textarea.abu:read-only {
            background-color: #6C757D;
        }
    </style>
@endpush

@push('top-buttons')
    @if (auth()->user()->m_flag != 4)
        <div class="d-flex justify-content-end">
            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                <button class="btn btn-success save_appreisal me-1" type="button"><i class="ti-check me-1"> </i>
                    Complete</button>
            @endif
            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                <button class="btn btn-success save_appreisal me-1" type="button"><i class="ti-check me-1"> </i>
                    Complete</button>
            @endif
            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                <button class="btn btn-success save_appreisal me-1" type="button"><i class="ti-check me-1"> </i>
                    Complete</button>
            @endif
        </div>
    @endif
@endpush

@section('content')
    <div class="card">
        <form method="POST" id="save" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                <br>
                <input type="hidden" name="hidden_id_header" value="{{ $data->k_id }}">
                <input type="hidden" value="{{ $data->k_collab_assets }}" name="k_collab_assets">
                <input type="hidden" value="{{ $data->k_collab_helpdesk }}" name="k_collab_helpdesk">
                <input type="hidden" value="{{ $data->k_collab_support }}" name="k_collab_support">
                <input type="hidden" value="{{ $data->k_created_by }}" name="k_created_by">
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label"><b>Submitted By</b></label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_name" id="k_name" readonly=""
                            value="{{ $data->m_name }}" placeholder="Submitted By">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label"><b>Collaboration</b></label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_label" id="k_label"
                            style="pointer-events: none;background: lightgrey" placeholder="Key Result Area"
                            @if ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == null) value="IT Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == 'ya' && $data->k_collab_support == null)
                            value="IT Asset dan Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == 'ya')
                            value="IT Support dan IT Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == 'ya' && $data->k_collab_support == 'ya')
                            value="All IT Services" @endif
                            {{-- Collab sama IT ASset --}}
                            @if ($data->k_collab_helpdesk == null && $data->k_collab_assets == 'ya' && $data->k_collab_support == null) value="IT Asset"

                            @elseif ($data->k_collab_helpdesk == null && $data->k_collab_assets == 'ya' && $data->k_collab_support == 'ya')
                            value="IT Asset dan IT Support"

                            @elseif ($data->k_collab_helpdesk == null && $data->k_collab_assets == null && $data->k_collab_support == 'ya')
                            value="IT Support" @endif
                            @if ($data->k_collab_helpdesk == null && $data->k_collab_assets == null && $data->k_collab_support == null) value="-" @endif>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label"><b>Key Result Area</b></label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_label" id="k_label" readonly=""
                            value="{{ $data->k_label }}" placeholder="Key Result Area">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label"><b>Goal</b></label>
                    <div class="col-10">
                        <textarea class="form-control k_goal" rows="3" id="mymce" name="k_goal" placeholder="Text Here...">{!! $data->k_goal !!}</textarea>

                    </div>
                </div>


                <div class="form-group row mb-3">
                    <label for="k_targetdate" class="col-2 col-form-label"><b>Target Date</b></label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_targetdate" id="k_targetdate" readonly=""
                            value="{{ date('d-M-Y', strtotime($data->k_targetdate)) }}" placeholder="Target Date">

                    </div>
                </div>

                <br>
                <div class="drop_here">
                    @foreach ($datad as $index => $element)
                        <div class="card gg mb-3">
                            <div class="card-header" style="font-size: 30px;">
                                <b>Tactical Step {{ $index + 1 }}</b>
                                <div class="ms-auto">
                                    <div class="dropdown d-inline-block cc">
                                        <button type="button" class="btn btn-warning btn_show"
                                            data-id="{{ $index }}" data-idheader="{{ $data->k_id }}"
                                            data-iddetail="{{ $element->kd_id }}"><i class="ti-file me-1"></i> View
                                            Documents</button>
                                        @if (auth()->user()->m_flag != 4)
                                            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                                <button type="button" class="text-end btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".value_modal_{{ $index }}" required=""><i
                                                        class="ti-eye me-1"></i> View
                                                    Value</button>
                                            @endif

                                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                                <button type="button" class="text-end btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".value_modal_{{ $index }}" required=""><i
                                                        class="ti-eye me-1"></i> View
                                                    Value</button>
                                            @endif

                                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                                <button type="button" class="text-end btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".value_modal_{{ $index }}" required=""><i
                                                        class="ti-eye me-1"></i> View
                                                    Value</button>
                                            @endif
                                        @endif
                                        @if ($data->k_status_id == 3)
                                            @if ($element->kd_value == null || $element->kd_value == '')
                                            @else
                                                <button type="button" class="text-end btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".value_modal_{{ $index }}" required=""><i
                                                        class="ti-eye me-1"></i> View
                                                    Value</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>
                                </div>
                                <input type="hidden" class="id_old" name="id_old[]" value="{{ $element->kd_id }}">
                                <input type="hidden" class="hit" value="0">
                                <input type="hidden" class="hit2" value="0">
                                <input type="hidden" class="hit3" value="0">
                                <input type="hidden" class="comment_hidden">
                                <input type="hidden" class="value_hidden">
                            </div>

                            <div class="modal fade comment_modal_{{ $index }}" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title ms-auto">Add Comment</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            $readonlyComment = $data->k_created_by == auth()->user()->k_id ? '' : 'readonly';
                                            ?>
                                            <textarea class="form-control add_comment_{{ $index }} add_comment_{{ $element->kd_id }}" rows="3"
                                                name="add_comment[]" placeholder="Text Here..." {{ $readonlyComment }}>{{ $element->kd_comment }}</textarea>
                                            <br>
                                            <div class="drop_show_file"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- modal value --}}
                            <div class="modal fade value_modal_{{ $index }}" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title ms-auto">Value Added</h4>
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="form-control add_value" @if ($data->k_status_id == 3) readonly="" @endif rows="3"
                                                name="add_value[]" placeholder="Text Here...">{{ $element->kd_value }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            @if ($data->k_status_id == 3)
                                            @else
                                                <button class="btn btn-default mr_value" type="button"value="1"
                                                    data-value="1" data-bs-dismiss="modal"><i class="ti-plus me-1"></i>
                                                    Add</button>
                                                <button type="button" class="btn btn-warning mr_value_dec"
                                                    value="0" data-value="0" data-bs-dismiss="modal"><i
                                                        class="ti-trash me-1"></i>
                                                    Remove</button>
                                            @endif

                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                                    class="ti-close me-1"></i>
                                                Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table" width="100%">
                                <tr>
                                    <th width="100%">
                                        <?php
                                        $style_bg_color = $element->flag_ts_checked == 1 ? '#28a745' : ($element->flag_ts_checked == 2 ? '#dc3545' : '');
                                        ?>
                                        <input type="hidden" name="flag_ts_checked[]"
                                            value="{{ $element->flag_ts_checked }}" />
                                        <b>
                                            <textarea style="background-color: {{ $style_bg_color }}" class="form-control" rows="5" readonly=""
                                                name="kd_tacticalstep[]" placeholder="Text Here...">{{ $element->kd_tacticalstep }}</textarea>
                                        </b>
                                    </th>
                                    <th>
                                        @if (auth()->user()->m_flag != 4)
                                            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                                <button type="button" class="btn btn-success btn-xm ts_good"
                                                    value="1.5"><i class="ti-check"></i></button><br><br><br>

                                                <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                    value="0.5"><i class="ti-close"></i></button>
                                            @endif
                                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                                <button type="button" class="btn btn-success btn-xm ts_good"
                                                    value="1.5"><i class="ti-check"></i></button><br><br><br>

                                                <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                    value="0.5"><i class="ti-close"></i></button>
                                            @endif
                                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                                <div class="dropdown d-inline-block cc">
                                                    <button type="button" class="btn btn-success btn-xm ts_good"
                                                        value="1.5"><i class="ti-check"></i></button><br><br><br>

                                                    <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                        value="0.5"><i class="ti-close"></i></button>
                                                </div>
                                            @endif
                                        @endif
                                    </th>
                                </tr>
                            </table>


                            <div class="card-body row col-sm-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"><b>Measured By</b></label>
                                        <select class="form-control" name="kd_measure_id[]" disabled="">
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
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"><b>Due Date</b></label>
                                        <?php
                                        $style_due_bg_color = $element->flag_due_date_checked == 1 ? '#28a745' : ($element->flag_due_date_checked == 2 ? '#dc3545' : '');
                                        ?>
                                        <input type="hidden" name="flag_due_date_checked[]"
                                            value="{{ $element->flag_due_date_checked }}" />
                                        <input type="text" name="kd_duedate[]" readonly=""
                                            value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}" id="firstName"
                                            class="form-control" style="background-color: {{ $style_due_bg_color }}">
                                        @if (auth()->user()->m_flag != 4)
                                            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                                <div class="text-end"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close"></i></button>
                                                </div>
                                            @endif
                                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                                <div class="text-end"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close"></i></button>
                                                </div>
                                            @endif
                                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                                <div class="text-end"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close"></i></button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>Result</b></label>
                                        <input type="text" name="kd_result_id[]" readonly=""
                                            value="{{ $element->kd_result_id }}" class="result form-control"
                                            placeholder="0">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group has-danger">
                                        <label class="control-label"><b>Status</b></label>
                                        <select
                                            @if ($element->kd_status_id == 'Completed') name="kd_status_id[]" readonly="" style="pointer-events: none"
                                        id="status" name="status" class="form-control" @else name="kd_status_id[]" readonly="" style="pointer-events: none"
                                                id="status" onchange="status_update({{ $element->kd_id }})"
                                                name="status" class="form-control red status_{{ $element->kd_id }}" @endif>
                                            @if ($element->kd_status_id == 'N/A')
                                                <option selected="" value="N/A"><b>N/A</b></option>
                                                <option value="In Progress"><b>In Progress</b></option>
                                                <option value="Completed"><b>Complete</b></option>
                                            @elseif($element->kd_status_id == 'In Progress')
                                                <option selected="" value="In Progress"><b>In Progress on
                                                        {{ date('d-m-Y H:i A', strtotime($element->kd_completed_date)) }}</b>
                                                </option>
                                            @elseif($element->kd_status_id == 'Completed')
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
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card mb-3">
                    <h5
                        @if ($data->k_selfassessment != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                        Self Assessment
                    </h5>
                    <div class="card-body">
                        <textarea class="form-control assessment_self" name="assessment_self" rows="3" readonly="">{{ $data->k_selfassessment }}</textarea>
                    </div>
                    <div class="card-footer" style="background: lightgrey">
                        <small class="text-muted">
                            @if ($data->k_completed_spec == null)
                                Completed Date: -
                            @else
                                Completed Date:
                                {{ date('d-M-Y H:i A', strtotime($data->k_completed_spec)) }}
                            @endif
                        </small>
                    </div>
                </div>


                {{-- Start Submitter adalah Leader --}}
                @if ($data->k_created_by == 26 || $data->k_created_by == 27)
                    <div class="card">
                        <div
                            @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                            Manager Assessment

                            @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                <span style="color:red;font-weight:bold" class="important"> *</span>
                            @endif
                        </div>

                        <div class="card-body">
                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                            @else
                                <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                            @endif

                        </div>

                        <div class="card-footer" style="background: lightgrey">
                            <small class="text-muted">
                                @if ($data->k_completed_manager != null)
                                    Completed Date:
                                    {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                @else
                                    Completed Date: -
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="card">
                        <div
                            @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                            Manager Supplement

                        </div>

                        <div class="card-body">
                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                            @else
                                <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                            @endif
                        </div>

                        <div class="card-footer" style="background: lightgrey">
                            <small class="text-muted">
                                @if ($data->k_completed_manager != null)
                                    Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                @else
                                    Completed Date: -
                                @endif
                            </small>
                        </div>
                    </div>
                @endif
                {{-- End Submitter Leader --}}

                {{-- Start Submitter IT Support Specialist --}}
                @if ($data->k_created_by == 29 ||
                    $data->k_created_by == 30 ||
                    $data->k_created_by == 31 ||
                    $data->k_created_by == 32 ||
                    $data->k_created_by == 35 ||
                    $data->k_created_by == 36 ||
                    $data->k_created_by == 37 ||
                    $data->k_created_by == 40 ||
                    $data->k_created_by == 41 ||
                    $data->k_created_by == 42 ||
                    $data->k_created_by == 57 ||
                    $data->k_created_by == 58 ||
                    $data->k_created_by == 59 ||
                    $data->k_created_by == 60 ||
                    $data->k_created_by == 61 ||
                    $data->k_created_by == 62 ||
                    $data->k_created_by == 63 ||
                    $data->k_created_by == 64 ||
                    $data->k_created_by == 65 ||
                    $data->k_created_by == 54 ||
                    $data->k_created_by == 55)
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_assessment != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Coordinator Assessment

                                @if ($data->k_assessment == null && auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3">{{ $data->k_assessment }}</textarea>
                                @else
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3" readonly="">{{ $data->k_assessment }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_coor != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_coor)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="card">

                            <div
                                @if ($data->k_assessment_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Assessment

                                @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">

                                @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3" readonly="">{{ $data->k_assessment_lead }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Assessment

                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif

                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_supplement != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Coordinator Supplement

                            </div>

                            <div class="card-body">

                                @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <textarea class="form-control k_supplement" name="k_supplement" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement" name="k_supplement" rows="3" readonly="">{{ $data->k_supplement }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_coor != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_coor)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="card">

                            <div
                                @if ($data->k_supplement_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Supplement
                            </div>
                            <div class="card-body">

                                @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <textarea class="form-control k_supplement_lead" name="k_supplement_lead" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_lead" name="k_supplement_lead" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="card">

                            <div
                                @if ($data->k_completed_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Supplement
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                                @endif
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End Submitter IT Support Specialist --}}

                {{-- Start IT Support Coordinator --}}
                @if ($data->k_created_by == 28 ||
                    $data->k_created_by == 34 ||
                    $data->k_created_by == 39 ||
                    $data->k_created_by == 53 ||
                    $data->k_created_by == 56)
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_assessment_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Assessment

                                @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3" readonly="">{{ $data->k_assessment_lead }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Assessment

                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif

                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_supplement_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Supplement

                            </div>

                            <div class="card-body">
                                <textarea class="form-control k_supplement" name="k_supplement" rows="3"
                                    @if (($data->k_status_id == 3 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 14 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 17 && auth()->user()->m_flag == 3)) readonly="" @endif
                                    @if (auth()->user()->m_flag != 3) || (k_status_id == 3 )) readonly="" @endif placeholder="">{{ $data->k_supplement_lead }}</textarea>
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_reject_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Supplement
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1)
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                                @endif
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End IT Support Coordinator --}}

                {{-- Start IT Helpdesk Specialist --}}
                @if ($data->k_created_by == 47 ||
                    $data->k_created_by == 48 ||
                    $data->k_created_by == 49 ||
                    $data->k_created_by == 50 ||
                    $data->k_created_by == 51 ||
                    $data->k_created_by == 52)
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_assessment != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Coordinator Assessment

                                @if ($data->k_assessment == null && auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3" readonly="">{{ $data->k_assessment }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_coor != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_coor)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Assessment

                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif

                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_supplement != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Coordinator Supplement

                            </div>

                            <div class="card-body">
                                <textarea class="form-control k_supplement" name="k_supplement" rows="3"
                                    @if (($data->k_status_id == 3 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 14 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 17 && auth()->user()->m_flag == 3)) readonly="" @endif
                                    @if (auth()->user()->m_flag != 3) || (k_status_id == 3 )) readonly="" @endif placeholder="">{{ $data->k_supplement }}</textarea>
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_coor != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_coor)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_reject_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Supplement
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1)
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                                @endif
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End IT Helpdesk Specialist --}}

                {{-- Start Asset JGS --}}
                @if ($data->k_created_by == 43 ||
                    $data->k_created_by == 44 ||
                    $data->k_created_by == 45 ||
                    $data->k_created_by == 33 ||
                    $data->k_created_by == 38 ||
                    $data->k_created_by == 66)
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_assessment_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Assessment

                                @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3" readonly="">{{ $data->k_assessment_lead }}</textarea>
                                @endif
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>



                        <div class="card">

                            <div
                                @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Assessment

                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif

                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_supplement_lead != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Lead Supplement
                            </div>
                            <div class="card-body">
                                <textarea class="form-control k_supplement_lead" name="k_supplement_lead" rows="3"
                                    @if (($data->k_status_id == 3 && auth()->user()->m_flag == 2) ||
                                        ($data->k_status_id == 17 && auth()->user()->m_flag == 2)) readonly="" @endif
                                    @if (auth()->user()->m_flag != 2) || (k_status_id == 3 )) readonly="" @endif placeholder="">{{ $data->k_supplement_lead }}</textarea>
                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_lead != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_completed_lead)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>


                        <div class="card">

                            <div
                                @if ($data->k_reject_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Supplement
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1)
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                                @endif
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End Asset JGS --}}

                {{-- Start IT Helpdesk Coordinator --}}
                @if ($data->k_created_by == 46)
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Assessment

                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif

                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3" readonly="">{{ $data->k_assessment_manager }}</textarea>
                                @endif

                            </div>

                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_completed_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="card-deck">
                        <div class="card">

                            <div
                                @if ($data->k_reject_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                Manager Supplement
                            </div>

                            <div class="card-body">
                                @if (auth()->user()->m_flag == 1)
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"></textarea>
                                @else
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3" readonly="">{{ $data->k_supplement_manager }}</textarea>
                                @endif
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_completed_manager != null)
                                        Completed Date: {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                    @else
                                        Completed Date: -
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End IT Helpdesk Coordinator --}}

                <div class="card">
                    <div class="card-header font-weight-bold">
                        Final Result
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rating</h5>
                        <textarea readonly=""
                            class="drop_here_text form-control
                                @if ($data->k_finalresult == 0) abu
                                @elseif($data->k_finalresult > 0 && $data->k_finalresult <= 54)
                                    merah
                                @elseif($data->k_finalresult > 54 && $data->k_finalresult <= 74)
                                    kuning
                                @elseif($data->k_finalresult > 75 && $data->k_finalresult <= 90)
                                    biru
                                @elseif($data->k_finalresult > 91 && $data->k_finalresult <= 100)
                                    hijau @endif
                                "></textarea><br>
                        {{-- Tombol Coordinator --}}
                        @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                            <button class="btn btn-success nilai_coor" value="0" type="button"><i
                                    class="ti-info-alt me-1"></i> Nilai</button>
                        @endif
                        {{-- Tombol Lead --}}
                        @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                            <button class="btn btn-success nilai_lead" value="0" type="button"><i
                                    class="ti-info-alt me-1 "></i> Nilai</button>
                        @endif
                        {{-- Tombol Manager --}}
                        @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                            <button type="button" class="btn btn-success nilai_manager" value="0"><i
                                    class="ti-info-alt me-1 "></i> Nilai</button>
                            <button data-bs-toggle="modal" data-bs-target=".edit_manager_modal"
                                class="edit_manager btn btn-warning" type="button"><i class="ti-info-alt me-1 "></i>
                                Edit</button>
                        @endif
                    </div>
                </div>


                {{-- modal value --}}
                <div class="modal fade edit_manager_modal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title ms-auto">More Value</h4>
                            </div>
                            <div class="modal-body">
                                <select name="kd_edit_manager_id[]" id="edit_manager" name="edit_manager"
                                    class="form-control">
                                    <option selected=""><b>- Choose One -</b></option>
                                    <option value="0"><b>N/A</b></option>
                                    <option value="54"><b>Unacceptable</b></option>
                                    <option value="74"><b>Need Improvement</b></option>
                                    <option value="90"><b>Good</b></option>
                                    <option value="100"><b>Outstanding</b></option>
                                </select>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default save_edit_manager"
                                    data-bs-dismiss="modal"><i class="far fa-save"></i> Save</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                        class="ti-close"></i>
                                    Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="fr_manager" class="fr_manager">
                <input type="hidden" name="fr_coor" class="fr_coor">
                <input type="hidden" name="fr_lead" class="fr_lead">
                <input type="hidden" name="k_finalresult" class="k_finalresult">
                <input type="hidden" name="k_finalresult_text" class="k_finalresult_text">
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
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.1.6/skins/content/default/content.min.css'
                ],
                setup: function(editor) {

                }
            });
            tinymce.activeEditor.setMode('readonly');

            @if ($data->k_finalresult == 0)
                $('.drop_here_text').text('N/A');
            @elseif ($data->k_finalresult > 0 && $data->k_finalresult <= 54)
                $('.drop_here_text').text('Unacceptable');
            @elseif ($data->k_finalresult > 54 && $data->k_finalresult <= 74)
                $('.drop_here_text').text('Need Improvement');
            @elseif ($data->k_finalresult > 75 && $data->k_finalresult <= 90)
                $('.drop_here_text').text('Good');
            @elseif ($data->k_finalresult > 91 && $data->k_finalresult <= 100)
                $('.drop_here_text').text('Outstanding');
            @endif
        })


        if (('{{ Auth::user()->m_flag }}') == 1) {
            $id = 3;
        } else if (('{{ Auth::user()->m_flag }}') == 2) {
            $id = 17;
        } else if (('{{ Auth::user()->m_flag }}') == 3) {
            $id = 14;
        } else if (('{{ Auth::user()->m_flag }}') == 4) {
            $id = 11;
        }

        function removeClass_warna(argument) {
            $('.fr_result_head').removeClass('kuning');
            $('.fr_result_head').removeClass('merah');
            $('.fr_result_head').removeClass('abu');
            $('.fr_result_head').removeClass('hijau');
            $('.fr_result_head').removeClass('biru');

            $('.drop_here_text').removeClass('kuning');
            $('.drop_here_text').removeClass('merah');
            $('.drop_here_text').removeClass('abu');
            $('.drop_here_text').removeClass('hijau');
            $('.drop_here_text').removeClass('biru');
        }

        $('.save_appreisal').click(function() {
            var m_flag = '{{ Auth::user()->m_flag }}';

            if (m_flag == 1) {
                if ($('.k_assessment_manager').val() == '') {
                    iziToast.warning({
                        icon: 'fa fa-save',
                        position: 'center',
                        title: 'Error!',
                        message: 'Your assessment is required ! ',
                    });
                    $('.k_assessment_manager').focus();
                    return false;
                }

                if ($('[name="fr_manager"]').val() == '' || isNaN($('[name="fr_manager"]').val()) == true) {
                    iziToast.warning({
                        icon: 'fa fa-save',
                        position: 'center',
                        title: 'Warning!!!',
                        message: 'Click <strong>Nilai</strong> before <strong>Completed!</strong>',
                    });
                    return false;
                }

            } else if (m_flag == 2) {
                if ($('.k_assessment_lead').val() == '') {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        position: 'center',
                        title: 'Error!',
                        message: 'Your assessment is required ! ',
                    });
                    $('.k_assessment_lead').focus();
                    return false;
                }

                if ($('[name="fr_lead"]').val() == '' || isNaN($('[name="fr_lead"]').val()) == true) {
                    iziToast.warning({
                        icon: 'fa fa-save',
                        position: 'center',
                        title: 'Warning!!!',
                        message: 'Click <strong>Nilai</strong> before <strong>Completed!</strong>',
                    });
                    return false;
                }

            } else if (m_flag == 3) {
                if ($('.k_assessment').val() == '') {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        position: 'center',
                        title: 'Error!',
                        message: 'Your assessment is required ! ',
                    });
                    $('.k_assessment').focus();
                    return false;
                }
                if ($('[name="fr_coor"]').val() == '' || isNaN($('[name="fr_coor"]').val()) == true) {
                    iziToast.warning({
                        icon: 'fa fa-save',
                        position: 'center',
                        title: 'Warning!!!',
                        message: 'Click <strong>Nilai</strong> before <strong>Completed!</strong>',
                    });
                    return false;
                }
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
                        '<button style="background-color:#17a991;color:white;">Complete</button>',
                        function(instance, toast) {
                            $('.preloader').show();
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
                                url: '{{ route('assessment_all_approval_save_appraisal') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'KPI has been completed',
                                        });
                                        var site = '{{ Session::get('site') }}';
                                        var unit = '{{ Session::get('unit_flag') }}';
                                        if (site == 1) {
                                            if (unit == 2) {
                                                location.href = '{{ URL::previous() }}';
                                            } else if (3) {
                                                location.href = '{{ URL::previous() }}';
                                            }

                                        } else if (site == 2) {

                                            if (unit == 2) {
                                                location.href = '{{ URL::previous() }}';
                                            } else if (3) {
                                                location.href = '{{ URL::previous() }}';
                                            }
                                        } else if (site == 3) {

                                            if (unit == 2) {
                                                location.href = '{{ URL::previous() }}';
                                            } else if (3) {
                                                location.href = '{{ URL::previous() }}';
                                            } else if (1) {
                                                location.href = '{{ URL::previous() }}';
                                            }
                                        } else if (site == 4) {

                                            if (unit == 2) {
                                                location.href = '{{ URL::previous() }}';
                                            } else if (3) {
                                                location.href = '{{ URL::previous() }}';
                                            }
                                        }
                                    } else if (data.status == 'ada') {
                                        iziToast.warning({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Error!',
                                            message: 'Level Sudah Terpakai',
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    // console.log(err.Message);
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
        });

        $('.cc .btn_show').click(function() {
            var status_id = "<?php echo $data->k_status_id; ?>";
            var file_input = '<input type="file" class="chooseFile" value="" name="file1[]">';
            if (status_id == "3") {
                file_input = '<input type="file" class="chooseFile" value="" name="file1[]" disabled>';
            }

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
                                '<div class="form-group mb-3 preview_div remove_show_file text-end value_1 value_to_remove_' +
                                data.file[keying - 1].kpf_id + '">' +
                                '<div class="form-group preview_div">' +
                                '<div class="file-upload upl_1" style="width: 100%;">' +
                                '<div class="file-select">' +
                                '<div class="file-select-button fileName" >File</div>' +
                                '<input type="hidden" value="' + data.file[keying - 1]
                                .kpf_file + '" class="noFile_val file_check_' + data.file[
                                    keying - 1].kpf_ref_id + ' file_checking_' + data.file[
                                    keying - 1].kpf_ref_iddt + '_0">' +
                                '<div class="file-select-name noFile tag_image_1" value="">' +
                                data.file[keying - 1].kpf_file.substr(0, 35) + " ..." +
                                '</div>' +
                                '<input type="file" class="chooseFile" disabled value="" name="file1[]">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-sm-12 row">' +
                                '<div class="col-sm-12 row text-start">' +
                                '<small> Updated Date : ' + (d + "-" + F + "-" + y + "  " +
                                    H + ":" + i) + '</small>' +
                                '</div>' +
                                '<div class="col-sm-12">' +
                                '<button style="margin:5px;' + style +
                                '" type="button" onclick="delete_files(\'' + data.file[
                                    keying - 1].kpf_file +
                                '\')" class="btn btn-danger text-end"><i class="ti-close me-1"></i> Delete</button>' +
                                '<a href="' + baseUrl + "/storage/" + data.file[keying -
                                    1].kpf_file +
                                '" target="_blank" class="btn btn-warning text-end"><i class="ti-file me-1"></i> View Documents</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>');

                            keying++;
                        });
                    }
                },
                error: function(data) {}
            })

            $('.comment_modal_' + $(this).data('id')).modal('show');
        })

        $('.ts_good').click(function() {
            $check = $(this).parents('.gg').find('.ts_good').val();
            $tactical_step = $(this).parents('.gg').find('.hit').val($check);
            $due_date = $(this).parents('.gg').find('.hit2').val();
            $more_value = $(this).parents('.gg').find('.hit3').val();

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($due_date) +
                parseFloat($more_value));

            //set color onclick button
            $(this).parents('.gg').find('[name="kd_tacticalstep[]"]').css('background-color', '#28a745');
            $(this).parents('.gg').find('[name="flag_ts_checked[]"]').val(1);
        })

        $('.ts_bad').click(function() {
            $check = $(this).parents('.gg').find('.ts_bad').val();
            $tactical_step = $(this).parents('.gg').find('.hit').val($check);
            $due_date = $(this).parents('.gg').find('.hit2').val();
            $more_value = $(this).parents('.gg').find('.hit3').val();

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($due_date) +
                parseFloat($more_value));

            //set color onclick button
            $(this).parents('.gg').find('[name="kd_tacticalstep[]"]').css('background-color', '#dc3545');
            $(this).parents('.gg').find('[name="flag_ts_checked[]"]').val(2);

        })

        // due date;
        $('.dd_good').click(function() {
            $check = $(this).parents('.gg').find('.dd_good').val();
            $tactical_step = $(this).parents('.gg').find('.hit').val();
            $due_date = $(this).parents('.gg').find('.hit2').val($check);
            $more_value = $(this).parents('.gg').find('.hit3').val();

            //set color onclick button
            $(this).parents('.gg').find('#firstName').css('background-color', '#28a745');
            $(this).parents('.gg').find('[name="flag_due_date_checked[]"]').val(1);

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($tactical_step) +
                parseFloat($more_value));
        })

        $('.dd_bad').click(function() {
            $check = $(this).parents('.gg').find('.dd_bad').val();
            $tactical_step = $(this).parents('.gg').find('.hit').val();
            $due_date = $(this).parents('.gg').find('.hit2').val($check);
            $more_value = $(this).parents('.gg').find('.hit3').val();

            //set color onclick button
            $(this).parents('.gg').find('#firstName').css('background-color', '#dc3545');
            $(this).parents('.gg').find('[name="flag_due_date_checked[]"]').val(2);

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($tactical_step) +
                parseFloat($more_value));
        })

        $('.mr_value').click(function() {
            $check = $(this).val();
            $tactical_step = $(this).parents('.gg').find('.hit').val();
            $due_date = $(this).parents('.gg').find('.hit2').val();
            $more_value = $(this).parents('.gg').find('.hit3').val($check);
            $add_value = $(this).closest('.modal').find(
                '.add_value'); // hanya cek class .add_value di modal yang aktif

            if ($add_value.val() == '') {
                iziToast.warning({
                    icon: 'fa fa-save',
                    position: 'center',
                    title: 'Error!',
                    message: 'Please, insert your value ! ',
                });
                $('.add_value').focus();
                return false;
            };

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($tactical_step) +
                parseFloat($due_date));

        })
        $('.mr_value_dec').click(function() {
            $check = $(this).val();
            $tactical_step = $(this).parents('.gg').find('.hit').val();
            $due_date = $(this).parents('.gg').find('.hit2').val();
            $more_value = $(this).parents('.gg').find('.hit3').val($check);

            $pr = $(this).parents('.gg').find('.result').val(parseFloat($check) + parseFloat($tactical_step) +
                parseFloat($due_date));

            $(this).parents('.gg').find('.add_value').val(""); // kosongkan value textarea ketika diremove @ospt

            $(this).parents('.gg').find('.viewValue').get(0).nextSibling.remove();
            $(this).parents('.gg').find('.viewValue').replaceWith('<i class="fa fa-plus"></i>Add Value');
        })

        $('.nilai_coor').click(function() {
            removeClass_warna()
            $nilai = [];
            $('.result').each(function(index) {
                // console.log($(this).val());
                $dataini = $(this).val();
                if ($dataini != 0) {
                    if ($dataini == 1) {
                        $nilai[index] = 40;
                    } else if ($dataini == 2) {
                        $nilai[index] = 60;
                    } else if ($dataini == 3) {
                        $nilai[index] = 80;
                    } else if ($dataini == 4) {
                        $nilai[index] = 100;
                    }
                    // console.log( 'index ke '+ index + 'adalah ' + $nilai );
                } else {
                    $nilai[index] = 0;
                    // console.log( 'index ke '+ index + 'adalah 0' );
                }
            });
            // console.log($nilai);
            var total = 0;
            for (var i = 0; i < $nilai.length; i++) {
                total += $nilai[i] << 0;
            }
            $hitung = total / $nilai.length;
            // console.log($hitung);
            $output = '';

            if ($hitung == 0 && $hitung < 10) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('abu');
                $('.drop_here_text').text('N/A');
                $('.k_finalresult_text').val('N/A');
                $('.drop_here_text').addClass('abu');
            } else if ($hitung >= 10 && $hitung < 55) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('merah');
                $('.drop_here_text').text('Unacceptable');
                $('.k_finalresult_text').val('Unacceptable');
                $('.drop_here_text').addClass('merah');
            } else if ($hitung >= 55 && $hitung < 75) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('kuning');
                $('.drop_here_text').text('Need Improvement');
                $('.k_finalresult_text').val('NI');
                $('.drop_here_text').addClass('kuning');
            } else if ($hitung >= 75 && $hitung < 91) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('biru');
                $('.drop_here_text').text('Good');
                $('.k_finalresult_text').val('Good');
                $('.drop_here_text').addClass('biru');
            } else if ($hitung >= 91 && $hitung < 101) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('hijau');
                $('.drop_here_text').text('Outstanding');
                $('.k_finalresult_text').val('Outstanding');
                $('.drop_here_text').addClass('hijau');
            }

            $('.fr_coor').val($hitung);
            $('.k_finalresult').val($hitung);
        })


        $('.nilai_lead').click(function() {
            removeClass_warna()
            $nilai = [];
            $('.result').each(function(index) {
                // console.log($(this).val());
                $dataini = $(this).val();
                if ($dataini != 0) {
                    if ($dataini == 1) {
                        $nilai[index] = 40;
                    } else if ($dataini == 2) {
                        $nilai[index] = 60;
                    } else if ($dataini == 3) {
                        $nilai[index] = 80;
                    } else if ($dataini == 4) {
                        $nilai[index] = 100;
                    }
                    // console.log( 'index ke '+ index + 'adalah ' + $nilai );
                } else {
                    $nilai[index] = 0;
                    // console.log( 'index ke '+ index + 'adalah 0' );
                }
            });
            // console.log($nilai);
            var total = 0;
            for (var i = 0; i < $nilai.length; i++) {
                total += $nilai[i] << 0;
            }
            $hitung = total / $nilai.length;
            // console.log($hitung);
            $output = '';

            if ($hitung == 0 && $hitung < 10) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('abu');
                $('.drop_here_text').text('N/A');
                $('.k_finalresult_text').val('N/A');
                $('.drop_here_text').addClass('abu');
            } else if ($hitung >= 10 && $hitung < 55) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('merah');
                $('.drop_here_text').text('Unacceptable');
                $('.k_finalresult_text').val('Unacceptable');
                $('.drop_here_text').addClass('merah');
            } else if ($hitung >= 55 && $hitung < 75) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('kuning');
                $('.drop_here_text').text('Need Improvement');
                $('.k_finalresult_text').val('NI');
                $('.drop_here_text').addClass('kuning');
            } else if ($hitung >= 75 && $hitung < 91) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('biru');
                $('.drop_here_text').text('Good');
                $('.k_finalresult_text').val('Good');
                $('.drop_here_text').addClass('biru');
            } else if ($hitung >= 91 && $hitung < 101) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('hijau');
                $('.drop_here_text').text('Outstanding');
                $('.k_finalresult_text').val('Outstanding');
                $('.drop_here_text').addClass('hijau');
            }

            $('.fr_lead').val($hitung);
            $('.k_finalresult').val($hitung);
        })



        $('.nilai_manager').click(function() {
            removeClass_warna()
            $nilai = [];
            $('.result').each(function(index) {
                // console.log($(this).val());
                $dataini = $(this).val();
                if ($dataini != 0) {
                    if ($dataini == 1) {
                        $nilai[index] = 40;
                    } else if ($dataini == 2) {
                        $nilai[index] = 60;
                    } else if ($dataini == 3) {
                        $nilai[index] = 80;
                    } else if ($dataini == 4) {
                        $nilai[index] = 100;
                    }
                    // console.log( 'index ke '+ index + 'adalah ' + $nilai );
                } else {
                    $nilai[index] = 0;
                    // console.log( 'index ke '+ index + 'adalah 0' );
                }
            });
            // console.log($nilai);
            var total = 0;
            for (var i = 0; i < $nilai.length; i++) {
                total += $nilai[i] << 0;
            }
            $hitung = total / $nilai.length;
            // console.log($hitung);
            $output = '';

            if ($hitung == 0 && $hitung < 10) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('abu');
                $('.drop_here_text').text('N/A');
                $('.drop_here_text').addClass('abu');
                $('.k_finalresult_text').val('N/A');
            } else if ($hitung >= 10 && $hitung < 55) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('merah');
                $('.drop_here_text').text('Unacceptable');
                $('.drop_here_text').addClass('merah');
                $('.k_finalresult_text').val('Unacceptable');
            } else if ($hitung >= 55 && $hitung < 75) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('kuning');
                $('.drop_here_text').text('Need Improvement');
                $('.drop_here_text').addClass('kuning');
                $('.k_finalresult_text').val('NI');
            } else if ($hitung >= 75 && $hitung < 91) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('biru');
                $('.drop_here_text').text('Good');
                $('.drop_here_text').addClass('biru');
                $('.k_finalresult_text').val('Good');
            } else if ($hitung >= 91 && $hitung < 101) {
                $('.fr_result_head').html($hitung);
                $('.fr_result_head').addClass('hijau');
                $('.drop_here_text').text('Outstanding');
                $('.drop_here_text').addClass('hijau');
                $('.k_finalresult_text').val('Outstanding');
            }

            $('.fr_manager').val($hitung);
            $('.k_finalresult').val($hitung);

        })
    </script>
@endpush
