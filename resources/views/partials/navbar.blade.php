<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark flex-column">
            <p>PT. Gudang Garam Tbk.</p>
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/gg.png') }}" width="110" height="32" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-md-flex me-3">
                <div class="btn-list">
                    <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-github" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                        </svg>
                        Source code
                    </a>
                    <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                        <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                        </svg>
                        Sponsor
                    </a>
                </div>
            </div>
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                </svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="4" />
                    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                </svg>
            </a>
            <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                    <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                    <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
                    <div class="card">
                        <div class="card-body">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet debitis et magni maxime necessitatibus ullam.
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Paweł Kuna</div>
                        <div class="mt-1 small text-muted">UI Designer</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Set status</a>
                    <a href="#" class="dropdown-item">Profile & account</a>
                    <a href="#" class="dropdown-item">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">Settings</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div>
            <p class="text-center">{{ session('name') }}</p>
            <div class="row justify-content-center">
                <div class="col-6 col-sm-4 col-md-2 col-xl-auto mb-3">
                    <a href="#" class="btn btn-dark btn-sm p-2" aria-label="Twitter">
                        <i class="ti-settings"></i>
                    </a>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="col-6 col-sm-4 col-md-2 col-xl-auto mb-3">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-dark btn-sm p-2" aria-label="Twitter">
                        <i class="ti-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                {{-- Manager --}}
                @if (auth()->user()->m_flag == 1)
                    @include('partials.nav.manager')
                {{-- Lead Asset --}}
                @elseif (auth()->user()->m_flag == 2 && auth()->user()->m_unit == 33)
                    @include('partials.nav.lead.asset')
                {{-- Lead Support --}}
                @elseif (auth()->user()->m_flag == 2 && auth()->user()->m_unit == 32)
                    @include('partials.nav.lead.support')
                {{-- Coor Helpdesk --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 43)
                    @include('partials.nav.coor.helpdesk')
                {{-- Coor Support Jakarta --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 40)
                    @include('partials.nav.coor.support.jkt')
                {{-- Coor Support Kediri --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 45)
                    @include('partials.nav.coor.support.kdr')
                {{-- Coor Asset Kediri --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 47)
                    @include('partials.nav.coor.asset.kdr')
                {{-- Coor Support SBY --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 37)
                    @include('partials.nav.coor.support.sby')
                {{-- Coor Support Gempol --}}
                @elseif (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 34)
                    @include('partials.nav.coor.support.gmp')
                {{-- Support SBY --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 38)
                    @include('partials.nav.support.sby')
                {{-- Support GMP --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 35)
                    @include('partials.nav.support.gmp')
                {{-- Support KDR --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 46)
                    @include('partials.nav.support.kdr')
                {{-- Support JKT --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 41)
                    @include('partials.nav.support.jkt')
                {{-- Helpdesk JKT --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 44)
                    @include('partials.nav.helpdesk.jkt')
                {{-- Asset JKT --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 42)
                    @include('partials.nav.asset.jkt')
                {{-- Asset KDR --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 48)
                    @include('partials.nav.asset.kdr')
                {{-- Asset SBY --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 39)
                    @include('partials.nav.asset.sby')
                {{-- Asset GMP --}}
                @elseif (auth()->user()->m_flag == 4 && auth()->user()->m_unit == 36)
                    @include('partials.nav.asset.gmp')
                @endif

                <li class="nav-item mb-2 {{ request()->url() == route('report_panduan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('report_panduan') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="fs-2 ti-help-alt"></i>
                        </span>
                        <span class="nav-link-title">
                            Help
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>