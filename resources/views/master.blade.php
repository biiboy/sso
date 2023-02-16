<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PT. Gudang Garam Tbk</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/gg.png') }}">
    @include('partials.styles')
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        @include('partials.navbar')
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="page-title">
                                @stack('title')
                            </h2>
                        </div>
                        <div class="col">
                            @stack('top-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    @yield('content')
                </div>
            </div>
            @include('partials.footer')
        </div>
    </div>
    @include('partials.scripts')
    @stack('scripts')
</body>

</html>
