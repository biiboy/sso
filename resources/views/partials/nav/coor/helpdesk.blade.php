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
            <a class="dropdown-item dropdown-toggle {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'show' : '' }}" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*') ? 'show' : '' }}">
                <a href="{{ route('assessment_all_approval_kpi_team_jakarta_helpdesk') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_jakarta_helpdesk') ? 'active' : '' }}">Jakarta</a>
            </div>
        </div>
    </div>
</li>
<li class="nav-item mb-2 dropdown {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_jakarta_helpdesk') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_jakarta_helpdesk') ? 'show' : '' }}" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-menu-alt"></i>
        </span>
        <span class="nav-link-title">
            Task To Do
        </span>
    </a>
    <div class="dropdown-menu {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_jakarta_helpdesk') ? 'show' : '' }}">
        <a class="dropdown-item {{ request()->url() == route('assessment_all_approval') ? 'active' : '' }}" href="{{ route('assessment_all_approval') }}">
            Approval
        </a>
        <a class="dropdown-item {{ request()->url() == route('assessment_all_approval_review_kpi_team_jakarta_helpdesk') ? 'active' : '' }}" href="{{ route('assessment_all_approval_review_kpi_team_jakarta_helpdesk') }}">
            Review
        </a>
    </div>
</li>
<li class="nav-item mb-2 dropdown {{ request()->is('all_report*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-file"></i>
        </span>
        <span class="nav-link-title">
            Report
        </span>
    </a>
    <div class="dropdown-menu {{ request()->is('all_report*') ? 'show' : '' }}">
        <a class="dropdown-item" href="{{ route('all_report_helpdesk_coor_jakarta') }}">
            KPI Chart
        </a>
        <div class="dropend">
            <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu {{ request()->is('all_report') ? 'show' : '' }}">
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team-it-helpdesk" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Helpdesk
                    </a>
                    <div class="dropdown-menu {{ request()->is('all_report') ? 'show' : '' }}">
                        <a href="{{ route('all_report', ['id' => 'Jakarta', 'flag' => '1']) }}" class="dropdown-item {{ request()->is('all_report') ? 'active' : '' }}">Jakarta</a>
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