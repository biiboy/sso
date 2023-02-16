@extends('master')

@push('title')
    @if (auth()->user()->m_flag == 2 && auth()->user()->m_unit == 33)
        Report > KPI Team > IT Asset > {{ $id }}
    @endif

    @if (auth()->user()->m_flag == 2 && auth()->user()->m_unit == 32)
        Report > KPI Team > IT Support > {{ $id }}
    @endif

    @if (auth()->user()->m_flag == 1)
        Report -> Manager All Site
    @endif

    @if (auth()->user()->m_flag == 4)
        Report -> KPI Team IT Support
    @endif

    {{-- Coor Gempol --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 34)
        Report > KPI Team > IT Support > {{ $id }}
    @endif

    {{-- Coor SBY --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 37)
        Report > KPI Team > IT Support > {{ $id }}
    @endif

    {{-- Coor Kediri --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 45)
        Report > KPI Team > IT Support > {{ $id }}
    @endif

    {{-- Coor Jakarta --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 40)
        Report > KPI Team > IT Support > {{ $id }}
    @endif

    {{-- Coor Helpdesk --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 43)
        Report > KPI Team > IT Helpdesk > {{ $id }}
    @endif

    {{-- Coor Asset --}}
    @if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 47)
        Report > KPI Team > IT Asset > {{ $id }}
    @endif
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-success">
                <div class="card-header bg-success">
                    <h4 class="mb-0 text-white">Report Details</h4>
                </div>
                <div class="card-body">
                    <div class="text-right mb-3">
                    </div>

                    <form>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Periode</label>
                            <select class="form-control form-select cari_tahun">
                                <option value="ALL">All</option>
                                @foreach ($year as $element)
                                    <option value="{{ $element->p_year }}">{{ $element->p_year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive drop_here_table_header">
                        <table id="zero_config" class="table table-vcenter card-table rounded border">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Full Name
                                    </th>
                                    <th class="text-center">
                                        Title
                                    </th>
                                    <th class="text-center">
                                        <span class="badge rounded-pill bg-secondary-lt">N/A</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge rounded-pill bg-danger-lt">Unacceptable</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge rounded-pill bg-warning-lt">Need Improvement</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge rounded-pill bg-info-lt">Good</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="badge rounded-pill bg-success-lt">Outstanding</span>
                                    </th>
                                    <th class="text-center">
                                        Total Penilaian
                                    </th>
                                    <th class="text-center">
                                        Total KPI
                                    </th>
                                    @if (auth()->user()->m_flag == 1)
                                        <th class="text-center">
                                            Final Result
                                        </th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $na = 0;
                                    $unacceptable = 0;
                                    $ni = 0;
                                    $good = 0;
                                    $outstanding = 0;
                                    $total = 0;
                                    $total_kpi = 0;
                                @endphp

                                @foreach ($all_site as $element)
                                    <tr>
                                        <td>
                                            {{ $element->m_name }}
                                        </td>

                                        <td>
                                            {{ $element->u_name }}
                                        </td>

                                        <td>
                                            <center>
                                                <span
                                                    class="badge rounded-pill bg-secondary-lt">{{ $element->NA ?? 0 }}</span>
                                            </center>
                                        </td>

                                        <td>
                                            <center>
                                                <span
                                                    class="badge rounded-pill bg-danger-lt">{{ $element->Unacceptable ?? 0 }}</span>
                                            </center>
                                        </td>

                                        <td>
                                            <center>
                                                <span
                                                    class="badge rounded-pill bg-warning-lt">{{ $element->NI ?? 0 }}</span>
                                            </center>
                                        </td>

                                        <td>
                                            <center>
                                                <span
                                                    class="badge rounded-pill bg-info-lt">{{ $element->Good ?? 0 }}</span>
                                            </center>
                                        </td>

                                        <td>
                                            <center>
                                                <span
                                                    class="badge rounded-pill bg-success-lt">{{ $element->Outstanding ?? 0 }}</span>
                                            </center>
                                        </td>

                                        <td>
                                            <center>
                                                {{ $element->NA + $element->Unacceptable + $element->NI + $element->Good + $element->Outstanding }}
                                            </center>
                                        </td>

                                        @php
                                        ($na += $element->NA) ?? 0;
                                        ($unacceptable += $element->Unacceptable)
                                        ?? 0;
                                        ($ni += $element->NI) ?? 0;
                                        ($good += $element->Good) ?? 0;
                                        ($outstanding += $element->Outstanding) ?? 0;
                                        $total += $element->NA + $element->Unacceptable + $element->NI + $element->Good +
                                        $element->Outstanding;
                                        ($total_kpi += $element->ttl_kpi) ?? 0;
                                        @endphp

                                        {{-- Jumlah Total KPI --}}
                                        <td>
                                            <center>
                                                <b>{{ $element->ttl_kpi ?? 0 }}</b>
                                            </center>
                                        </td>

                                        @if (auth()->user()->m_flag == 1)
                                            <td>
                                                <center>
                                                    <font size="5">
                                                        <span class="badge rounded-pill bg-secondary-lt">N/A</span>
                                                    </font>
                                                </center>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>


                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <b>TOTAL PENILAIAN KPI TEAM</b>
                                    </td>

                                    <td class="total_na">
                                        <center>
                                            {{ $na }}
                                        </center>
                                    </td>

                                    <td class="total_unacceptable">
                                        <center>
                                            {{ $unacceptable }}
                                        </center>
                                    </td>

                                    <td class="total_ni">
                                        <center>
                                            {{ $ni }}
                                        </center>
                                    </td>

                                    <td class="total_good">
                                        <center>
                                            {{ $good }}
                                        </center>
                                    </td>

                                    <td class="total_outstanding">
                                        <center>
                                            {{ $outstanding }}
                                        </center>
                                    </td>

                                    <td class="total_total">
                                        <center>
                                            {{ $total }}
                                        </center>
                                    </td>

                                    <td class="total_total">
                                        <center>
                                            
                                                <b>{{ $total_kpi }}</b>
                                            
                                        </center>
                                    </td>

                                    @if (auth()->user()->m_flag == 1)
                                        <td>
                                            <center>
                                                -
                                            </center>
                                        </td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script>
        $(function() {
            $('#zero_config').DataTable({
                "aLengthMenu": [100, 10, 25, 50],
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });

            $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass(
                'btn btn-primary mt-3');
            $(".dataTables_filter input").addClass("mb-2");
            $(".dataTables_filter input").removeClass("form-control-sm");
        })

        $('.cari_tahun').change(function(argument) {
            var tahun = $(this).val();
            $.ajax({
                url: '{{ route('cari_tahun_report_kpi_manager') }}',
                type: 'get',
                data: '&tahun=' + tahun + '&id=' + '{{ $id }}',
                success: function(data) {
                    $('.drop_here_table_header').empty();
                    $('.drop_here_table_header').append(data);
                },
                error: function(data) {

                }

            })
        })
    </script>
@endpush
