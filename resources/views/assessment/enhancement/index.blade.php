@extends('master')

@push('title')
    ORAL Enhancement
@endpush

@if (auth()->user()->m_username == 'bhandoko')
    @push('top-buttons')
        <div class="d-flex justify-content-end">
            <a href="{{ route('assessment_enhancement_create') }}" class="btn btn-success">
                <i class="ti-plus me-1"></i>
                Add
            </a>
        </div>
    @endpush
@endif

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white"><strong>ORAL Enhancement Details</strong></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive drop_here_table_index">
                <table id="zero_config" class="table table-vcenter card-table rounded border dataTable no-footer">
                    <thead>
                        <tr>
                            <th>
                                Year
                            </th>
                            <th>
                                Title
                            </th>
                            <th width="800px">
                                Description
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Submit Date
                            </th>
                            <th>
                                Publish Date
                            </th>
                            <th width="100px">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $element)
                            <tr>
                                <td align="center">{{ $element->k_enhancement_period }}</td>
                                <td align="center">{{ $element->k_enhancement_title }}</td>
                                <td class="text-justify">{!! $element->k_enhancement_dec !!}</td>
                                <td align="Center">
                                    @if ($element->k_enhancement_status_id == 31)
                                        Published
                                    @elseif ($element->k_enhancement_status_id == 32)
                                        Draft
                                    @endif
                                </td>
                                <td align="Center">{{ date('d-M-Y', strtotime($element->k_enhancement_created_at)) }}
                                </td>

                                <td align="Center">
                                    @if ($element->k_enhancement_publish_date == null)
                                        -
                                    @else
                                        {{ date('d-M-Y', strtotime($element->k_enhancement_publish_date)) }}
                                    @endif
                                </td>

                                <td>
                                    <center>
                                        <a class="btn btn-sm btn-primary mb-1"
                                            href="{{ route('assessment_enhancement_view', ['id' => $element->k_enhancement_id]) }}"
                                            Style="width: 100px;">
                                            <i class="ti-eye me-1"></i>
                                            View
                                        </a>
                                        @if ($element->k_enhancement_status_id == 32)
                                            @if (auth()->user()->m_username == 'bhandoko')
                                                <div class="col">
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('assessment_enhancement_edit', ['id' => $element->k_enhancement_id]) }}"
                                                        Style="width: 100px;">
                                                        <i class="ti-pencil me-1"></i>
                                                        Edit
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        $(document).ready(function() {
            table = $("#zero_config").DataTable({
                pageLength: 100,
                processing: true,
                lengthMenu: [
                    [100, 10, 25, 50, -1],
                    [100, 10, 25, 50, "Semua"],
                ],
            });
            $(".dataTables_length select").addClass("form-select mb-2");
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        });
    </script>
@endpush
