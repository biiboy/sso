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
    </style>
@endpush

@push('top-buttons')
    @if (auth()->user()->m_flag != 4)
        <div class="d-flex justify-content-end">
            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                <button class="btn btn-success save_appreisal" type="button"><i class="ti-check me-1"></i>Complete</button>
            @endif
            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                <button class="btn btn-success save_appreisal" type="button"><i class="ti-check me-1"></i>Complete</button>
            @endif
            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                <button class="btn btn-success save_appreisal" type="button"><i class="ti-check me-1"></i>Complete</button>
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
                            @if ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == null) value="Collab With IT Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == 'ya' && $data->k_collab_support == null)
                            value="Collaboration With IT Asset dan Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == 'ya')
                            value="Collaboration With IT Support dan IT Helpdesk"

                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == 'ya' && $data->k_collab_support == 'ya')
                            value="All IT Services" @endif
                            {{-- Collab sama IT ASset --}}
                            @if ($data->k_collab_helpdesk == null && $data->k_collab_assets == 'ya' && $data->k_collab_support == null) value="Collab With IT Asset"

                            @elseif ($data->k_collab_helpdesk == null && $data->k_collab_assets == 'ya' && $data->k_collab_support == 'ya')
                            value="Collaboration With IT Asset dan IT Support"

                            @elseif ($data->k_collab_helpdesk == null && $data->k_collab_assets == null && $data->k_collab_support == 'ya')
                            value="Collaboration With IT Support" @endif
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
                                            data-iddetail="{{ $element->kd_id }}">
                                            <i class="ti-file me-1"></i>
                                            View Documents
                                        </button>
                                        @if (auth()->user()->m_flag != 4)
                                            @if ((auth()->user()->m_flag == 3 && $data->k_status_id == 11) ||
                                                (auth()->user()->m_flag == 2 && $data->k_status_id == 14) ||
                                                (auth()->user()->m_flag == 1 && $data->k_status_id == 17))
                                                <button type="button" class="text-right btn btn-success"
                                                    data-bs-toggle="modal" data-bs-target=".value_modal_{{ $index }}"
                                                    required="">
                                                    <i class="ti-eye me-1"></i>
                                                    View Value
                                                </button>
                                            @endif
                                        @endif
                                        @if ($data->k_status_id == 3)
                                            @if ($element->kd_value == null || $element->kd_value == '')
                                            @else
                                                <button type="button" class="text-right btn btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target=".value_modal_{{ $index }}" required="">
                                                    <i class="ti-eye me-1"></i>
                                                    View Value
                                                </button>
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
                                                name="add_comment[]" placeholder="Text Here..." {{ $readonlyComment }}>{{ $element->kd_comment ?? null }}</textarea>
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
                                                    data-value="1" data-dismiss="modal">
                                                    <i class="ti-plus me-1"></i>
                                                    Add
                                                </button>
                                                <button type="button" class="btn btn-warning mr_value_dec"
                                                    value="0" data-value="0" data-dismiss="modal">
                                                    <i class="ti-trash-alt me-1"></i>
                                                    Remove
                                                </button>
                                            @endif

                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                <i class="ti-close me-1"></i>
                                                Close
                                            </button>
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
                                                    value="1.5"><i class="ti-check me-1"></i></button><br><br><br>

                                                <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                    value="0.5"><i class="ti-close me-1"></i></button>
                                            @endif
                                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                                <button type="button" class="btn btn-success btn-xm ts_good"
                                                    value="1.5"><i class="ti-check me-1"></i></button><br><br><br>

                                                <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                    value="0.5"><i class="ti-close me-1"></i></button>
                                            @endif
                                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                                <div class="dropdown d-inline-block cc">
                                                    <button type="button" class="btn btn-success btn-xm ts_good"
                                                        value="1.5"><i class="ti-check me-1"></i></button><br><br><br>

                                                    <button type="button" class="btn btn-danger btn-xm ts_bad"
                                                        value="0.5"><i class="ti-close me-1"></i></button>
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
                                                <div class="text-right"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check me-1"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close me-1"></i></button>
                                                </div>
                                            @endif
                                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                                <div class="text-right"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check me-1"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close me-1"></i></button>
                                                </div>
                                            @endif
                                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                                <div class="text-right"
                                                    style="margin-top: -38px;margin-bottom: 10px;margin-right: 0px">
                                                    <button type="button" class="btn btn-success btn-xm dd_good"
                                                        value="1.5"><i class="ti-check me-1"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xm dd_bad"
                                                        value="0.5"><i class="ti-close me-1"></i></button>
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
                                            placeholder="N/A">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-danger">
                                        <label class="control-label"><b>Status</b></label>
                                        <select
                                            @if ($element->kd_status_id == 'Completed') name="kd_status_id[]" readonly="" style="pointer-events: none"
                                            id="status" name="status" class="form-control" @else name="kd_status_id[]" readonly="" style="pointer-events: none"
                                                    id="status" onchange="status_update({{ $element->kd_id }})"
                                                    name="status" class="form-control status_{{ $element->kd_id }}" @endif>
                                            @if ($element->kd_status_id == 'N/A')
                                                <option selected="" value="N/A"><b>N/A</b></option>
                                                <option value="In Progress"><b>In Progress</b></option>
                                                <option value="Completed"><b>Complete</b></option>
                                            @elseif($element->kd_status_id == 'Not Started')
                                                <option value="N/A"><b>N/A</b></option>
                                                <option value="In Progress"><b>In Progress</b></option>
                                                <option value="Completed"><b>Complete</b></option>
                                            @elseif($element->kd_status_id == 'In Progress')
                                                <option value="N/A"><b>N/A</b></option>
                                                <option value="Not Started"><b>Not Started</b></option>
                                                <option selected="" value="In Progress"><b>In Progress on
                                                        {{ date('d-m-Y H:i', strtotime($element->kd_completed_date)) }}</b>
                                                </option>
                                                <option value="Completed"><b>Complete</b></option>
                                            @elseif($element->kd_status_id == 'Completed')
                                                <option value="N/A"><b>N/A</b></option>
                                                <option value="In Progress"><b>In Progress</b></option>
                                                <option selected="" value="Completed"><b>Completed on
                                                        {{ date('d-M-Y H:i', strtotime($element->kd_completed_date)) }}</b>
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
                                @if ($data->k_completed_coor != null)
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
                                @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1)
                                    <span style="color:red;font-weight:bold" class="important"> *</span>
                                @endif
                            </div>

                            <div class="card-body">
                                <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                    @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                    placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                    @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                    placeholder="">{{ $data->k_supplement_manager }}</textarea>
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
                                    @if ($data->k_assessment == null && auth()->user()->m_flag == 3)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3"
                                        @if (($data->k_status_id == 3 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 14 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 17 && auth()->user()->m_flag == 3)) readonly="" @endif @if (auth()->user()->m_flag != 3) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment }}</textarea>
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
                                    @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 2)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif

                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"
                                        @if (($data->k_status_id == 3 && auth()->user()->m_flag == 2) ||
                                            ($data->k_status_id == 17 && auth()->user()->m_flag == 2)) readonly="" @endif @if (auth()->user()->m_flag != 2) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_lead }}</textarea>
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
                                    @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                    @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Supplement
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="">{{ $data->k_supplement_manager }}</textarea>
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
                                    @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 2)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"
                                        @if (($data->k_status_id == 3 && auth()->user()->m_flag == 2) ||
                                            ($data->k_status_id == 17 && auth()->user()->m_flag == 2)) readonly="" @endif @if (auth()->user()->m_flag != 2) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_lead }}</textarea>
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

                                    @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif

                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                    @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Supplement
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="">{{ $data->k_supplement_manager }}</textarea>
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
                    {{-- End Submitter IT Support Coordinator --}}


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
                                    @if ($data->k_assessment == null && auth()->user()->m_flag == 3)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment" name="k_assessment" rows="3"
                                        @if (($data->k_status_id == 3 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 14 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 17 && auth()->user()->m_flag == 3)) readonly="" @endif @if (auth()->user()->m_flag != 3) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment }}</textarea>
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
                                    @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                    @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Supplement
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="">{{ $data->k_supplement_manager }}</textarea>
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

                    {{-- Start IT Helpdesk Coordinator --}}
                    @if ($data->k_created_by == 46)
                        <div class="card-deck">
                            <div class="card">
                                <div
                                    @if ($data->k_assessment_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Assessment
                                    @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                    @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Supplement
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="">{{ $data->k_supplement_manager }}</textarea>
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
                    {{-- End IT Helpdesk Coordinator --}}

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
                                    @if ($data->k_assessment_lead == null && auth()->user()->m_flag == 2)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control k_assessment_lead" name="k_assessment_lead" rows="3"
                                        @if (($data->k_status_id == 3 && auth()->user()->m_flag == 2) ||
                                            ($data->k_status_id == 17 && auth()->user()->m_flag == 2)) readonly="" @endif @if (auth()->user()->m_flag != 2) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_lead }}</textarea>
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
                                    @if ($data->k_assessment_manager == null && auth()->user()->m_flag == 1 && $data->k_status_id == 16)
                                        <span style="color:red;font-weight:bold" class="important"> *</span>
                                    @endif
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_assessment_manager" name="k_assessment_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif
                                        placeholder="Text Here...">{{ $data->k_assessment_manager }}</textarea>
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
                                    @if ($data->k_supplement_manager != null) class="card-header text-white bg-success font-weight-bold" @else class="card-header bg-light font-weight-bold" @endif>
                                    Manager Supplement
                                </div>

                                <div class="card-body">
                                    <textarea class="form-control k_supplement_manager" name="k_supplement_manager" rows="3"
                                        @if ($data->k_status_id == 3 && auth()->user()->m_flag == 1) readonly="" @endif @if (auth()->user()->m_flag != 1) readonly="" @endif>{{ $data->k_supplement_manager }}</textarea>
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
                    {{-- End Asset JGS --}}

                    <div class="card">
                        <div class="card-header font-weight-bold">
                            <h3 class="card-title">Final Result</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Rating</h5>

                            @if ($data->k_finalresult_text == 'Outstanding')
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title text-center">Outstanding</h2>
                                    </div>
                                </div>
                            @endif

                            @if ($data->k_finalresult_text == 'Good')
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title text-center">Good</h2>
                                    </div>
                                </div>
                            @endif

                            @if ($data->k_finalresult_text == 'NI')
                                <div class="card text-white bg-warning mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title text-center">Need Improvement</h2>
                                    </div>
                                </div>
                            @endif

                            @if ($data->k_finalresult_text == 'Unacceptable')
                                <div class="card text-white bg-danger mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title text-center">Unacceptable</h2>
                                    </div>
                                </div>
                            @endif

                            @if ($data->k_finalresult_text == 'N/A')
                                <div class="card text-white bg-secondary mb-3">
                                    <div class="card-body">
                                        <h2 class="card-title text-center">N/A</h2>
                                    </div>
                                </div>
                            @endif



                            {{-- Tombol Coordinator --}}
                            @if (auth()->user()->m_flag == 3 && $data->k_status_id == 11)
                                <button class="nilai_coor btn-success btn btn-sm" value="0" type="button"><i
                                        class="fas fa-info-circle "></i> Nilai</button>
                            @endif
                            {{-- Tombol Lead --}}
                            @if (auth()->user()->m_flag == 2 && $data->k_status_id == 14)
                                <button class="nilai_lead btn-success btn btn-sm" value="0" type="button"><i
                                        class="fas fa-info-circle "></i> Nilai</button>
                            @endif
                            {{-- Tombol Manager --}}
                            @if (auth()->user()->m_flag == 1 && $data->k_status_id == 17)
                                <button type="button" class="btn btn-success nilai_manager" value="0"><i
                                        class="fas fa-info-circle "></i>Nilai</button>
                                <button data-toggle="modal" data-target=".edit_manager_modal"
                                    class="edit_manager btn btn-warning" type="button"><i
                                        class="fas fa-info-circle "></i>
                                    Edit</button>
                            @endif
                        </div>
                    </div>

                    {{-- modal value --}}
                    <div class="modal fade edit_manager_modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"></button>
                                    <h4 class="modal-title">More Value</h4>
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
                                        data-dismiss="modal"><i class="far fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                            class="ti-close me-1"></i>
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
                    '//www.tinymce.com/css/codepen.min.css'
                ],
                setup: function(editor) {

                }
            });
            tinymce.activeEditor.setMode('readonly');
        })

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
                                '<div class="form-group preview_div remove_show_file text-right value_1 value_to_remove_' +
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
                                '<div class="col-sm-12 row text-left" style="margin-top: -15px;">' +
                                '<small> Updated Date : ' + (d + "-" + F + "-" + y + "  " +
                                    H + ":" + i) + '</small>' +
                                '</div>' +
                                '<div class="col-sm-12 text-end my-2 ms-3">' +
                                '<button style="margin:5px;' + style +
                                '" type="button" onclick="delete_files(\'' + data.file[
                                    keying - 1].kpf_file +
                                '\')" class="btn btn-danger text-right"><i class="ti-close me-1"></i> Delete</button>' +
                                '<a href="' + baseUrl + "/storage/" + data.file[keying -
                                    1].kpf_file +
                                '" target="_blank" class="btn btn-warning"><i class="ti-file me-1"></i> View Documents</a>' +
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
    </script>
@endpush
