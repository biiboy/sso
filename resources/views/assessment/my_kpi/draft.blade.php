@extends('master')

@push('title')
    View KPI
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        <a class="btn btn-md btn-warning" href="{{ route('assessment_kpi_edit', ['id' => $data_edit->k_id]) }}">
            <i class="ti-pencil-alt me-1"></i> Edit
        </a>
    </div>
@endpush

@section('content')
    <div class="card">
        <form id="save" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                <br>
                <input type="hidden" name="hidden_id_header" id="hidden_id_header" value="{{ $data_edit->k_id }}">
                <div class="form-group row mb-3">
                    <label for="k_collaboration" class="col-2 col-form-label"><b>Collaboration</b></label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_collaboration" id="k_collaboration"
                            style="pointer-events: none;background: lightgrey" placeholder="Collaboration"
                            @if ($data_edit->k_collab_helpdesk == 'ya' &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == null) value="IT Helpdesk"

                            @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                $data_edit->k_collab_assets == 'ya' &&
                                $data_edit->k_collab_support == null) value="IT Asset dan Helpdesk"

                            @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == 'ya') value="IT Support dan IT Helpdesk"

                            @elseif ($data_edit->k_collab_helpdesk == 'ya' &&
                                $data_edit->k_collab_assets == 'ya' &&
                                $data_edit->k_collab_support == 'ya') value="All IT Services" @endif
                            @if ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == 'ya' &&
                                $data_edit->k_collab_support == null) value="IT Asset"

                            @elseif ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == 'ya' &&
                                $data_edit->k_collab_support == 'ya') value="IT Asset dan IT Support"

                            @elseif ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == 'ya') value="IT Support" @endif
                            @if ($data_edit->k_collab_helpdesk == null &&
                                $data_edit->k_collab_assets == null &&
                                $data_edit->k_collab_support == null) value="-" @endif>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label"><b>Status</b></label>
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
                    <label for="k_label" class="col-2 col-form-label"><b>Key Result Area</b></label>

                    <div class="col-8">
                        <b><input class="form-control k_label" type="text" disabled="" name="k_label" id="k_label"
                                value="{{ $data_edit->k_label }}" placeholder="Key Result Area"></b>
                    </div>

                    <div class="col-2 text-end"">
                        @if ($check_total_header_kra[0] == 0)
                            <button type="button" class="btn btn-info comment_kra"
                                onclick="comment_kra({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                                    class="txt_kra"> Comment
                                </span></button>
                        @else
                            <button type="button" class="btn btn-danger comment_kra"
                                onclick="comment_kra({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                                    class="txt_kra"> View Comment
                                </span></button>
                        @endif
                    </div>
                </div>
                {{-- modal kra --}}
                <div class="col-md-4">
                    <div>
                        <div id="comment_kra" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel"><b>Comment</b></h4>
                                    </div>
                                    <table class="append_comment_kra table table-bordered table-stripped"
                                        required="required">
                                        <tr>
                                            <th>Comment</th>
                                            <th>Created By</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </table>
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_kra k_comment_kra" rows="3" name="k_comment_kra"
                                                placeholder="Text Here..."></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_kra"
                                                onclick="add_comment_kra()">
                                                <i class="ti-plus me-1"></i>
                                                Add
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
                    </div>
                </div>
                {{-- end of modal kra --}}
                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label"><b>Goal</b></label>
                    <div class="col-8">
                        <textarea class="form-control k_goal" rows="3" id="mymce" disabled="" name="kd_tacticalstep[]"
                            placeholder="Text Here...">{!! $data_edit->k_goal !!}</textarea>
                    </div>

                    <div class="col-2 text-end">
                        @if ($check_total_header_goal[0] == 0)
                            <button type="button" class="btn btn-info comment_goal"
                                onclick="comment_goal({{ $data_edit->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_goal"> Comment
                                </span>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger comment_goal"
                                onclick="comment_goal({{ $data_edit->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_goal"> View Comment
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <div id="comment_goal" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel"><b>Comment</b></h4>
                                    </div>
                                    <table class="append_comment_goal table table-bordered table-stripped">
                                        <tr>
                                            <th>Comment</th>
                                            <th>Created By</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </table>
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_goal k_comment_goal" rows="3" name="k_comment_goal"
                                                placeholder="Text Here..."></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_goal"
                                                onclick="add_comment_goal()">
                                                <i class="ti-plus me-1"></i>
                                                Add
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
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_targetdate" class="col-2 col-form-label"><b>Target Date</b></label>
                    <div class="col-8">
                        <input class="form-control" type="text" disabled="" name="k_targetdate" id="k_targetdate"
                            value="{{ date('d-M-Y', strtotime($data_edit->k_targetdate)) }}" placeholder="Target Date">
                    </div>
                    <div class="col-2 text-end">
                        @if ($check_total_header_date[0] == 0)
                            <button type="button" class="btn btn-info comment_date"
                                onclick="comment_date({{ $data_edit->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_date"> Comment</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger comment_date"
                                onclick="comment_date({{ $data_edit->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_date"> View Comment</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div>
                        <div id="comment_date" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel"><b>Comment</b></h4>
                                    </div>
                                    <table class="append_comment_date table table-bordered table-stripped">
                                        <tr>
                                            <th>Comment</th>
                                            <th>Created By</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </table>
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_date k_comment_date" rows="3" name="k_comment_date"
                                                placeholder="Text Here..."></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_date"
                                                onclick="add_comment_date()">
                                                <i class="ti-plus me-1"></i>
                                                Add
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
                    </div>
                </div>

                <div class="drop_here">
                    @foreach ($data as $index => $element)
                        <div class="card mb-3">
                            <div class="card-header" style="font-size:30px">
                                <b>Tactical Step {{ $index + 1 }}</b>

                                @if ($check_total_cmnt[$index] == 0)
                                    <div class="btn btn-info comment ms-auto"
                                        onclick="comment_review({{ $element->kd_id }})">
                                        <i class="ti-comment me-1"></i>
                                        Comment
                                    </div>
                                @else
                                    @if ($data_edit->k_status_id == 1)
                                    @else
                                        <div class="btn btn-danger comment ms-auto"
                                            onclick="comment_review({{ $element->kd_id }})">
                                            <i class="ti-comment me-1"></i>
                                            View Comment
                                        </div>
                                    @endif
                                @endif
                            </div>
                            </h5>

                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="kd_tacticalstep[]" rows="3"
                                        style="pointer-events: none;background: lightgrey">{{ $element->kd_tacticalstep }}</textarea>
                                </div>

                                <form>
                                    <div class="row">
                                        <div class="col-3">
                                            <label><b>Measured By</b></label>
                                            <select class="form-control" name="kd_measure_id[]"
                                                style="pointer-events: none;background: lightgrey">
                                                @foreach ($measure as $el)
                                                    @if ($el->dm_id == $element->kd_measure_id)
                                                        <option value="{{ $el->dm_id }}" selected="">
                                                            {{ $el->dm_name }}</option>
                                                    @else
                                                        <option value="{{ $el->dm_id }}">
                                                            {{ $el->dm_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-3">
                                            <label><b>Due Date</b></label>
                                            <input type="text" class="form-control" name="kd_duedate[]"
                                                value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                style="pointer-events: none;background: lightgrey">
                                        </div>

                                        <div class="col-2">
                                            <label><b>Result</b></label>
                                            <input type="text" class="form-control"
                                                style="pointer-events: none;background: lightgrey" name="kd_result_id[]"
                                                placeholder="N/A">
                                        </div>

                                        <div class="col-4">
                                            <label><b>Status</b></label>
                                            <input type="text" class="form-control"
                                                style="pointer-events: none;background: lightgrey" name="kd_status_id[]"
                                                placeholder="N/A">
                                        </div>

                                        {{-- hidden --}}
                                        <input type="hidden" name="no_index" value="{{ $index }}">

                                        <div class="modal fade comment_modal_{{ $index }}" role="dialog">

                                        </div>
                                        <div clas='col-sm-12'>
                                            <div class="row col-sm-12">
                                                <div id="modal_comment_{{ $element->kd_id }}" class="modal fade"
                                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">
                                                                    <b>Comment</b>
                                                                </h4>
                                                            </div>
                                                            <table
                                                                class="append_data_{{ $element->kd_id }} table table-bordered table-stripped">
                                                                <tr>
                                                                    <th>Comment</th>
                                                                    <th>Created By</th>
                                                                    <th>Create Date</th>
                                                                </tr>
                                                            </table>
                                                            @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                                                ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                                ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                            @else
                                                                <div class="modal-body">
                                                                    <textarea class="form-control cmnt_remove kd_comment_{{ $element->kd_id }}" rows="3" name="kd_comment"
                                                                        placeholder="Text Here..."></textarea>
                                                                    <br>
                                                                </div>
                                                            @endif
                                                            <div class="modal-footer">
                                                                @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                                                    ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                                    ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-default add_comment"
                                                                        value="{{ $element->kd_id }}"
                                                                        onclick="add_comment_coeg(this)"><i
                                                                            class="ti-plus me-1"></i>
                                                                        Add</button>
                                                                @endif
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal"><i class="ti-close me-1"></i>
                                                                    Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    {{-- Leader --}}
                    @if ($data_edit->k_created_by == 26 || $data_edit->k_created_by == 27)
                        <div class="card">
                            <div
                                class="card-header text-white @if ($data_edit->k_reject_manager != null) bg-danger @elseif ($data_edit->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                Manager Comment on Draft
                            </div>
                            <div class="card-body">
                                <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                    name="k_justification_manager[]">{!! $data_edit->k_justification_manager !!}
                                </p>
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data_edit->k_reject_manager != null)
                                        Rejected Date:
                                        {{ date('d-M-Y H:i A', strtotime($data_edit->k_reject_manager)) }}
                                    @elseif ($data_edit->k_approval_manager != null)
                                        Approved Date:
                                        {{ date('d-M-Y H:i A', strtotime($data_edit->k_approval_manager)) }}
                                    @else
                                        -
                                    @endif
                                </small>
                            </div>
                        </div>

                        {{-- Coordinator --}}
                    @elseif ($data_edit->k_created_by == 28 ||
                        $data_edit->k_created_by == 34 ||
                        $data_edit->k_created_by == 39 ||
                        $data_edit->k_created_by == 53 ||
                        $data_edit->k_created_by == 56)
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data_edit->k_reject_lead != null) bg-danger @elseif ($data_edit->k_approval_lead != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Lead Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_lead" rows="3" readonly=""
                                        name="k_justification_lead[]">{!! $data_edit->k_justification_lead !!}
                                    </p>
                                </div>

                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data_edit->k_reject_lead != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_reject_lead)) }}
                                        @elseif ($data_edit->k_approval_lead != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_approval_lead)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data_edit->k_reject_manager != null) bg-danger @elseif ($data_edit->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data_edit->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data_edit->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_reject_manager)) }}
                                        @elseif ($data_edit->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Specialist Helpdesk --}}
                    @elseif ($data_edit->k_created_by == 47 ||
                        $data_edit->k_created_by == 48 ||
                        $data_edit->k_created_by == 49 ||
                        $data_edit->k_created_by == 50 ||
                        $data_edit->k_created_by == 51 ||
                        $data_edit->k_created_by == 52)
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data_edit->k_reject_coor != null) bg-danger @elseif ($data_edit->k_approval_coor != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Coordinator Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_coor" rows="3" readonly=""
                                        name="k_justification_coor[]">
                                        {!! $data_edit->k_justification_coor !!}</p>
                                </div>

                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data_edit->k_reject_coor != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_reject_coor)) }}
                                        @elseif ($data_edit->k_approval_coor != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_approval_coor)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data_edit->k_reject_manager != null) bg-danger @elseif ($data_edit->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">

                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data_edit->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data_edit->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_reject_manager)) }}
                                        @elseif ($data_edit->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data_edit->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
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
            });
            tinymce.activeEditor.setMode('readonly');
        })

        var id_hidden = $('#hidden_id_header').val();

        function comment_kra() {
            $('.k_comment_kra').val('');
            $('.append_comment_kra').empty();
            $('.append_comment_kra').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/show_comment_kra',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_kra').append('<tr><td>' + response.data_cm[key - 1]
                                .kch_comment + '</td><td>' + response.data_cm[key - 1].m_username +
                                '</td><td>' + ([d] + "-" + monthMap[M] + "-" + y + "  " + [H] +
                                    ":" + [m]) + '</td></tr>');
                            key++;

                        });
                        $('#comment_kra').modal('show');

                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function add_comment_kra() {
            $cmnt_kra = $('.k_comment_kra').val();
            if ($cmnt_kra == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    DisplayMode: 'once',
                    title: 'Warning!',
                    message: 'Comment required!',
                });
                return false;
            }

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/save_comment_kra',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_kra,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);

                        $('.append_comment_kra').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_kra').val(' ');

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
        }

        function comment_goal() {
            $('.k_comment_goal').val('');
            $('.append_comment_goal').empty();
            $('.append_comment_goal').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/show_comment_goal',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_goal').append('<tr><td>' + response.data_cm[key - 1]
                                .kch_comment + '</td><td>' + response.data_cm[key - 1].m_username +
                                '</td><td>' + ([d] + "-" + monthMap[M] + "-" + y + "  " + [H] +
                                    ":" + [m]) + '</td></tr>');
                            key++;
                        });
                        $('#comment_goal').modal('show');

                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function add_comment_goal() {
            $cmnt_goal = $('.k_comment_goal').val();
            if ($cmnt_goal == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    DisplayMode: 'once',
                    title: 'Warning!',
                    message: 'Comment required!',
                });
                return false;
            }
            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/save_comment_goal',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_goal + '&k_comment_g=' + $cmnt_goal,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);

                        $('.append_comment_goal').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_goal').val(' ');

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
        }

        function comment_date() {
            $('.k_comment_date').val('');
            $('.append_comment_date').empty();
            $('.append_comment_date').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/show_comment_date',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_date').append('<tr><td>' + response.data_cm[key - 1]
                                .kch_comment + '</td><td>' + response.data_cm[key - 1].m_username +
                                '</td><td>' + ([d] + "-" + monthMap[M] + "-" + y + "  " + [H] +
                                    ":" + [m]) + '</td></tr>');
                            key++;
                        });
                        $('#comment_date').modal('show');

                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function add_comment_date() {
            $cmnt_date = $('.k_comment_date').val();
            if ($cmnt_date == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    DisplayMode: 'once',
                    title: 'Warning!',
                    message: 'Comment required!',
                });
                return false;
            }

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/save_comment_date',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_date,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);

                        $('.append_comment_date').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_date').val(' ');

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
        }

        function comment_review(argument) {
            $('.cmnt_remove').val('');
            $('.append_data_' + argument).empty();
            $('.append_data_' + argument).append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/show_comment',
                data: '&kd_ref_id=' + argument,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            console.log(response.data_cm[key - 1].kc_comment);
                            var formattedDate = new Date(response.data_cm[key - 1].kc_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_data_' + argument).append('<tr><td>' + response.data_cm[key - 1]
                                .kc_comment + '</td><td>' + response.data_cm[key - 1].m_username +
                                '</td><td>' + ([d] + "-" + monthMap[M] + "-" + y + "  " + [H] +
                                    ":" + [m]) + '</td></tr>');
                            key++;
                        });
                        $('#modal_comment_' + argument).modal('show');
                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function add_comment_coeg(elem) {
            $refid = $(elem).val();
            $cmmnt = $('.kd_comment_' + $refid).val();
            if ($cmmnt == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    title: 'Error!',
                    message: 'Comment required!',
                });
                return false;
            }

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/save_comment',
                data: $('#save').serialize() + '&kd_ref_id=' + $refid + '&kd_comment=' + $cmmnt,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {

                        $('.append_data_' + $refid).append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove').val(' ');

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
        }
    </script>
@endpush
