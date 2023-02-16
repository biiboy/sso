<li class="nav-item mb-2 {{ request()->is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-home"></i>
        </span>
        <span class="nav-link-title">
            Home
        </span>
    </a>
</li>
<li class="nav-item mb-2 dropdown {{ request()->is('assessment/assessment_kpi*') || request()->is('assessment/kpi_collaboration*') || request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-assessment" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-file"></i>
        </span>
        <span class="nav-link-title">
            Assessment
        </span>
    </a>
    <div class="dropdown-menu {{ request()->is('assessment/assessment_kpi*') || request()->is('assessment/kpi_collaboration*') || request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'show' : '' }}">
        <a class="dropdown-item {{ request()->is('assessment/assessment_kpi*') ? 'active' : '' }}" href="{{ route('assessment_kpi') }}">
            My KPI
        </a>
        <a class="dropdown-item {{ request()->is('assessment/kpi_collaboration*') ? 'active' : '' }}" href="{{ route('kpi_collaboration') }}">
            KPI Collaboration
        </a>
        <div class="dropend">
            <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu">
                <a href="{{ route('assessment_all_approval_kpi_team_gempol_asset') }}" class="dropdown-item">Gempol</a>
            </div>
        </div>
    </div>
</li>
<li class="nav-item mb-2 dropdown {{ request()->is('specialist_report*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-file"></i>
        </span>
        <span class="nav-link-title">
            Report
        </span>
    </a>
    <div class="dropdown-menu {{ request()->is('specialist_report*') ? 'show' : '' }}">
        <a class="dropdown-item {{  request()->url() == route('specialist_report_chart') ? 'active' : '' }}" href="{{ route('specialist_report_chart') }}">
            Report Chart
        </a>
        <div class="dropend">
            <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                Report KPI
            </a>
            <div class="dropdown-menu {{ request()->url() == route('specialist_report') ? 'show' : '' }}">
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team-it-support" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Asset
                    </a>
                    <div class="dropdown-menu {{ request()->url() == route('specialist_report') ? 'show' : '' }}">
                        <a href="{{ route('specialist_report') }}" class="dropdown-item {{ request()->url() == route('specialist_report') ? 'active' : '' }}">Surabaya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
<li class="nav-item mb-2 {{ request()->is('assessment/assessment_target*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('assessment_target') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-target"></i>
        </span>
        <span class="nav-link-title">
            KPI Target
        </span>
    </a>
</li>