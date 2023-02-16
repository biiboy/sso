@extends('master')

@push('title')
    View Enhancement ORAL
@endpush

@section('content')
    <div class="card">
        <form id="save">
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $data->k_enhancement_id }}">

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Title</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            value="{{ $data->k_enhancement_title }}" style="pointer-events: none;background: lightgrey">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_goal" class="col-2 col-form-label">
                        <b>Description</b>
                    </label>
                    <div class="col-10">
                        <textarea class="form-control mymce" type="text" name="k_enhancement_dec" id="mymce"
                            style="pointer-events: none;background: lightgrey">{!! $data->k_enhancement_dec !!}</textarea>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Year</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            value="{{ $data->k_enhancement_period }}" style="pointer-events: none;background: lightgrey">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Revision Date</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            value="{{ date('d-M-Y', strtotime($data->k_enhancement_revision_date)) }}"
                            style="pointer-events: none;background: lightgrey">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Type</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            style="pointer-events: none;background: lightgrey"
                            @if ($data->k_enhancement_type == 1) value="Enhancement" {{-- COOR --}}
                                    @else
                                        value="Bugs" {{-- LEAD --}} @endif>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Status</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            style="pointer-events: none;background: lightgrey"
                            @if ($data->k_enhancement_status_id == 32) value="Draft" {{-- COOR --}}
                                    @else
                                        value="Publish" {{-- LEAD --}} @endif>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_targetdate" class="col-2 col-form-label ">
                        <b>Enhancement File</b>
                    </label>
                    <div class="col-10">
                        <div class="row form-group preview_div">
                            <div class="col-9">
                                <div class="file-upload upl_1">
                                    <div class="file-select">
                                        <div class="file-select-button fileName">File</div>
                                        <div class="file-select-name noFile tag_image_1">
                                            {{ $data->k_enhancement_file }}</div>
                                        <input type="hidden" class="noFile_val file_check">
                                        <input type="hidden" name="file_upload_value" class="file_upload_value"
                                            value="">
                                        <input type="hidden" name="file_upload_value_index" class="file_upload_value_index"
                                            value="">
                                        <input type="file" class="chooseFile" value="{{ $data->k_enhancement_file }}"
                                            name="file" style="pointer-events: none;background: lightgrey">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 text-end">
                                <a class="btn btn-primary" href="{{ Storage::url($data->k_enhancement_file) }}"
                                    target="_blank" Style="width: 178px;">
                                    <i class="ti-eye me-1"></i>
                                    View Attachment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Created By</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            style="pointer-events: none;background: lightgrey"
                            @if ($data->k_enhancement_created_by == 37) value="Bondan Handoko"
                                            @else
                                                value="Someone Else" @endif>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Submit Date</b>
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="k_title" id="k_title"
                            value="{{ date('d-M-Y H:i:s', strtotime($data->k_enhancement_created_at)) }}"
                            style="pointer-events: none;background: lightgrey">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="k_label" class="col-2 col-form-label">
                        <b>Updated Date</b>
                    </label>
                    <div class="col-10">
                        @if ($data->k_enhancement_updated_at == null)
                            <input class="form-control" type="text" name="k_title" id="k_title" value="-"
                                style="pointer-events: none;background: lightgrey">
                        @else
                            <input class="form-control" type="text" name="k_title" id="k_title"
                                value="{{ date('d-M-Y H:i:s', strtotime($data->k_enhancement_updated_at)) }}"
                                style="pointer-events: none;background: lightgrey">
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="k_label" class="col-2 col-form-label"><b>Publish Date</b></label>
                    <div class="col-10">
                        @if ($data->k_enhancement_publish_date == null)
                            <input class="form-control" type="text" name="k_title" id="k_title" value="-"
                                style="pointer-events: none;background: lightgrey">
                        @else
                            <input class="form-control" type="text" name="k_title" id="k_title"
                                value="{{ date('d-M-Y H:i:s', strtotime($data->k_enhancement_publish_date)) }}"
                                style="pointer-events: none;background: lightgrey">
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#mymce',
            height: 150,
            toolbar: 'mybutton',
            menubar: false,
            readonly: 1,

            setup: function(editor) {

            }
        });
        tinymce.activeEditor.setMode('readonly');
    </script>
@endpush
