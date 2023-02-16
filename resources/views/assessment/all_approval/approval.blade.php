@extends('master')

@push('title')
    Approval
@endpush

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('top-buttons')
    <div class="d-flex justify-content-end">
        @if (($data->k_status_id == 10 && auth()->user()->m_flag == 3) ||
            ($data->k_status_id == 13 && auth()->user()->m_flag == 2) ||
            ($data->k_status_id == 16 && auth()->user()->m_flag == 1))
            <button class="btn btn-success cmnt_remove me-2" type="button" onclick="save()">
                <i class="ti-check me-1"></i>
                Approve
            </button>

            <button class="btn btn-danger cmnt_remove" type="button" onclick="reject()">
                <i class="ti-close me-1"></i>
                Reject
            </button>
        @endif
    </div>
@endpush

@section('content')
    <div class="card">
        <form id="save">
            <div class="card-body">
                <br>
                <input type="hidden" class="hidden_id_header" name="hidden_id_header" value="{{ $data->k_id }}">
                <input type="hidden" value="{{ $data->k_collab_assets }}" name="k_collab_assets">
                <input type="hidden" value="{{ $data->k_collab_helpdesk }}" name="k_collab_helpdesk">
                <input type="hidden" value="{{ $data->k_collab_support }}" name="k_collab_support">
                <input type="hidden" value="{{ $data->k_created_by }}" name="k_created_by">
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Submitted By</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_name" id="k_name"
                            style="pointer-events: none;background: lightgrey" value="{{ $data->m_name }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Submit Date</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_name" id="k_name"
                            style="pointer-events: none;background: lightgrey"
                            value="{{ date('d-M-Y', strtotime($data->k_created_at)) }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Status</b>
                    </label>
                    <div class="col-10">
                        @php
                            $value = '';
                            
                            if ($data->k_status_id == 1) {
                                if (auth()->user()->m_flag == 3) {
                                    $value = 'Active';
                                } else {
                                    $value = 'Active';
                                }
                            } elseif ($data->k_status_id == 2 || $data->k_status_id == 4 || $data->k_status_id == 5 || $data->k_status_id == 6) {
                                $value = 'Draft';
                            } elseif ($data->k_status_id == 3) {
                                $value = 'Final';
                            } elseif ($data->k_status_id == 10) {
                                if (auth()->user()->m_flag == 3) {
                                    $value = 'Waiting for Approval ' . session('coor');
                                } else {
                                    $value = 'Waiting for Approval ' . session('coor');
                                }
                            } elseif ($data->k_status_id == 11) {
                                if (auth()->user()->m_flag == 3) {
                                    $value = 'In review by ' . session('coor');
                                } else {
                                    $value = 'In review by ' . session('coor');
                                }
                            } elseif ($data->k_status_id == 12) {
                                $value = 'Rejected by ' . session('coor');
                            } elseif ($data->k_status_id == 13) {
                                if (auth()->user()->m_flag == 2) {
                                    $value = 'Waiting for Approval ' . session('lead');
                                } else {
                                    $value = 'Waiting for Approval ' . session('lead');
                                }
                            } elseif ($data->k_status_id == 14) {
                                if (auth()->user()->m_flag == 2) {
                                    $value = 'In review by ' . session('lead');
                                } else {
                                    $value = 'In review by ' . session('lead');
                                }
                            } elseif ($data->k_status_id == 15) {
                                $value = 'Rejected by ' . session('lead');
                            } elseif ($data->k_status_id == 16) {
                                if (auth()->user()->m_flag == 1) {
                                    $value = 'Waiting for Approval ' . session('manager');
                                } else {
                                    $value = 'Waiting for Approval ' . session('manager');
                                }
                            } elseif ($data->k_status_id == 17) {
                                if (auth()->user()->m_flag == 1) {
                                    $value = 'In review by ' . session('manager');
                                } else {
                                    $value = 'In review by ' . session('manager');
                                }
                            } elseif ($data->k_status_id == 18) {
                                $value = 'Rejected by ' . session('manager');
                            }
                        @endphp

                        <input class="form-control" type="text" name="k_name" id="k_name"
                            style="pointer-events: none;background: lightgrey" value="{{ $value }}"
                            placeholder="Submitted Date">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Collaboration</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_label" id="k_label"
                            style="pointer-events: none;background: lightgrey" placeholder="Key Result Area"
                            @if ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == null) value="IT Helpdesk"
                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == 'ya' && $data->k_collab_support == null)
                                value="IT Asset dan Helpdes"
                            @elseif ($data->k_collab_helpdesk == 'ya' && $data->k_collab_assets == null && $data->k_collab_support == 'ya')
                                value="IT Support dan IT Helpdes"
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
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Key Result Area</b>
                    </label>
                    <div class="col-8">
                        <input class="form-control" type="text" name="k_label" id="k_label" readonly=""
                            value="{{ $data->k_label }}" placeholder="Key Result Area">
                    </div>
                    <div class="col-2 text-end">
                        @if ($check_total_header_kra[0] == 0)
                            <button type="button" class="btn btn-primary comment_kra"
                                onclick="comment_kra({{ $data->k_id }})"><i class="ti-comment me-1"></i><span
                                    class="txt_kra">
                                    Comment</span></button>
                        @else
                            <button type="button" class="btn btn-danger comment_kra"
                                onclick="comment_kra({{ $data->k_id }})"><i class="ti-comment me-1"></i><span
                                    class="txt_kra"> View
                                    Comment</span></button>
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
                                    @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_kra k_comment_kra" rows="3" name="k_comment_kra" placeholder=""></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_kra"><i
                                                    class="fas fa-plus"></i> Add</button>
                                        @endif
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                                class="fas fa-times"></i> Close</button>
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
                        <textarea class="form-control mymce" rows="3" id="mymce" name="k_goal">{!! $data->k_goal !!}</textarea>
                    </div>

                    <div class="col-2 text-end">
                        @if ($check_total_header_goal[0] == 0)
                            <button type="button" class="btn btn-primary comment_goal"
                                onclick="comment_goal({{ $data->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_goal"> Comment</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger comment_goal"
                                onclick="comment_goal({{ $data->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_goal"> View Comment</span>
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
                                    @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_goal k_comment_goal" rows="3" name="k_comment_goal" placeholder=""></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_goal"><i
                                                    class="fas fa-plus"></i> Add</button>
                                        @endif
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                                class="fas fa-times"></i> Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_targetdate" class="col-2 col-form-label"><b>Target Date</b></label>
                    <div class="col-8">
                        <input class="form-control" type="text" name="k_targetdate" id="k_targetdate" readonly=""
                            value="{{ date('d-M-Y', strtotime($data->k_targetdate)) }}" placeholder="Target Date">
                    </div>
                    <div class="col-2 text-end">
                        @if ($check_total_header_date[0] == 0)
                            <button type="button" class="btn btn-primary comment_date"
                                onclick="comment_date({{ $data->k_id }})">
                                <i class="ti-comment me-1"></i>
                                <span class="txt_date"> Comment</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-danger comment_date"
                                onclick="comment_date({{ $data->k_id }})">
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
                                    @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                        ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                        <div class="modal-body">
                                            <textarea class="form-control cmnt_remove_date k_comment_date" rows="3" name="k_comment_date" placeholder=""></textarea>
                                            <br>
                                        </div>
                                    @endif
                                    <div class="modal-footer">
                                        @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                            ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                        @else
                                            <button type="button" class="btn btn-default add_comment_date"><i
                                                    class="fas fa-plus"></i> Add</button>
                                        @endif
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                                class="fas fa-times"></i> Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="drop_here mb-3">
                    @foreach ($datad as $index => $element)
                        <input type="hidden" class="id_old" name="id_old[]" value="{{ $element->kd_id }}">
                        <input type="hidden" class="hit" value="0">
                        <input type="hidden" class="hit2" value="0">
                        <input type="hidden" class="hit3" value="0">
                        <input type="hidden" class="comment_hidden">
                        <input type="hidden" class="value_hidden">

                        <div class="card mb-3">
                            <div class="card-header" style="text-align:left;">
                                <h5 class="card-title d-flex justify-content-between w-full" style="font-size:30px">
                                    <b>Tactical Step {{ $index + 1 }}</b>
                                    {{-- Comment Tactical Step --}}
                                    @if ($check_total_cmnt[$index] == 0)
                                        <button type="button"
                                            class="btn btn-primary comment comment_review_{{ $element->kd_id }}"
                                            onclick="comment_review({{ $element->kd_id }})">
                                            <i class="ti-comment me-1"></i>
                                            <span class="txt_ts_{{ $element->kd_id }}"> Comment</span>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger comment"
                                            onclick="comment_review({{ $element->kd_id }})">
                                            <i class="ti-comment me-1"></i>
                                            <span class="txt_ts_{{ $element->kd_id }}"> View
                                                Comment</span>
                                        </button>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea class="form-control" name="kd_tacticalstep[]" rows="5"
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
                                            {{-- Jika kd due date lebih dari tanggal create, maka merah --}}
                                            @if ($element->kd_duedate < date('Y-m-d'))
                                                <label class="control-label">
                                                    <b>Due Date</b>
                                                </label>
                                                &nbsp;<i class="fas fa-times" title="Due Date Less Than Now"></i>
                                                <input type="text" name="kd_duedate[]"
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control merah"
                                                    style="pointer-events: none;background: lightgrey">
                                            @else
                                                <label class="control-label">
                                                    <b>Due Date</b>
                                                </label>
                                                <input type="text" name="kd_duedate[]"
                                                    style="pointer-events: none;background: lightgrey"
                                                    value="{{ date('d-M-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control">
                                            @endif
                                        </div>

                                        <div class="col-2">
                                            <label>
                                                <b>Result</b>
                                            </label>
                                            <input type="text" class="form-control"
                                                style="pointer-events: none;background: lightgrey" name="kd_result_id[]"
                                                placeholder="N/A">
                                        </div>
                                        <div class="col-4">
                                            <label class="control-label">
                                                <b>Status</b>
                                            </label>
                                            <input type="text" class="form-control"
                                                style="pointer-events: none;background: lightgrey" name="kd_status_id[]"
                                                placeholder="N/A">
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- END MODAL COMMENT --}}
                            <div class="col-md-4">
                                <div>
                                    <div id="modal_comment_{{ $element->kd_id }}" class="modal fade" tabindex="-1"
                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                                    ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                    ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                @else
                                                    <div class="modal-body">
                                                        <textarea class="form-control cmnt_remove kd_comment_{{ $element->kd_id }}" rows="3" name="kd_comment"
                                                            placeholder=""></textarea>
                                                        <br>
                                                    </div>
                                                @endif
                                                <div class="modal-footer">
                                                    @if (($data->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                                        ($data->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                        ($data->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                    @else
                                                        <button type="button" class="btn btn-default add_comment"
                                                            value="{{ $element->kd_id }}">
                                                            <i class="fas fa-plus"></i>
                                                            Add
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i>
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- MODAL COMMENT --}}
                    @endforeach

                    @if ($data->k_created_by == 26 || $data->k_created_by == 27)
                        <div class="card">
                            <div
                                class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                Manager Comment on Draft
                            </div>
                            <div class="card-body">
                                <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                    name="k_justification_manager[]">
                                    {!! $data->k_justification_manager !!}
                                </p>
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_reject_manager != null)
                                        Rejected Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                    @elseif ($data->k_approval_manager != null)
                                        Approved Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                    @else
                                        -
                                    @endif
                                </small>
                            </div>
                        </div>
                    @elseif ($data->k_created_by == 28 ||
                        $data->k_created_by == 34 ||
                        $data->k_created_by == 39 ||
                        $data->k_created_by == 53 ||
                        $data->k_created_by == 56)
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_lead != null) bg-danger @elseif ($data->k_approval_lead != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Lead Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_lead" rows="3" readonly=""
                                        name="k_justification_lead[]">
                                        {!! $data->k_justification_lead !!}
                                    </p>
                                </div>

                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_lead != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_lead)) }}
                                        @elseif ($data->k_approval_lead != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_lead)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="col card px-0 ms-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                        @elseif ($data->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Start Specialist Helpdesk --}}
                    @elseif ($data->k_created_by == 47 ||
                        $data->k_created_by == 48 ||
                        $data->k_created_by == 49 ||
                        $data->k_created_by == 50 ||
                        $data->k_created_by == 51 ||
                        $data->k_created_by == 52)
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_coor != null) bg-danger @elseif ($data->k_approval_coor != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Coordinator Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_coor" rows="3" readonly=""
                                        name="k_justification_coor[]">
                                        {!! $data->k_justification_coor !!}
                                    </p>
                                </div>

                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_coor != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_coor)) }}
                                        @elseif ($data->k_approval_coor != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_coor)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col card px-0 ms-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                        @elseif ($data->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        {{-- end Specialist Helpdesk --}}

                        {{-- Start Coor Specialist Helpdesk --}}
                    @elseif ($data->k_created_by == 46)
                        <div class="card">
                            <div
                                class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                Manager Comment on Draft
                            </div>
                            <div class="card-body">
                                <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                    name="k_justification_manager[]">
                                    {!! $data->k_justification_manager !!}
                                </p>
                            </div>
                            <div class="card-footer" style="background: lightgrey">
                                <small class="text-muted">
                                    @if ($data->k_reject_manager != null)
                                        Rejected Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                    @elseif ($data->k_approval_manager != null)
                                        Approved Date:
                                        {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                    @else
                                        -
                                    @endif
                                </small>
                            </div>
                        </div>
                        {{-- end Coor Specialist Helpdesk --}}

                        {{-- Start Specialist JGS --}}
                    @elseif ($data->k_created_by == 38 ||
                        $data->k_created_by == 43 ||
                        $data->k_created_by == 44 ||
                        $data->k_created_by == 45 ||
                        $data->k_created_by == 33 ||
                        $data->k_created_by == 66)
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_lead != null) bg-danger @elseif ($data->k_approval_lead != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Lead Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_lead" rows="3" readonly=""
                                        name="k_justification_lead[]">
                                        {!! $data->k_justification_lead !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_lead != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_lead)) }}
                                        @elseif ($data->k_approval_lead != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_lead)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col card px-0 ms-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                        @elseif ($data->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        {{-- end Specialist Asset JGS --}}
                    @else
                        <div class="row mx-1">
                            <div class="col card px-0 me-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_coor != null) bg-danger @elseif ($data->k_approval_coor != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Coordinator Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_coor" rows="3" readonly=""
                                        name="k_justification_coor[]">
                                        {!! $data->k_justification_coor !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_coor != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_coor)) }}
                                        @elseif ($data->k_approval_coor != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_coor)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col card px-0 mx-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_lead != null) bg-danger @elseif ($data->k_approval_lead != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Lead Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_lead" rows="3" readonly=""
                                        name="k_justification_lead[]">
                                        {!! $data->k_justification_lead !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_lead != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_lead)) }}
                                        @elseif ($data->k_approval_lead != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_lead)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col card px-0 ms-1">
                                <div
                                    class="card-header text-white @if ($data->k_reject_manager != null) bg-danger @elseif ($data->k_approval_manager != null) bg-success @else bg-secondary @endif font-weight-bold">
                                    Manager Comment on Draft
                                </div>
                                <div class="card-body">
                                    <p class="card-text" id="k_justification_manager" rows="3" readonly=""
                                        name="k_justification_manager[]">
                                        {!! $data->k_justification_manager !!}
                                    </p>
                                </div>
                                <div class="card-footer" style="background: lightgrey">
                                    <small class="text-muted">
                                        @if ($data->k_reject_manager != null)
                                            Rejected Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_reject_manager)) }}
                                        @elseif ($data->k_approval_manager != null)
                                            Approved Date:
                                            {{ date('d-M-Y H:i A', strtotime($data->k_approval_manager)) }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-4">
                        <div>
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="vertical-alignment-helper">
                                    <div class="modal-dialog vertical-align-center">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        Justification
                                                        <span style="color:red;font-weight:bold" class="important">
                                                            *</span>
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    @if (auth()->user()->m_flag == 1)
                                                        <textarea id="output" class="form-control k_justification k_justification_manager cmnt_remove" rows="3"
                                                            name="k_justification_manager" placeholder=""></textarea>
                                                    @elseif(auth()->user()->m_flag == 2)
                                                        <textarea class="form-control k_justification k_justification_lead cmnt_remove" rows="3"
                                                            name="k_justification_lead" placeholder=""></textarea>
                                                    @elseif(auth()->user()->m_flag == 3)
                                                        <textarea id="canceled" class="form-control k_justification k_justification_coor cmnt_remove" rows="3"
                                                            name="k_justification_coor" placeholder=""></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
    <script>
        $(function() {
            tinymce.init({
                selector: 'textarea#mymce',
                height: 150,
                toolbar: 'mybutton',
                menubar: false,
                plugins: "legacyoutput",
                readonly: 1,
            });
            tinymce.activeEditor.setMode('readonly');
        })

        if (('{{ Auth::user()->m_flag }}') == 1) {
            $id = 1;
        }else if (('{{ Auth::user()->m_flag }}') == 2) {
            $id = 16;
        }else if (('{{ Auth::user()->m_flag }}') == 3) {
            $id = 13;
        }else if (('{{ Auth::user()->m_flag }}') == 4) {
            $id = 11;
        }

        if (('{{ Auth::user()->m_flag }}') == 1) {
            $id_reject = 18;
        }else if (('{{ Auth::user()->m_flag }}') == 2) {
            $id_reject = 15;
        }else if (('{{ Auth::user()->m_flag }}') == 3) {
            $id_reject = 12;
        }

        function comment_kra() {
            var id_hidden = $('.hidden_id_header').val();
            $('.k_comment_kra').val('');
            $('.append_comment_kra').empty();
            $('.append_comment_kra').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/show_comment_kra',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        console.log(response);

                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            console.log(response.data_cm[key - 1].kch_comment);
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_kra').append(
                                '<tr><td class="append_text_kra"></td><td>' + response.data_cm[key -
                                    1].m_username + '</td><td>' + ([d] + "-" + monthMap[M] + "-" +
                                    y + "  " + [H] + ":" + [m]) + '</td></tr>');
                            $('.append_text_kra').last().text(response.data_cm[key - 1].kch_comment);
                            key++;
                        });
                        $('#comment_kra').modal('show');
                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function comment_goal() {
            var id_hidden = $('.hidden_id_header').val();
            $('.k_comment_goal').val('');
            $('.append_comment_goal').empty();
            $('.append_comment_goal').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/show_comment_goal',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        console.log(response);
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            console.log(response.data_cm[key - 1].kch_comment);
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_goal').append(
                                '<tr><td class="append_text_goal"></td><td>' + response.data_cm[
                                    key - 1].m_username + '</td><td>' + ([d] + "-" + monthMap[M] +
                                    "-" + y + "  " + [H] + ":" + [m]) + '</td></tr>');
                            $('.append_text_goal').last().text(response.data_cm[key - 1].kch_comment);
                            key++;
                        });
                        $('#comment_goal').modal('show');
                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function comment_date() {
            var id_hidden = $('.hidden_id_header').val();
            $('.k_comment_date').val('');
            $('.append_comment_date').empty();
            $('.append_comment_date').append(
                '<tr><th><center><b>Comment</b></center></th><th><center><b>Created By</b></center></th><th width="23%"><center><b>Create Date</b></center></th></tr>'
            );

            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/show_comment_date',
                data: '&k_id=' + id_hidden,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'sukses') {
                        console.log(response);
                        var key = 1;
                        Object.keys(response.data_cm).forEach(function() {
                            console.log(response.data_cm[key - 1].kch_comment);
                            var formattedDate = new Date(response.data_cm[key - 1].kch_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug..",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            var y = formattedDate.getFullYear();
                            var H = formattedDate.getHours();
                            var m = formattedDate.getMinutes();
                            $('.append_comment_date').append(
                                '<tr><td class="append_text_date"></td><td>' + response.data_cm[
                                    key - 1].m_username + '</td><td>' + ([d] + "-" + monthMap[M] +
                                    "-" + y + "  " + [H] + ":" + [m]) + '</td></tr>');
                            $('.append_text_date').last().text(response.data_cm[key - 1].kch_comment);
                            key++;
                        });
                        $('#comment_date').modal('show');
                    } else if (response.status == 'ada') {
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
                        message: response.message,
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
                            $('.append_data_' + argument).append('<tr><td class="append_text_' +
                                argument + '"></td><td>' + response.data_cm[key - 1].m_username +
                                '</td><td>' + ([d] + "-" + monthMap[M] + "-" + y + "  " + [H] +
                                    ":" + [m]) + '</td></tr>');
                            $('.append_text_' + argument).last().text(response.data_cm[key - 1]
                                .kc_comment);

                            key++;
                        });
                        $('#modal_comment_' + argument).modal('show');
                    } else if (response.status == 'ada') {
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
                        message: response.message,
                    });
                }
            });
        }

        function save() {
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#myModal').modal('show');
            $('.cmnt_remove').val('');

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
                        '<button style="background-color:#17a991;color:white;">Approve</button>',

                        function(instance, toast) {
                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', $id);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $('#myModal').modal('show');
                            $Justification = $('.k_justification').val();
                            if ($Justification == null || $Justification == '') {
                                iziToast.warning({
                                    icon: 'fa fa-info',
                                    position: 'center',
                                    title: 'Warning!',
                                    message: 'Justification required!',
                                });
                                $('.k_justification').focus();
                                $('#myModal' + $(this).data('id')).modal('toggle');
                                return false;
                            }

                            $('#myModal').modal('hide');

                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_all_approval_save') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'KPI has been approve',
                                        });

                                        location.href = '{{ route('assessment_all_approval') }}'
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
                        '<button onclick="canceled()" style="background-color:#d83939;color:white;">Cancel</button>',
                        function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ]
                ]
            });
        }

        function reject() {
            $('.cmnt_remove').val('');
            $('#myModal').modal('show');

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
                        '<button style="background-color:#d83939;color:white;">Reject</button>',
                        function(instance, toast) {
                            $Justification = $('.k_justification').val();
                            if ($Justification == null || $Justification == '') {
                                iziToast.warning({
                                    icon: 'fa fa-info',
                                    position: 'center',
                                    title: 'Warning!',
                                    message: 'Justification required!',
                                });
                                $('.k_justification').focus();
                                return false;
                            }

                            var form = $('#save');
                            formdata = new FormData(form[0]);
                            formdata.append('k_status_id', $id_reject);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: '{{ route('assessment_all_approval_reject_kpi') }}',
                                data: formdata ? formdata : form.serialize(),
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if (data.status == 'sukses') {
                                        iziToast.success({
                                            icon: 'fa fa-save',
                                            position: 'center',
                                            title: 'Success!',
                                            message: 'KPI has been rejected!',
                                        });
                                        location.href = '{{ route('assessment_all_approval') }}'
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
                        '<button onclick="canceled()" style="background-color:#17a991;color:white;">Cancel</button>',
                        function(instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                        }
                    ]
                ]
            });
        }

        function canceled() {
            $('#myModal').modal('hide');
        }

        $('.add_comment').click(function(argument) {
            $refid = $(this).val();
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
            var form = $('#save');
            formdata = new FormData(form[0]);
            formdata.append('kd_ref_id', $refid);
            formdata.append('kd_comment', $cmmnt);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/save_comment',
                data: formdata ? formdata : form.serialize(),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);
                        $('.append_data_' + $refid).append('<tr><td class="append_text_' + $refid +
                            '"></td><td>' + data.created_by + '</td><td>' + data.date + '</td></tr>'
                        );
                        $('.append_text_' + $refid).last().text(data.comment);
                        $('.cmnt_remove').val(' ');
                        $('.comment_review').removeClass('btn-danger');
                        $('.comment_review_' + $refid).removeClass('btn-info');
                        $('.comment_review_' + $refid).addClass('btn-danger');
                        $('.txt_ts_' + $refid).text(' View Comment');

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
        })

        $('.add_comment_kra').click(function() {
            var id_hidden = $('.hidden_id_header').val();
            $cmnt_kra = $('.k_comment_kra').val();
            if ($cmnt_kra == '') {
                iziToast.warning({
                    icon: 'fa fa-info',
                    position: 'center',
                    DisplayMode: 'once',
                    title: 'Warning!',
                    message: 'Comment required! 1',
                });
                return false;
            }
            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_all_approval/save_comment_kra',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_kra,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);

                        $('.append_comment_kra').append('<tr><td class="append_text_kra"></td><td>' +
                            data.created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.append_text_kra').last().text(data.comment);
                        $('.cmnt_remove_kra').val(' ');
                        $('.comment_kra').removeClass('btn-danger');
                        $('.comment_kra').removeClass('btn-info');
                        $('.comment_kra').addClass('btn-danger');
                        $('.txt_kra').text(' View Comment');

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
        })

        $('.add_comment_goal').click(function() {
            var id_hidden = $('.hidden_id_header').val();
            $('.append_text').text(' ');
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
                url: baseUrl + '/' + 'assessment/assessment_all_approval/save_comment_goal',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_goal + '&k_comment_g=' + $cmnt_goal,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);

                        $('.append_comment_goal').append('<tr><td class="append_text_goal"></td><td>' +
                            data.created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.append_text_goal').last().text(data.comment);
                        $('.cmnt_remove_goal').val(' ');
                        $('.comment_goal').removeClass('btn-danger');
                        $('.comment_goal').removeClass('btn-info');
                        $('.comment_goal').addClass('btn-danger');
                        $('.txt_goal').text('  View Comment');

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
        })

        $('.add_comment_date').click(function() {
            var id_hidden = $('.hidden_id_header').val();
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
                url: baseUrl + '/' + 'assessment/assessment_all_approval/save_comment_date',
                data: '&k_id=' + id_hidden + '&k_comment=' + $cmnt_date,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        console.log(data);
                        $('.append_comment_date').append('<tr><td class="append_text_date"></td><td>' +
                            data.created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.append_text_date').last().text(data.comment);
                        $('.cmnt_remove_date').val(' ');
                        $('.comment_date').removeClass('btn-danger');
                        $('.comment_date').removeClass('btn-info');
                        $('.comment_date').addClass('btn-danger');
                        $('.txt_date').text('  View Comment');

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
        })
    </script>
@endpush
