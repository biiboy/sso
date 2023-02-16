@extends('master')

@push('title')
    View Target KPI
@endpush

@push('top-buttons')
    @if ($data->kpdf_status_id == 22)
        <div class="d-flex justify-content-end">
            <a class="btn btn-warning" href="{{ route('assessment_target_edit', ['id' => $data->kpdf_id]) }}">
                <i class="ti-pencil-alt me-1"></i>
                Edit
            </a>
        </div>
    @endif
@endpush

@section('content')
    <div class="card">
        <form id="save">
            <div class="card-body"><br>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Period</b>
                    </label>
                    <div class="col-10">
                        <select class="form-control form-select year" name="year"
                            style="pointer-events: none;background: lightgrey">
                            <option value="">Select Period</option>
                            @foreach ($year as $element)
                                <option for="year" @if ($element->p_year == $data->kpdf_period) selected="" @endif
                                    value="{{ $element->p_year }}">
                                    {{ $element->p_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>

                <input type="hidden" name="id" value="{{ $data->kpdf_id }}">

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Status</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            style="pointer-events: none;background: lightgrey"
                            @if ($data->kpdf_status_id == 22) value="Draft"
                                            @else
                                                value="Publish" @endif>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Title</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            value="{{ $data->kpdf_title }}" style="pointer-events: none;background: lightgrey">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label">
                        <b>Description</b>
                    </label>
                    <div class="col-10">
                        <textarea class="form-control mymce" type="text" name="kpdf_dec" id="mymce" rows="5"
                            style="pointer-events: none;background: lightgrey">{{ $data->kpdf_dec }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="k_targetdate" class="col-2 col-form-label "><b>Upload File</b></label>
                    <div class="col-8">
                        <div class="row form-group preview_div">
                            <div class="col-12">
                                <div class="file-upload upl_1">
                                    <div class="file-select">
                                        <div class="file-select-button fileName">File</div>

                                        <div class="file-select-name noFile tag_image_1">{{ $data->kpdf_file }}
                                        </div>

                                        <input type="hidden" class="noFile_val file_check">
                                        <input type="hidden" name="file_upload_value" class="file_upload_value"
                                            value="">
                                        <input type="hidden" name="file_upload_value_index" class="file_upload_value_index"
                                            value="">
                                        <input type="file" class="chooseFile" value="{{ $data->kpdf_file }}"
                                            name="file" style="pointer-events: none;background: lightgrey">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <a class="btn btn-primary" href="{{ Storage::url($data->kpdf_file) }}" target="_blank"
                            Style="width: 178px;">
                            <i class="ti-eye me-1"></i>
                            View Attachment
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
