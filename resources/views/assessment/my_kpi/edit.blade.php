@extends('master')

@push('title')
Edit My KPI
@endpush

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
<style>
    #sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #sortable li {
        margin: 0 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
    }

    html>body #sortable li {
        line-height: 1.2em;
    }

    .ui-state-highlight {
        line-height: 1.2em;
    }
</style>
@endpush

@push('top-buttons')
@if ($data_edit->k_status_id == 1)
@else
<div class="d-flex justify-content-end">
    <button class="btn btn-warning me-2" type="button" onclick="draft()">
        <i class="ti-save me-1"></i>
        Save
    </button>
    <button class="btn btn-success me-2" type="button" onclick="update()">
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
@endif
@endpush

@section('content')
<div class="card">
    <form id="save" class="card-body">
            <input type="hidden" name="hidden_id_header" id="hidden_id_header" value="{{ $data_edit->k_id }}">

            <div class="form-group row mb-3">
                <label for="k_label" class="col-2 col-form-label"><b>Collaboration</b></label>
                <div class="col-10 align-self-center">
                    <div class="form-check form-check-inline mb-0">
                        @if ($data_edit->k_collab_assets == 'ya')
                        <input type="checkbox" class="form-check-input" name="k_collab_assets"
                            value="{{ $data_edit->k_collab_assets }}" checked="">
                        <label class="form-check-label" for="k_collab_assets">IT Asset</label>
                        @else
                        <input class="form-check-input" name="k_collab_assets" type="checkbox" id="k_collab_assets"
                            value="ya">
                        <label class="form-check-label" for="k_collab_assets">IT Asset</label>
                        @endif
                    </div>

                    <div class="form-check form-check-inline">
                        @if ($data_edit->k_collab_helpdesk == 'ya')
                        <input type="checkbox" class="form-check-input" name="k_collab_helpdesk"
                            value="{{ $data_edit->k_collab_helpdesk }}" checked="">
                        <label class="form-check-label" for="k_collab_helpdesk">IT Helpdesk</label>
                        @else
                        <input class="form-check-input" name="k_collab_helpdesk" type="checkbox" id="k_collab_helpdesk"
                            value="ya">
                        <label class="form-check-label" for="k_collab_helpdesk">IT Helpdesk</label>
                        @endif
                    </div>

                    <div class="form-check form-check-inline">
                        @if ($data_edit->k_collab_support == 'ya')
                        <input type="checkbox" class="form-check-input" name="k_collab_support"
                            value="{{ $data_edit->k_collab_support }}" checked="">
                        <label class="form-check-label" for="k_collab_support">IT Support</label>
                        @else
                        <input class="form-check-input" name="k_collab_support" type="checkbox" id="k_collab_support"
                            value="ya">
                        <label class="form-check-label" for="k_collab_support">IT Support</label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="k_label" class="col-2 col-form-label"><b>Key Result Area</b><span
                        style="color:red;font-weight:bold" class="important"> *</span></label>
                <div class="col-8">
                    <input class="form-control" type="text" name="k_label" id="k_label"
                        value="{{ $data_edit->k_label }}" placeholder="Key Result Area">
                </div>
                <div class="col-2 text-end" style="padding-right: 0px;margin-left: -23px;">
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
            <input class="form-control" type="hidden" name="k_collaboration" id="k_collaboration"
                value="{{ $data_edit->k_collaboration }}">

            {{-- modal kra --}}
            <div class="col-md-4">
                    <div id="comment_kra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Comment</h4>
                                </div>
                                <table class="append_comment_kra table table-bordered table-stripped"
                                    required="required">
                                    <tr>
                                        <th>Comment</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                    </tr>
                                </table>
                                @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                @else
                                <div class="modal-body">
                                    <textarea class="form-control cmnt_remove_kra k_comment_kra" rows="3"
                                        name="k_comment_kra" placeholder="Text Here..."></textarea>
                                    <br>
                                </div>
                                @endif
                                <div class="modal-footer">
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                    <button type="button" class="btn btn-default add_comment_kra"
                                        onclick="add_comment_kra()"><i class="ti-plus me-1"></i>
                                        Add</button>
                                    @endif
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                            class="ti-close me-1"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            {{-- end of modal kra --}}

            <div class="form-group row mb-3">
                <label for="k_goal" class="col-2 col-form-label"><b>Goal</b><span style="color:red;font-weight:bold"
                        class="important"> *</span></label>
                <div class="col-8">
                    <textarea class="form-control mymce" type="text" name="k_goal" id="mymce"
                        placeholder="Goal (WHAT)">{!! $data_edit->k_goal !!}</textarea>

                </div>
                <div class="col-2 text-end" style="padding-right: 0px;margin-left: -23px;">
                    @if ($check_total_header_goal[0] == 0)
                    <button type="button" class="btn btn-info comment_goal"
                        onclick="comment_goal({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                            class="txt_goal"> Comment
                        </span></button>
                    @else
                    <button type="button" class="btn btn-danger comment_goal"
                        onclick="comment_goal({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                            class="txt_goal"> View Comment
                        </span></button>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div>
                    <div id="comment_goal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Comment</h4>
                                </div>
                                <table class="append_comment_goal table table-bordered table-stripped">
                                    <tr>
                                        <th>Comment</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                    </tr>
                                </table>
                                @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                @else
                                <div class="modal-body">
                                    <textarea class="form-control cmnt_remove_goal k_comment_goal" rows="3"
                                        name="k_comment_goal" placeholder="Text Here..."></textarea>
                                    <br>
                                </div>
                                @endif
                                <div class="modal-footer">
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                    <button type="button" class="btn btn-default add_comment_goal"
                                        onclick="add_comment_goal()"><i class="ti-plus me-1"></i>
                                        Add</button>
                                    @endif
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                            class="ti-close me-1"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="k_targetdate" class="col-2 col-form-label"><b>Target Date</b><span
                        style="color:red;font-weight:bold" class="important"> *</span></label>
                <div class="col-8">
                    <input class="form-control datepicker-autoclose_hd " type="text" name="k_targetdate"
                        id="k_targetdate" value="{{ date('d-F-Y', strtotime($data_edit->k_targetdate)) }}"
                        placeholder="Target Date">
                </div>
                <div class="col-2 text-end" style="padding-right: 0px;margin-left: -23px;">
                    @if ($check_total_header_date[0] == 0)
                    <button type="button" class="btn btn-info comment_date"
                        onclick="comment_date({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                            class="txt_date"> Comment
                        </span></button>
                    @else
                    <button type="button" class="btn btn-danger comment_date"
                        onclick="comment_date({{ $data_edit->k_id }})"><i class="ti-comment me-1"></i><span
                            class="txt_date"> View Comment
                        </span></button>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div>
                    <div id="comment_date" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Comment</h4>
                                </div>
                                <table class="append_comment_date table table-bordered table-stripped">
                                    <tr>
                                        <th>Comment</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                    </tr>
                                </table>
                                @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                @else
                                <div class="modal-body">
                                    <textarea class="form-control cmnt_remove_date k_comment_date" rows="3"
                                        name="k_comment_date" placeholder="Text Here..."></textarea>
                                    <br>
                                </div>
                                @endif
                                <div class="modal-footer">
                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                    ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                    @else
                                    <button type="button" class="btn btn-default add_comment_date"
                                        onclick="add_comment_date()"><i class="ti-plus me-1"></i>
                                        Add</button>
                                    @endif
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                            class="ti-close me-1"></i> Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="drop_here_delete">
                <div class="drop_here">
                    @foreach ($data as $index => $element)
                    <div class="card gg mb-3">
                        <div class="card-header" style="font-size: 30px;">
                            <b class='fz_18'>Tactical Step {{ $index + 1 }}</b>
                            <div class="ms-auto">
                                <div class="dropdown d-inline-block cc">
                                    @if ($check_total_cmnt[$index] == 0)
                                    <button class="btn btn-danger btnRemove" type="button" value="Remove"><i
                                            class="ti-trash me-1"></i>
                                        Remove
                                    </button>

                                    <div class="btn btn-info comment" onclick="comment_review({{ $element->kd_id }})"><i
                                            class="ti-comment me-1"></i>
                                        Comment
                                    </div>
                                    @else
                                    @if ($data_edit->k_status_id == 1)
                                    @else
                                    <button class="btn btn-danger btnRemove" type="button" value="Remove"><i
                                            class="ti-trash me-1"></i>
                                        Remove
                                    </button>
                                    <div class="btn btn-danger comment" onclick="comment_review({{ $element->kd_id }})">
                                        <i class="ti-comment me-1"></i>
                                        View Comment
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div clas='col-sm-12'>
                            <div class='form-group'>
                                <input type="hidden" value="1" class="key_k">
                                <input type="hidden" class="id_old" name="id_old[]" value="{{ $element->kd_id }}">
                                </label>
                                <div class='col-12 p-2'>
                                    <div class="form-group mb-3">
                                        <textarea class="form-control" rows="3" name="kd_tacticalstep_old[]"
                                            placeholder="Text Here...">{{ $element->kd_tacticalstep }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="control-label"><b>Measured By</b></label>
                                            <select class="form-control form-select" name="kd_measure_id_old[]">
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

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label"><b>Due Date</b></label>
                                                <input type="text" name="kd_duedate_old[]"
                                                    data-dateold="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}"
                                                    value="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}"
                                                    id="firstName" class="form-control datepicker-autoclose_hd date_req"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label"><b>Result</b></label>
                                                <input type="text" name="kd_result_id_old[]" readonly="" value="N/A"
                                                    class="result form-control" placeholder="Result">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group has-danger">
                                                <label class="control-label"><b>Status</b></label>
                                                <input type="text" name="kd_status_id_old[]" readonly="" id="status"
                                                    class="form-control form-control-danger" value="N/A" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <div id="modal_comment_{{ $element->kd_id }}" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Comment</h4>
                                                        </div>
                                                        <table
                                                            class="append_data_{{ $element->kd_id }} table table-bordered table-stripped">
                                                            <tr>
                                                                <th>Comment</th>
                                                                <th>Created By</th>
                                                                <th>Created Date</th>
                                                            </tr>
                                                        </table>
                                                        @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag ==
                                                        3) ||
                                                        ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3)
                                                        ||
                                                        ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                        @else
                                                        <div class="modal-body">
                                                            <textarea
                                                                class="form-control cmnt_remove kd_comment_{{ $element->kd_id }}"
                                                                rows="3" name="kd_comment"
                                                                placeholder="Text Here..."></textarea>
                                                            <br>
                                                        </div>
                                                        @endif
                                                        <div class="modal-footer">
                                                            @if (($data_edit->k_status_id == 13 &&
                                                            auth()->user()->m_flag == 3) ||
                                                            ($data_edit->k_status_id == 11 && auth()->user()->m_flag ==
                                                            3) ||
                                                            ($data_edit->k_status_id == 16 && auth()->user()->m_flag ==
                                                            3))
                                                            @else
                                                            <button type="button" class="btn btn-default add_comment"
                                                                value="{{ $element->kd_id }}"
                                                                onclick="add_comment_coeg(this)">
                                                                <i class="ti-plus me-1"></i>
                                                                Add
                                                            </button>
                                                            @endif
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">
                                                                <i class="ti-close me-1"></i>
                                                                Close
                                                            </button>
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
                    @endforeach
                </div>
            </div> --}}
            <br>
            <ul class="drop_here" id="sortable">
                @foreach ($data as $index => $element)
                <li class="card text-left gg mb-3 ui-state-default bg-white">
                    <div class="card-header" style="font-size: 30px;">
                        <b class='fz_18'>Tactical Step {{ $index + 1 }}</b>
                        <div class="ms-auto">
                            <div class="dropdown d-inline-block cc">
                                @if ($check_total_cmnt[$index] == 0)
                                <button class="btn btn-danger btnRemove" type="button" value="Remove"><i
                                        class="ti-trash me-1"></i>
                                    Remove
                                </button>

                                <div class="btn btn-info comment" onclick="comment_review({{ $element->kd_id }})"><i
                                        class="ti-comment me-1"></i>
                                    Comment
                                </div>
                                @else
                                @if ($data_edit->k_status_id == 1)
                                @else
                                <button class="btn btn-danger btnRemove" type="button" value="Remove"><i
                                        class="ti-trash me-1"></i>
                                    Remove
                                </button>
                                <div class="btn btn-danger comment" onclick="comment_review({{ $element->kd_id }})"><i
                                        class="ti-comment me-1"></i>
                                    View Comment
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div clas='col-sm-12'>
                        <div class='form-group'>
                            <input type="hidden" value="1" class="key_k">
                            <input type="hidden" class="id_old" name="id_old[]" value="{{ $element->kd_id }}">
                            </label>
                            <div class='col-12 p-2'>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" rows="3" name="kd_tacticalstep_old[]"
                                        placeholder="Text Here...">{{ $element->kd_tacticalstep }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <label class="control-label"><b>Measured By</b></label>
                                        <select class="form-control form-select" name="kd_measure_id_old[]">
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

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"><b>Due Date</b></label>
                                            <input type="text" name="kd_duedate_old[]"
                                                data-dateold="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}"
                                                value="{{ date('d-F-Y', strtotime($element->kd_duedate)) }}" id="firstName"
                                                class="form-control datepicker-autoclose_hd date_req" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label"><b>Result</b></label>
                                            <input type="text" name="kd_result_id_old[]" readonly="" value="N/A"
                                                class="result form-control" placeholder="Result">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-danger">
                                            <label class="control-label"><b>Status</b></label>
                                            <input type="text" name="kd_status_id_old[]" readonly="" id="status"
                                                class="form-control form-control-danger" value="N/A" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <div id="modal_comment_{{ $element->kd_id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            Comment</h4>
                                                    </div>
                                                    <table
                                                        class="append_data_{{ $element->kd_id }} table table-bordered table-stripped">
                                                        <tr>
                                                            <th>Comment</th>
                                                            <th>Created By</th>
                                                            <th>Created Date</th>
                                                        </tr>
                                                    </table>
                                                    @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3) ||
                                                    ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                    ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                    @else
                                                    <div class="modal-body">
                                                        <textarea
                                                            class="form-control cmnt_remove kd_comment_{{ $element->kd_id }}"
                                                            rows="3" name="kd_comment"
                                                            placeholder="Text Here..."></textarea>
                                                        <br>
                                                    </div>
                                                    @endif
                                                    <div class="modal-footer">
                                                        @if (($data_edit->k_status_id == 13 && auth()->user()->m_flag == 3)
                                                        ||
                                                        ($data_edit->k_status_id == 11 && auth()->user()->m_flag == 3) ||
                                                        ($data_edit->k_status_id == 16 && auth()->user()->m_flag == 3))
                                                        @else
                                                        <button type="button" class="btn btn-default add_comment"
                                                            value="{{ $element->kd_id }}" onclick="add_comment_coeg(this)">
                                                            <i class="ti-plus me-1"></i>
                                                            Add
                                                        </button>
                                                        @endif
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">
                                                            <i class="ti-close me-1"></i>
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    var id_hidden = $('#hidden_id_header').val();
    // Tactical Step new
    $(document).ready(function() {
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
                                <div class="dropdown d-inline-block cc">
                                    <button class="btn btn-danger btnRemove" type="button" value="Remove"><i
                                        class="ti-trash me-1"></i>
                                    Remove
                                </button>
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

                $('.date_req').change(function(argument) {
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
                })

                $('.btnRemove').on('click', function() {
                    var parents = $(this).parents('.gg').remove();
                    var nilai = 0;
                    $('.key_k').each(function(index) {
                        var textBoxVal = parseInt($(this).parents('.gg').find('.key_k')
                        .val());
                        nilai += textBoxVal;
                        $(this).parents('.gg').find('.fz_18').text("Tactical Step " +
                        nilai);
                    });
                    var key_rep = nilai + 1;
                });

                var nilai = 0;
                $('.key_k').each(function(index) {
                    var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
                    nilai += textBoxVal;
                    $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
                });
                var key_rep = nilai + 1;
                key++;
            }); // end click
            $( "#sortable" ).sortable({
                placeholder: "ui-state-highlight",
                update: function () {
                    $('.fz_18').each(function(index) {
                        $(this).text('Tactical Step ' + (index+1));
                    });
                },
            });
            $( "#sortable" ).disableSelection();
        }); // end ready  

        $(function() {
            tinymce.init({
                selector: "textarea#mymce",
                entity_encoding: "raw",
                apply_source_formatting: false,
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
                    "save table contextmenu directionality emoticons template paste textcolor charactercount",
                    "legacyoutput"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor | sizeselect | bold italic | fontselect |  fontsizeselect ",
            });

            $(".datepicker-autoclose_hd").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd-MM-yyyy',

            })
            $('.datepicker-autoclose_hd').change(function(argument) {
                var today = new Date();
                var todayString = moment(today).format("YYYY-MM-DD");
                var valdate = moment($(this).val()).format("YYYY-MM-DD");

                if (valdate < todayString) {
                    iziToast.warning({
                        icon: 'fa fa-info',
                        displayMode: 'once',
                        position: 'center',
                        title: 'Warning!',
                        message: 'target date less than date now',
                    });
                    $(this).val('.datepicker-autoclose_hd').val('');
                }
            })
            $('.date_req').change(function(argument) {
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
            })
        })

        function draft() {
            if (('{{ auth()->user()->m_flag }}') == 1) {
                $id_draft = 6;
            }else if (('{{ auth()->user()->m_flag }}') == 2) {
                $id_draft = 5;
            }else if (('{{ auth()->user()->m_flag }}') == 3) {
                $id_draft = 4;
            }else if (('{{ auth()->user()->m_flag }}') == 4) {
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
                message: 'Are you sure?',
                position: 'center',
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button style="background-color:#17a991;color:white;">Save</button>',
                        function(instance, toast) {
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
                                url: '{{ route('assessment_kpi_update') }}',
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

        function update() {
            if (('{{ auth()->user()->m_flag }}') == 1) {
                $id = 1;
            }else if (('{{ auth()->user()->m_flag }}') == 2) {
                $id = 16;
            }else if (('{{ auth()->user()->m_flag }}') == 3) {
                $id = 13;
            }else if (('{{ auth()->user()->m_flag }}') == 4) {
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
                message: 'Are you sure?',
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
                                url: '{{ route('assessment_kpi_update') }}',
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

        // var key = 1;
        // $('.btnAdd').click(function() {
        //     $('.drop_here').append(
        //         `
        //         <div class="card text-left gg mb-3">
        //             <input type="hidden" value="1" class="key_k">
        //             <div class="card-header" style="font-size: 30px;">
        //                 <b class="fz_18">Tactical Step ${key}</b><span style="color:red;font-weight:bold"
        //                     class="important"> *</span>
        //                 <div class="ms-auto">
        //                     <div class="dropdown d-inline-block">
        //                         <div class="text-right"><input type="button" class="btn btn-danger btnRemove" value="Remove">
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>
        //             <div class="card-body">
        //                 <div class="form-group mb-3">
        //                     <textarea class="form-control rounded-0" rows="3" name="kd_tacticalstep[]" class="kd_tacticalstep"
        //                         placeholder="Describe Your Tactical Step"></textarea>
        //                 </div>
        //                 <div class="row">
        //                     <div class="form-group col-md-3">
        //                         <label for="input">Measured By<span style="color:red;font-weight:bold" class="important">
        //                                 *</span></label>
        //                         <select class="form-control form-select kd_measure_id" name="kd_measure_id[]"
        //                             >
        //                             @foreach ($measure as $element)
        //                                 <option value="{{ $element->dm_id }}">{{ $element->dm_name }}</option>
        //                             @endforeach
        //                         </select>
        //                     </div>
        //                     <div class="form-group col-md-3">
        //                         <label for="inputZip">Due Date<span style="color:red;font-weight:bold" class="important">
        //                                 *</span></label>
        //                         <input id="kd_duedate_${key}" type="text" name="kd_duedate[]"
        //                             data-key="${key}"
        //                             class="form-control date_req datepicker-autoclose_dt date_${key}"
        //                             placeholder="Format date dd-mmm-yyyy">
        //                         <input type="hidden" name="kd_duedate_dt[]"
        //                             class="form-control date_req_dt_${key} datepicker-autoclose_dt date_${key}"
        //                             placeholder="">
        //                     </div>
        //                     <div class="form-group col-md-2">
        //                         <label for="inputZip">Result</label>
        //                         <input type="text" name="kd_result_id[]" readonly class="form-control" placeholder="N/A">
        //                     </div>
        //                     <div class="form-group col-md-4">
        //                         <label for="inputZip">Status</label>
        //                         <input type="text" name="kd_status_id[]" readonly class="form-control form-control-danger"
        //                             value="N/A" placeholder="">
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>
        //         `
        //     );
        //     jQuery('.datepicker-autoclose_dt').datepicker({
        //         format: 'dd-MM-yyyy',
        //         autoclose: true,
        //         todayHighlight: true,
        //         onSelect: function(dateText) {
        //             $(this).change();
        //         }
        //     }).on("change", function() {

        //     });

        //     $('.date_req').change(function(argument) {
        //         var k_targetdates = $('#k_targetdate').val();
        //         var valdate = $(this).parents('.gg').find('.date_req').val();
        //         var this_date = moment(valdate).format("YYYY-MM-DD");
        //         var k_targetdate = moment(k_targetdates).format("YYYY-MM-DD");
        //         if (k_targetdate == '') {
        //             iziToast.warning({
        //                 icon: 'fa fa-info',
        //                 displayMode: 'once',
        //                 position: 'center',
        //                 title: 'Warning!',
        //                 message: 'Target Date Empty',
        //             });
        //             $('#k_targetdate').focus();
        //             $(this).parents('.gg').find('.date_req').val('');
        //         } else if (this_date > k_targetdate) {
        //             iziToast.warning({
        //                 icon: 'fa fa-info',
        //                 displayMode: 'once',
        //                 position: 'center',
        //                 title: 'Warning!',
        //                 message: 'Due Date more than target date',
        //             });
        //             $(this).parents('.gg').find('.date_req').val('');
        //         }
        //     })

        //     $('.btnRemove').on('click', function() {
        //         var parents = $(this).parents('.gg').remove();
        //         var nilai = 0;
        //         $('.key_k').each(function(index) {
        //             var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
        //             nilai += textBoxVal;
        //             $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
        //         });
        //     });
        //     var nilai = 0;
        //     $('.key_k').each(function(index) {
        //         var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
        //         nilai += textBoxVal;
        //         $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
        //     });
        //     key++;
        // }); // end click                                            

        $('.btnRemove').on('click', function() {
            var id_old = $(this).parents('.gg').find('.id_old').val();
            var parents = $(this).parents('.gg').remove();
            var nilai = 0;
            $('.key_k').each(function(index) {
                var textBoxVal = parseInt($(this).parents('.gg').find('.key_k').val());
                nilai += textBoxVal;
                $(this).parents('.gg').find('.fz_18').text("Tactical Step " + nilai);
            });
            $('.drop_here_delete').append('<input type="hidden" value="' + id_old + '" name="id_remove[]">');
        });

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
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
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
                        $('.append_comment_kra').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_kra').val(' ');
                        $('.comment_kra').removeClass('btn-danger');
                        $('.comment_kra').removeClass('btn-info');
                        $('.comment_kra').addClass('btn-danger');
                        $('.txt_kra').text('  View Comment');
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
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
                                "Sept", "Oct", "Nov", "Dec"
                            ];
                            M += 1; // JavaScript months are 0-11
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
                        $('.append_comment_goal').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_goal').val(' ');
                        $('.comment_goal').removeClass('btn-danger');
                        $('.comment_goal').removeClass('btn-info');
                        $('.comment_goal').addClass('btn-danger');
                        $('.txt_goal').text('  View Comment');

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
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
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
                        $('.append_comment_date').append('<tr><td>' + data.comment + '</td><td>' + data
                            .created_by + '</td><td>' + data.date + '</td></tr>');
                        $('.cmnt_remove_date').val(' ');
                        $('.comment_date').removeClass('btn-danger');
                        $('.comment_date').removeClass('btn-info');
                        $('.comment_date').addClass('btn-danger');
                        $('.txt_date').text('  View Comment');

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
                            var formattedDate = new Date(response.data_cm[key - 1].kc_created_at);
                            var d = formattedDate.getDate();
                            var M = formattedDate.getMonth();
                            var monthMap = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
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
            $.ajax({
                type: "get",
                url: baseUrl + '/' + 'assessment/assessment_kpi/save_comment',
                data: $('#save').serialize() + '&kd_ref_id=' + $refid + '&kd_comment=' + $cmmnt,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'sukses') {
                        $('.append_data_' + $refid).append('<tr><td>' + data.comment + '</td><td>' +
                            data.created_by + '</td><td>' + data.date + '</td></tr>');
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
        })
</script>
@endpush