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
                <a href="{{ route('assessment_all_approval_kpi_team_all_services') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_all_services') ? 'active' : '' }}">All IT Services</a>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*asset') ? 'show' : '' }}" href="#sidebar-kpi-team-it-asset" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Asset
                    </a>
                    <div class="dropdown-menu {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*asset') ? 'show' : '' }}">
                        <a href="{{ route('assessment_all_approval_kpi_team_all_asset') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_all_asset') ? 'active' : '' }}">All IT Asset</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_gempol_asset') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_gempol_asset') ? 'active' : '' }}">Gempol</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_jakarta_asset') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_jakarta_asset') ? 'active' : '' }}">Jakarta</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_kediri_asset') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_kediri_asset') ? 'active' : '' }}">Kediri</a>
                        <a href="{{ route('assessment_all_approval_kpi_team_surabaya_asset') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_surabaya_asset') ? 'active' : '' }}">Surabaya</a>
                    </div>
                </div>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*helpdesk') ? 'show' : '' }}" href="#sidebar-kpi-team-it-helpdesk" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Helpdesk
                    </a>
                    <div class="dropdown-menu {{ request()->is('assessment/assessment_all_approval/assessment_all_approval_kpi_team*helpdesk') ? 'show' : '' }}">
                        <a href="{{ route('assessment_all_approval_kpi_team_jakarta_helpdesk') }}" class="dropdown-item {{ request()->url() == route('assessment_all_approval_kpi_team_jakarta_helpdesk') ? 'active' : '' }}">Jakarta</a>
                    </div>
                </div>
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
<li class="nav-item mb-2 dropdown {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_all_services') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_all_services') ? 'show' : '' }}" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="fs-2 ti-menu-alt"></i>
        </span>
        <span class="nav-link-title">
            Task To Do
        </span>
    </a>
    <div class="dropdown-menu {{ request()->url() == route('assessment_all_approval') || request()->url() == route('assessment_all_approval_review_kpi_team_all_services') ? 'show' : '' }}">
        <a class="dropdown-item {{ request()->url() == route('assessment_all_approval') ? 'active' : '' }}" href="{{ route('assessment_all_approval') }}">
            Approval
        </a>
        <a class="dropdown-item {{ request()->url() == route('assessment_all_approval_review_kpi_team_all_services') ? 'active' : '' }}" href="{{ route('assessment_all_approval_review_kpi_team_all_services') }}">
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
        <a class="dropdown-item {{  request()->url() == route('all_report_itmanager') ? 'active' : '' }}" href="{{ route('all_report_itmanager') }}">
            All IT Services
        </a>
        <a class="dropdown-item {{  request()->url() == route('all_report_manager_chart') ? 'active' : '' }}" href="{{ route('all_report_manager_chart') }}">
            KPI Chart
        </a>
        <div class="dropend">
            <a class="dropdown-item dropdown-toggle {{  request()->url() == route('all_report') ? 'show' : '' }}" href="#sidebar-kpi-team" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                KPI Team
            </a>
            <div class="dropdown-menu {{  request()->url() == route('all_report') ? 'show' : '' }}">
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{  request()->url() == route('all_report') && request()->flag == '3' ? 'show' : '' }}" href="#sidebar-kpi-team-it-asset" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Asset
                    </a>
                    <div class="dropdown-menu {{  request()->url() == route('all_report') && request()->flag == '3' ? 'show' : '' }}">
                        <a href="{{ route('all_report', ['id' => 'ALL', 'flag' => '3']) }}" class="dropdown-item {{ request()->id == 'ALL' && request()->flag == '3' ? 'active' : '' }}">All IT Asset</a>
                        <a href="{{ route('all_report', ['id' => 'Gempol', 'flag' => '3']) }}" class="dropdown-item {{ request()->id == 'Gempol' && request()->flag == '3' ? 'active' : '' }}">Gempol</a>
                        <a href="{{ route('all_report', ['id' => 'Jakarta', 'flag' => '3']) }}" class="dropdown-item {{ request()->id == 'Jakarta' && request()->flag == '3' ? 'active' : '' }}">Jakarta</a>
                        <a href="{{ route('all_report', ['id' => 'Kediri', 'flag' => '3']) }}" class="dropdown-item {{ request()->id == 'Kediri' && request()->flag == '3' ? 'active' : '' }}">Kediri</a>
                        <a href="{{ route('all_report', ['id' => 'Surabaya', 'flag' => '3']) }}" class="dropdown-item {{ request()->id == 'Surabaya' && request()->flag == '3' ? 'active' : '' }}">Surabaya</a>
                    </div>
                </div>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{  request()->url() == route('all_report') && request()->flag == '1' ? 'show' : '' }}" href="#sidebar-kpi-team-it-helpdesk" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Helpdesk
                    </a>
                    <div class="dropdown-menu {{  request()->url() == route('all_report') && request()->flag == '1' ? 'show' : '' }}">
                        <a href="{{ route('all_report', ['id' => 'Jakarta', 'flag' => '1']) }}" class="dropdown-item {{ request()->id == 'Jakarta' && request()->flag == '1' ? 'active' : '' }}">Jakarta</a>
                    </div>
                </div>
                <div class="dropend">
                    <a class="dropdown-item dropdown-toggle {{  request()->url() == route('all_report') && request()->flag == '2' ? 'show' : '' }}" href="#sidebar-kpi-team-it-support" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        IT Support
                    </a>
                    <div class="dropdown-menu {{  request()->url() == route('all_report') && request()->flag == '2' ? 'show' : '' }}">
                        <a href="{{ route('all_report', ['id' => 'ALL', 'flag' => '2']) }}" class="dropdown-item {{ request()->id == 'ALL' && request()->flag == '2' ? 'active' : '' }}">All IT Support</a>
                        <a href="{{ route('all_report', ['id' => 'Gempol', 'flag' => '2']) }}" class="dropdown-item {{ request()->id == 'Gempol' && request()->flag == '2' ? 'active' : '' }}">Gempol</a>
                        <a href="{{ route('all_report', ['id' => 'Jakarta', 'flag' => '2']) }}" class="dropdown-item {{ request()->id == 'Jakarta' && request()->flag == '2' ? 'active' : '' }}">Jakarta</a>
                        <a href="{{ route('all_report', ['id' => 'Kediri', 'flag' => '2']) }}" class="dropdown-item {{ request()->id == 'Kediri' && request()->flag == '2' ? 'active' : '' }}">Kediri</a>
                        <a href="{{ route('all_report', ['id' => 'Surabaya', 'flag' => '2']) }}" class="dropdown-item {{ request()->id == 'Surabaya' && request()->flag == '2' ? 'active' : '' }}">Surabaya</a>
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