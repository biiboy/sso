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
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*support') ? 'show' : '' }}" href="#sidebar-kpi-team-it-support" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Support
                    </a>
                    <div class="dropdown-menu {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*support') ? 'show' : '' }}">
                        <a href="{{ route('assessment_all_approval_kpi_team_all_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_all_support') ? 'active' : '' }}">All IT Support</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_gempol_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_gempol_support') ? 'active' : '' }}">Gempol</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_jakarta_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_jakarta_support') ? 'active' : '' }}">Jakarta</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_kediri_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_kediri_support') ? 'active' : '' }}">Kediri</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_surabaya_support') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_surabaya_support') ? 'active' : '' }}">Surabaya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
<li class="nav-item mb-2 dropdown {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_review_kpi_team_all_support') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_review_kpi_team_all_support') ? 'show' : '' }}" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-menu-alt"></i>
        </span>
        <span class="nav-link-title">
            Task To Do
        </span>
    </a>
    <div class="dropdown-menu {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_review_kpi_team_all_support') ? 'show' : '' }}">
        <a class="dropdown-item {{ request()->url() == route('assessment_all_approval') ? 'active' : '' }}" href="{{ route('assessment_all_approval') }}">
            Approval
        </a>
        <a class="dropdown-item {{ request()->url() == route('assessment_all_review_kpi_team_all_support') ? 'active' : '' }}" href="{{ route('assessment_all_review_kpi_team_all_support') }}">
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
        <a class="dropdown-item {{  request()->url() == route('all_report_lead_support_chart') ? 'active' : '' }}" href="{{ route('all_report_lead_support_chart') }}">
            KPI Chart
        </a>
        <div class="dropend">
            <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu {{ request()->is('all_report') ? 'show' : '' }}">
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle" href="#sidebar-kpi-team-it-support" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Support
                    </a>
                    <div class="dropdown-menu {{ request()->is('all_report') ? 'show' : '' }}">
                        <a href="{{ route('all_report', ['id' => 'ALL', 'flag' => '2']) }}" class="dropdown-item">All IT Support</a>
                        <a href="{{ route('all_report', ['id' => 'Gempol', 'flag' => '2']) }}" class="dropdown-item">Gempol</a>
                        <a href="{{ route('all_report', ['id' => 'Jakarta', 'flag' => '2']) }}" class="dropdown-item">Jakarta</a>
                        <a href="{{ route('all_report', ['id' => 'Kediri', 'flag' => '2']) }}" class="dropdown-item">Kediri</a>
                        <a href="{{ route('all_report', ['id' => 'Surabaya', 'flag' => '2']) }}" class="dropdown-item">Surabaya</a>
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