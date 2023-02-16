@extends('master')

@push('title')
    Dashboard
@endpush

@push('styles')
    <link href="https://preview.tabler.io/dist/css/tabler.min.css?1668288743" rel="stylesheet" />
    <link href="https://preview.tabler.io/dist/css/tabler-flags.min.css?1668288743" rel="stylesheet" />
    <link href="https://preview.tabler.io/dist/css/tabler-payments.min.css?1668288743" rel="stylesheet" />
    <link href="https://preview.tabler.io/dist/css/tabler-vendors.min.css?1668288743" rel="stylesheet" />
    <link href="https://preview.tabler.io/dist/css/demo.min.css?1668288743" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.0/apexcharts.css" rel="stylesheet" />


    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
@endpush

@section('content')
    <script src="./dist/js/demo-theme.min.js?1668288743"></script>
    <div class="container-fluid">
        <div class="card-header">
            <h5 class="card-title" style="font-size:25px;">KPI Per Site</h5>
        </div><br>
        <div class="row row-deck row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center text-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-up-circle" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M12 8l-4 4"></path>
                                        <path d="M12 8l0 8"></path>
                                        <path d="M16 12l-4 -4"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col"><br>
                                <div class="h1 m-0">GEMPOL</div>
                                <div class="text-muted mb-3">40 Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center text-center">
                            <div class="col-auto">
                                <span class="bg-yellow text-white avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-down-circle" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M8 12l4 4"></path>
                                        <path d="M12 8l0 8"></path>
                                        <path d="M16 12l-4 4"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col"><br>
                                <div class="h1 m-0">JAKARTA</div>
                                <div class="text-muted mb-3">40 Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center text-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-up-circle" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M12 8l-4 4"></path>
                                        <path d="M12 8l0 8"></path>
                                        <path d="M16 12l-4 -4"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col"><br>
                                <div class="h1 m-0">KEDIRI</div>
                                <div class="text-muted mb-3">40 Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center text-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-up-circle" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M12 8l-4 4"></path>
                                        <path d="M12 8l0 8"></path>
                                        <path d="M16 12l-4 -4"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col"><br>
                                <div class="h1 m-0">SURABAYA</div>
                                <div class="text-muted mb-3">40 Submit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-header">
                &nbsp;&nbsp;<h5 class="card-title" style="font-size:25px;">KPI Per Unit</h5>
            </div><br>
            <div class="col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center text-center">
                            <div class="col-auto">
                                <div class="h1 m-0">IT ASSET</div>
                                <div class="text-muted mb-3">140 Submit</div>
                                {{-- <span class="text-white"> --}}
                                <div id="asset"></div>
                                {{-- </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center text-center">
                            <div class="col-auto">
                                <div class="h1 m-0">IT HELPDESK</div>
                                <div class="text-muted mb-3">60 Submit</div>
                                {{-- <span class="text-white"> --}}
                                <div id="helpdesk"></div>
                                {{-- </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center text-center">
                            <div class="col-auto">
                                <div class="h1 m-0">IT SUPPORT</div>
                                <div class="text-muted mb-3">180 Submit</div>
                                {{-- <span class="text-white"> --}}
                                <div id="support_1"></div>
                                {{-- </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-header">
                &nbsp;&nbsp;<h5 class="card-title" style="font-size:25px;">Total KPI</h5>
            </div><br>
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center text-center">
                            <div class="col-auto">
                                {{-- <span class="text-white"> --}}
                                <div id="all"></div>
                                {{-- </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-size:25px;">KPI Waiting for Approval & In Review</h3>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-muted">
                                Show
                                <div class="mx-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" value="8"
                                        size="3" aria-label="Invoices count">
                                </div>
                                entries
                            </div>
                            <div class="ms-auto text-muted">
                                Search:
                                <div class="ms-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm"
                                        aria-label="Search invoice">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr align="center">
                                    <th>Submitted By</th>
                                    <th>Submit Date</th>
                                    <th>First Due Date</th>
                                    <th>Key Result Area</th>
                                    <th>Goal</th>
                                    <th>Target Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Abdus Shahrir Rozaq</td>
                                    <td>05-Jan-2022</td>
                                    <td>
                                        31-Mar-2022
                                    </td>
                                    <td>
                                        Knowledge Management
                                    </td>
                                    <td>
                                        Membuat sejumlah 3 (tiga) Knowledge Article serta memastikan 100% artikel tersebut
                                        berstatus “Published” selama periode 1-Mar-2022 s/d 31-Jul-2022.
                                    </td>
                                    <td>
                                        31-Jul-2022
                                    </td>
                                    <td>Waiting For Approval Firdaus Santoso</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    Approve
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bondan Handoko</td>
                                    <td>20-Des-2021</td>
                                    <td>
                                        04-Jan-2022
                                    </td>
                                    <td>
                                        Standard Client Password
                                    </td>
                                    <td>
                                        Melakukan penggantian password Local Administrator “Support” di minimal 90%
                                        perangkat komputer user GG dan anak perusahaan yang ter-manage oleh Ivanti Endpoint
                                        Manager di site Surabaya per kuartal selama periode 04-Jan-2022 s/d 31-Oct-2022.
                                    </td>
                                    <td>
                                        31-Oct-2022
                                    </td>
                                    <td>Waiting For Approval Firdaus Santoso</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    Approve
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bondan Handoko</td>
                                    <td>20-Des-2021</td>
                                    <td>
                                        04-Jan-2022
                                    </td>
                                    <td>
                                        Standard Client Password
                                    </td>
                                    <td>
                                        Melakukan penggantian password Local Administrator “Support” di 100% perangkat
                                        komputer user GG dan anak perusahaan yang menggunakan sistem operasi macOS di site
                                        Surabaya per kuartal selama periode 4-Jan-2022 s/d 31-Oct-2022.
                                    </td>
                                    <td>
                                        31-Oct-2022
                                    </td>
                                    <td>Waiting For Approval Firdaus Santoso</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    Approve
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                        <ul class="pagination m-0 ms-auto">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="15 6 9 12 15 18" />
                                    </svg>
                                    prev
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    next
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="9 6 15 12 9 18" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-size:25px;">KPI Due Date</h3>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-muted">
                                Show
                                <div class="mx-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" value="8"
                                        size="3" aria-label="Invoices count">
                                </div>
                                entries
                            </div>
                            <div class="ms-auto text-muted">
                                Search:
                                <div class="ms-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm"
                                        aria-label="Search invoice">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr align="center">
                                    <th>Submitted By</th>
                                    <th>Due Date</th>
                                    <th>Key Result Area</th>
                                    <th>Goal</th>
                                    <th>Target Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Abdus Shahrir Rozaq</td>
                                    <td>
                                        14-Feb-2022
                                    </td>
                                    <td>
                                        Knowledge Management
                                    </td>
                                    <td>
                                        Membuat sejumlah 3 (tiga) Knowledge Article serta memastikan 100% artikel tersebut
                                        berstatus “Published” selama periode 1-Mar-2022 s/d 31-Jul-2022.
                                    </td>
                                    <td>
                                        31-Jul-2022
                                    </td>
                                    <td>Active H-7</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bondan Handoko</td>
                                    <td>
                                        04-Jan-2022
                                    </td>
                                    <td>
                                        Standard Client Password
                                    </td>
                                    <td>
                                        Melakukan penggantian password Local Administrator “Support” di minimal 90%
                                        perangkat komputer user GG dan anak perusahaan yang ter-manage oleh Ivanti Endpoint
                                        Manager di site Surabaya per kuartal selama periode 04-Jan-2022 s/d 31-Oct-2022.
                                    </td>
                                    <td>
                                        31-Oct-2022
                                    </td>
                                    <td>Active H+30</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bondan Handoko</td>
                                    <td>
                                        04-Jan-2022
                                    </td>
                                    <td>
                                        Standard Client Password
                                    </td>
                                    <td>
                                        Melakukan penggantian password Local Administrator “Support” di 100% perangkat
                                        komputer user GG dan anak perusahaan yang menggunakan sistem operasi macOS di site
                                        Surabaya per kuartal selama periode 4-Jan-2022 s/d 31-Oct-2022.
                                    </td>
                                    <td>
                                        31-Oct-2022
                                    </td>
                                    <td>Active</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    View
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    Approve
                                                </a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                        <ul class="pagination m-0 ms-auto">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="15 6 9 12 15 18" />
                                    </svg>
                                    prev
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    next
                                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="9 6 15 12 9 18" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://preview.tabler.io/dist/libs/apexcharts/dist/apexcharts.min.js?1668288743"></script>
    <!-- Tabler Core -->
    <script src="https://preview.tabler.io/dist/js/demo.min.js?1668288743"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.0/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.37.0/apexcharts.js"></script>




    <script>
        let options = {
            series: [25, 25, 10, 10],
            labels: ["Approve", "Pending", "Review", "Final"],
            colors: ['#58BDFF', '#FF4560', '#FEB019', '#32CD32'],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => '70'
                            }
                        }
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#asset"), options);
        chart.render();
    </script>

    <script>
        let helpdesk = {
            series: [10, 50, 4, 8],
            labels: ["Approve", "Pending", "Review", "Final"],
            colors: ['#58BDFF', '#FF4560', '#FEB019', '#32CD32'],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => '10'
                            }
                        }
                    }
                }
            }
        };

        const helpdesk_1 = new ApexCharts(document.querySelector("#helpdesk"), helpdesk);
        helpdesk_1.render();
    </script>

    <script>
        let support = {
            series: [40, 20, 10, 8],
            colors: ['#58BDFF', '#FF4560', '#FEB019', '#32CD32'],
            labels: ["Approve", "Pending", "Review", "Final"],
            chart: {
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => '40'
                            }
                        }
                    }
                }
            }
        };

        const support_1 = new ApexCharts(document.querySelector("#support_1"), support);
        support_1.render();
    </script>

    <script>
        var all = {
            chart: {
                height: 350,
                type: "line",
                stacked: false
            },
            dataLabels: {
                enabled: true
            },
            colors: ['#58BDFF', '#FF4560', '#FEB019', '#32CD32'],
            series: [

                {
                    name: 'Total Approved',
                    type: 'column',
                    data: [10, 5, 8, 6]
                },
                {
                    name: "Total Pending",
                    type: 'column',
                    data: [10, 19, 27, 26]
                },
                {
                    name: "Total Review",
                    type: 'line',
                    data: [4, 2, 5, 5]
                },
                {
                    name: "Total Final",
                    type: 'line',
                    data: [2, 4, 3, 3]
                },
            ],
            stroke: {
                width: [4, 4, 4]
            },
            // plotOptions: {
            //     bar: {
            //         columnWidth: "20%"
            //     }
            // },
            xaxis: {
                categories: ['Gempol', 'Jakarta', 'Kediri', 'Surabaya']
            },
            yaxis: [{
                    seriesName: 'Column A',
                    axisTicks: {
                        show: true
                    },
                    axisBorder: {
                        show: true,
                    },
                    title: {
                        text: ""
                    }
                },
                {
                    seriesName: 'Column A',
                    show: true
                }, {
                    opposite: true,
                    seriesName: 'Line C',
                    axisTicks: {
                        show: true
                    },
                    axisBorder: {
                        show: true,
                    },
                    title: {
                        text: ""
                    }
                }
            ],
            tooltip: {
                shared: false,
                intersect: true,
                x: {
                    show: false
                }
            },
            legend: {
                horizontalAlign: "left",
                offsetX: 40
            }
        };

        var all_1 = new ApexCharts(document.querySelector("#all"), all);

        all_1.render();
    </script>
@endpush
