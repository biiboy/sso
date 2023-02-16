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
<li class="nav-item mb-2 dropdown {{ request()->is('setting*') || request()->is('master*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="{{ request()->is('master*') ? 'true' : 'false' }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-file"></i>
        </span>
        <span class="nav-link-title">
            Master
        </span>
    </a>
    <div class="dropdown-menu {{ request()->is('setting*') || request()->is('master*') ? 'show' : '' }}">
        <a class="dropdown-item {{ request()->is('setting/setting_menu*') ? 'active' : '' }}" href="{{ route('setting_menu') }}">
            Menu
        </a>
        <a class="dropdown-item {{ request()->is('master/master_access*') ? 'active' : '' }}" href="{{ route('master_access') }}">
            Access
        </a>
        <a class="dropdown-item {{ request()->is('master/master_user*') ? 'active' : '' }}" href="{{ route('master_user') }}">
            User
        </a>
        <a class="dropdown-item {{ request()->is('master/master_site*') ? 'active' : '' }}" href="{{ route('master_site') }}">
            Site
        </a>
        <a class="dropdown-item {{ request()->is('master/master_unit*') ? 'active' : '' }}" href="{{ route('master_unit') }}">
            Unit
        </a>
        <a class="dropdown-item {{ request()->is('master/master_periode*') ? 'active' : '' }}" href="{{ route('master_periode') }}">
            Periode
        </a>
        <a class="dropdown-item {{ request()->is('master/master_email*') ? 'active' : '' }}" href="{{ route('master_email') }}">
            Pengaturan Email
        </a>
    </div>
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
            <a class="dropdown-item dropdown-toggle {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'show' : '' }}" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'show' : '' }}">
                <a href="{{ route('assessment_all_approval_kpi_team_surabaya_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_surabaya_support') ? 'active' : '' }}">Surabaya</a>
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
                        IT Support
                    </a>
                    <div class="dropdown-menu {{ request()->url() == route('specialist_report') ? 'show' : '' }}">
                        <a href="{{ route('specialist_report') }}" class="dropdown-item {{ request()->url() == route('specialist_report') ? 'active' : '' }}">Surabaya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
@if (auth()->user()->m_id == 37)
    <li class="nav-item mb-2 dropdown {{ request()->is('assessment/assessment_audit*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="fs-2 ti-file"></i>
            </span>
            <span class="nav-link-title">
                Audit
            </span>
        </a>
        <div class="dropdown-menu {{ request()->is('assessment/assessment_audit*') ? 'show' : '' }}">
            <a class="dropdown-item {{  request()->url() == route('assessment_audit') ? 'active' : '' }}" href="{{ route('assessment_audit') }}">
                Log Activity
            </a>
            <a class="dropdown-item dropdown-item {{  request()->url() == route('assessment_audit_reminder') ? 'active' : '' }}" href="{{ route('assessment_audit_reminder') }}">
                Log Email Reminder
            </a>
        </div>
    </li>
@endif
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
@if (auth()->user()->m_id == 37)
    <li class="nav-item mb-2 {{ request()->is('assessment/assessment_enhancement*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('assessment_enhancement') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="fs-2 ti-settings"></i>
            </span>
            <span class="nav-link-title">
                ORAL Enhancement
            </span>
        </a>
    </li>
@endif