<?php

use App\Http\Controllers\AllReportController;
use App\Http\Controllers\Assessment\AllApprovalController;
use App\Http\Controllers\Assessment\AllReviewController;
use App\Http\Controllers\Assessment\AuditController;
use App\Http\Controllers\Assessment\EnhancementController;
use App\Http\Controllers\Assessment\KpiCollaborationsController;
use App\Http\Controllers\Assessment\KpiController;
use App\Http\Controllers\Assessment\TargetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\AccessController;
use App\Http\Controllers\Master\EmailController;
use App\Http\Controllers\Master\PeriodeController;
use App\Http\Controllers\Master\SettingController;
use App\Http\Controllers\Master\SiteController;
use App\Http\Controllers\Master\UnitController;
use App\Http\Controllers\Master\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/login', [LoginController::class, 'index'])->name('welcome');
    Route::post('/login', [HomeController::class, 'login']);
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::prefix('home')->group(function(){
        Route::view('/', 'home')->name('home');
        Route::get('/profile/{id}', [HomeController::class, 'profile'])->name('profile');
    });
    Route::prefix('setting')->group(function () {
        Route::prefix('setting_menu')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting_menu');
            Route::get('edit/{id}', [SettingController::class, 'edit'])->name('setting_menu_edit');
            Route::get('update/{id}', [SettingController::class, 'update'])->name('setting_menu_update');
        });
    });

    Route::prefix('master')->group(function () {
        Route::prefix('master_access')->group(function () {
            Route::get('/', [AccessController::class, 'index'])->name('master_access');
            Route::get('create', [AccessController::class, 'create'])->name('master_access_create');
            Route::get('save', [AccessController::class, 'store'])->name('master_access_save');
            Route::get('edit/{id}', [AccessController::class, 'edit'])->name('master_access_edit');
            Route::get('update', [AccessController::class, 'update'])->name('master_access_update');
            Route::get('delete/{id}', [AccessController::class, 'destroy'])->name('master_access_delete');
        });
        Route::prefix('master_user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('master_user');
            Route::get('create', [UserController::class, 'create'])->name('master_user_create');
            Route::get('save', [UserController::class, 'store'])->name('master_user_save');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('master_user_edit');
            Route::get('update/{id}', [UserController::class, 'update'])->name('master_user_update');
            Route::get('delete/{id}', [UserController::class, 'destroy'])->name('master_user_delete');
        });
        Route::prefix('master_site')->group(function () {
            Route::get('/', [SiteController::class, 'index'])->name('master_site');
            Route::get('create', [SiteController::class, 'create'])->name('master_site_create');
            Route::get('save', [SiteController::class, 'store'])->name('master_site_save');
            Route::get('edit/{id}', [SiteController::class, 'edit'])->name('master_site_edit');
            Route::get('update/{id}', [SiteController::class, 'update'])->name('master_site_update');
            Route::get('delete/{id}', [SiteController::class, 'destroy'])->name('master_site_delete');
        });
        Route::prefix('master_unit')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('master_unit');
            Route::get('create', [UnitController::class, 'create'])->name('master_unit_create');
            Route::get('save', [UnitController::class, 'store'])->name('master_unit_save');
            Route::get('edit/{id}', [UnitController::class, 'edit'])->name('master_unit_edit');
            Route::get('update/{id}', [UnitController::class, 'update'])->name('master_unit_update');
            Route::get('delete/{id}', [UnitController::class, 'destroy'])->name('master_unit_delete');
        });
        Route::prefix('master_periode')->group(function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('master_periode');
            Route::get('create', [PeriodeController::class, 'create'])->name('master_periode_create');
            Route::get('save', [PeriodeController::class, 'store'])->name('master_periode_save');
            Route::get('edit/{id}', [PeriodeController::class, 'edit'])->name('master_periode_edit');
            Route::get('update/{id}', [PeriodeController::class, 'update'])->name('master_periode_update');
            Route::get('delete/{id}', [PeriodeController::class, 'destroy'])->name('master_periode_delete');
        });
        Route::prefix('master_email')->group(function () {
            Route::get('/', [EmailController::class, 'index'])->name('master_email');
            Route::post('save', [EmailController::class, 'save'])->name('master_email_save');
        });
    });

    Route::prefix('assessment')->group(function () {
        Route::get('/datatable_assessment_kpi', [KpiController::class, 'datatable_assessment_kpi'])->name('datatable_assessment_kpi');
        Route::post('/assessment_all_approval_save_proof_doc', [AllApprovalController::class, 'assessment_all_approval_save_proof_doc'])->name('assessment_all_approval_save_proof_doc');

        Route::prefix('assessment_kpi')->group(function () {
            Route::get('/', [KpiController::class, 'index'])->name('assessment_kpi');
            Route::get('/create', [KpiController::class, 'create'])->name('assessment_kpi_create');
            Route::post('/save', [KpiController::class, 'store'])->name('assessment_kpi_save');
            Route::post('/update', [KpiController::class, 'update'])->name('assessment_kpi_update');
            Route::get('/resubmit/{id}', [KpiController::class, 'resubmit'])->name('assessment_kpi_resubmit');
            Route::get('/delete/{id}', [KpiController::class, 'delete'])->name('assessment_kpi_delete');

            Route::get('/total_kpi', [KpiController::class, 'total_kpi'])->name('assessment_kpi_total_kpi');

            Route::get('/active/{id}', [KpiController::class, 'active'])->name('assessment_kpi_active');
            Route::get('/draft/{id}', [KpiController::class, 'draft'])->name('assessment_kpi_draft');
            Route::get('/edit/{id}', [KpiController::class, 'edit'])->name('assessment_kpi_edit');
            Route::get('/waiting/{id}', [KpiController::class, 'waiting'])->name('assessment_kpi_waiting');

            Route::get('/statusactive/{id}', [KpiController::class, 'active_lead'])->name('assessment_kpi_statusactive');

            Route::get('/save_comment', [KpiController::class, 'save_comment'])->name('assessment_kpi_save_comment');

            Route::get('/save_comment_date', [KpiController::class, 'save_comment_date'])->name('assessment_kpi_save_comment_date');
            Route::get('/show_comment_date', [KpiController::class, 'show_comment_date'])->name('5assessment_kpi_show_comment_date');

            Route::get('/show_comment_kra', [KpiController::class, 'show_comment_kra'])->name('assessment_kpi_show_comment_kra');
            Route::get('/save_comment_kra', [KpiController::class, 'save_comment_kra'])->name('assessment_kpi_save_comment_kra');

            Route::get('/save_comment_goal', [KpiController::class, 'save_comment_goal'])->name('assessment_kpi_save_comment_goal');
            Route::get('/show_comment_goal', [KpiController::class, 'show_comment_goal'])->name('assessment_kpi_show_comment_goal');

            Route::get('/show_file', [KpiController::class, 'show_file'])->name('assessment_kpi_show_file');
            Route::get('/deleting_file', [KpiController::class, 'deleting_file'])->name('assessment_kpi_deleting_file');

            Route::post('/assessment_kpi_complete_on_show', [KpiController::class, 'assessment_kpi_complete_on_show'])->name('assessment_kpi_complete_on_show');

            Route::post('/save_kpi_pdf', [KpiController::class, 'save_kpi_pdf'])->name('assessment_kpi_save_kpi_pdf');
        });
        Route::prefix('assessment_all_approval')->group(function () {
            Route::get('/', [AllApprovalController::class, 'index'])->name('assessment_all_approval');

            Route::get('/appraisal/{id}', [AllApprovalController::class, 'appraisal'])->name('assessment_all_approval_appraisal');
            Route::get('/approval/{id}', [AllApprovalController::class, 'approval'])->name('assessment_all_approval_approval');
            Route::get('/final/{id}', [AllApprovalController::class, 'finalis'])->name('assessment_all_approval_final');
            Route::get('/reject/{id}',  [AllApprovalController::class, 'reject_kpi'])->name('assessment_all_approval_reject');
            Route::post('/save_appraisal', [AllApprovalController::class, 'save_appraisal'])->name('assessment_all_approval_save_appraisal');

            Route::post('/save', [AllApprovalController::class, 'save'])->name('assessment_all_approval_save');
            Route::post('/reject', [AllApprovalController::class, 'reject'])->name('assessment_all_approval_reject_kpi');

            Route::post('/save_comment', [AllApprovalController::class, 'save_comment'])->name('assessment_all_approval_save_comment');
            Route::get('/show_comment', [AllApprovalController::class, 'show_comment'])->name('assessment_all_approval_show_comment');

            Route::get('/save_comment_kra', [AllApprovalController::class, 'save_comment_kra'])->name('assessment_all_approval_save_comment_kra');
            Route::get('/show_comment_kra', [AllApprovalController::class, 'show_comment_kra'])->name('assessment_all_approval_show_comment_kra');

            Route::get('/save_comment_goal', [AllApprovalController::class, 'save_comment_goal'])->name('assessment_all_approval_save_comment_goal');
            Route::get('/show_comment_goal', [AllApprovalController::class, 'show_comment_goal'])->name('assessment_all_approval_show_comment_goal');

            Route::get('/save_comment_date', [AllApprovalController::class, 'save_comment_date'])->name('assessment_all_approval_save_comment_date');
            Route::get('/show_comment_date', [AllApprovalController::class, 'show_comment_date'])->name('assessment_all_approval_show_comment_date');

            Route::get('/assessment_all_approval_kpi_team_all_services', [AllApprovalController::class, 'assessment_all_approval_kpi_team_all_services'])->name('assessment_all_approval_kpi_team_all_services');
            Route::get('/filter_all_services_datatables', [AllApprovalController::class, 'filter_all_services_datatables'])->name('filter_all_services_datatables');

            Route::get('/assessment_all_approval_kpi_team_all_asset', [AllApprovalController::class, 'assessment_all_approval_kpi_team_all_asset'])->name('assessment_all_approval_kpi_team_all_asset');
            Route::get('/filter_all_asset_datatable', [AllApprovalController::class, 'filter_all_asset_datatable'])->name('filter_all_asset_datatable');
            Route::get('/assessment_all_approval_kpi_team_gempol_asset', [AllApprovalController::class, 'assessment_all_approval_kpi_team_gempol_asset'])->name('assessment_all_approval_kpi_team_gempol_asset');
            Route::get('/filter_gmp_asset_datatables', [AllApprovalController::class, 'filter_gmp_asset_datatables'])->name('filter_gmp_asset_datatables');
            Route::get('/assessment_all_approval_kpi_team_jakarta_asset', [AllApprovalController::class, 'assessment_all_approval_kpi_team_jakarta_asset'])->name('assessment_all_approval_kpi_team_jakarta_asset');
            Route::get('/filter_jkt_asset_datatables', [AllApprovalController::class, 'filter_jkt_asset_datatables'])->name('filter_jkt_asset_datatables');
            Route::get('/assessment_all_approval_kpi_team_kediri_asset', [AllApprovalController::class, 'assessment_all_approval_kpi_team_kediri_asset'])->name('assessment_all_approval_kpi_team_kediri_asset');
            Route::get('/filter_kdr_asset_datatables', [AllApprovalController::class, 'filter_kdr_asset_datatables'])->name('filter_kdr_asset_datatables');
            Route::get('/assessment_all_approval_kpi_team_surabaya_asset', [AllApprovalController::class, 'assessment_all_approval_kpi_team_surabaya_asset'])->name('assessment_all_approval_kpi_team_surabaya_asset');
            Route::get('/filter_sby_asset_datatables', [AllApprovalController::class, 'filter_sby_asset_datatables'])->name('filter_sby_asset_datatables');

            Route::get('/assessment_all_approval_kpi_team_jakarta_helpdesk', [AllApprovalController::class, 'assessment_all_approval_kpi_team_jakarta_helpdesk'])->name('assessment_all_approval_kpi_team_jakarta_helpdesk');
            Route::get('/filter_jkt_helpdesk_datatables', [AllApprovalController::class, 'filter_jkt_helpdesk_datatables'])->name('filter_jkt_helpdesk_datatables');

            Route::get('/assessment_all_approval_kpi_team_all_support', [AllApprovalController::class, 'assessment_all_approval_kpi_team_all_support'])->name('assessment_all_approval_kpi_team_all_support');
            Route::get('/filter_all_support_datatables', [AllApprovalController::class, 'filter_all_support_datatables'])->name('filter_all_support_datatables');

            Route::get('/assessment_all_approval_kpi_team_gempol_support', [AllApprovalController::class, 'assessment_all_approval_kpi_team_gempol_support'])->name('assessment_all_approval_kpi_team_gempol_support');
            Route::get('/filter_gmp_support_datatables', [AllApprovalController::class, 'filter_gmp_support_datatables'])->name('filter_gmp_support_datatables');

            Route::get('/assessment_all_approval_kpi_team_jakarta_support', [AllApprovalController::class, 'assessment_all_approval_kpi_team_jakarta_support'])->name('assessment_all_approval_kpi_team_jakarta_support');
            Route::get('/filter_jkt_support_datatables', [AllApprovalController::class, 'filter_jkt_support_datatables'])->name('filter_jkt_support_datatables');

            Route::get('/assessment_all_approval_kpi_team_kediri_support', [AllApprovalController::class, 'assessment_all_approval_kpi_team_kediri_support'])->name('assessment_all_approval_kpi_team_kediri_support');
            Route::get('/filter_kdr_support_datatables', [AllApprovalController::class, 'filter_kdr_support_datatables'])->name('filter_kdr_support_datatables');

            Route::get('/assessment_all_approval_kpi_team_surabaya_support', [AllApprovalController::class, 'assessment_all_approval_kpi_team_surabaya_support'])->name('assessment_all_approval_kpi_team_surabaya_support');
            Route::get('/filter_sby_support_datatables', [AllApprovalController::class, 'filter_sby_support_datatables'])->name('filter_sby_support_datatables');

            Route::get('/assessment_all_approval_review_kpi_team_all_services', [AllApprovalController::class, 'assessment_all_approval_review_kpi_team_all_services'])->name('assessment_all_approval_review_kpi_team_all_services');
            Route::get('/filter_review_all_it_services_datatables', [AllApprovalController::class, 'filter_review_all_it_services_datatables'])->name('filter_review_all_it_services_datatables');

            Route::get('/assessment_all_approval_review_kpi_team_jakarta_helpdesk', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_jakarta_helpdesk'])->name('assessment_all_approval_review_kpi_team_jakarta_helpdesk');

            Route::get('/assessment_all_approval_review_kpi_team_jakarta_support', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_jakarta_support'])->name('assessment_all_approval_review_kpi_team_jakarta_support');
            Route::get('/assessment_all_approval_review_kpi_team_support_kediri', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_support_kediri'])->name('assessment_all_approval_review_kpi_team_support_kediri');

            Route::get('/assessment_all_approval_review_kpi_team_asset_kediri', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_asset_kediri'])->name('assessment_all_approval_review_kpi_team_asset_kediri');
            Route::get('/assessment_all_approval_review_kpi_team_surabaya_support', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_surabaya_support'])->name('assessment_all_approval_review_kpi_team_surabaya_support');
            Route::get('/assessment_all_approval_review_kpi_team_support_gempol', [AllReviewController::class, 'assessment_all_approval_review_kpi_team_support_gempol'])->name('assessment_all_approval_review_kpi_team_support_gempol');
        });
        Route::prefix('kpi_collaboration')->group(function () {
            Route::get('/', [KpiCollaborationsController::class, 'index'])->name('kpi_collaboration');
            Route::get('/datatables', [KpiCollaborationsController::class, 'kpi_collaboration_datatable'])->name('kpi_collaboration_datatable');
            Route::get('/active_collab/{id}', [KpiCollaborationsController::class, 'active_collab'])->name('assessment_kpi_active_collab');
            Route::post('/update_file', [KpiCollaborationsController::class, 'update_file'])->name('assessment_kpi_update_file');
            Route::post('/save_after_approve', [KpiCollaborationsController::class, 'save_after_approve'])->name('assessment_kpi_save_after_approve');
            Route::get('/checking_file', [KpiCollaborationsController::class, 'checking_file'])->name('assessment_kpi_checking_file');
            Route::post('/update_status_to_complete', [KpiCollaborationsController::class, 'update_status_to_complete'])->name('assessment_all_approval_update_status_to_complete');
        });
        Route::prefix('assessment_target')->group(function () {
            Route::get('/', [TargetController::class, 'index'])->name('assessment_target');
            Route::get('/create', [TargetController::class, 'create'])->name('assessment_target_create');
            Route::post('/save', [TargetController::class, 'save'])->name('assessment_target_save');
            Route::get('/show',  [TargetController::class, 'show'])->name('assessment_target_view');
            Route::get('/edit', [TargetController::class, 'edit'])->name('assessment_target_edit');
            Route::post('/update', [TargetController::class, 'update'])->name('assessment_target_update');
            Route::get('/deletes', [TargetController::class, 'deletes'])->name('assessment_target_delete');
        });
        Route::prefix('assessment_enhancement')->group(function () {
            Route::get('/', [EnhancementController::class, 'index'])->name('assessment_enhancement');
            Route::get('/create', [EnhancementController::class, 'create'])->name('assessment_enhancement_create');
            Route::get('/edit', [EnhancementController::class, 'edit'])->name('assessment_enhancement_edit');
            Route::get('/show', [EnhancementController::class, 'show'])->name('assessment_enhancement_view');
            Route::post('/save', [EnhancementController::class, 'save'])->name('assessment_enhancement_save');
            Route::post('/publish', [EnhancementController::class, 'publish'])->name('assessment_enhancement_publish');
            Route::post('/update', [EnhancementController::class, 'update'])->name('assessment_enhancement_update');
        });
        Route::prefix('assessment_all_review')->group(function () {
            Route::get('/assessment_all_review_kpi_team_all_asset', [AllReviewController::class, 'assessment_all_review_kpi_team_all_asset'])->name('assessment_all_review_kpi_team_all_asset');
            Route::get('/assessment_all_review_kpi_team_all_support', [AllReviewController::class, 'assessment_all_review_kpi_team_all_support'])->name('assessment_all_review_kpi_team_all_support');
        });

        Route::get('/assessment_audit', [AuditController::class, 'index'])->name('assessment_audit');
        Route::get('/assessment_audit_reminder', [AuditController::class, 'reminder'])->name('assessment_audit_reminder');

        Route::get('/assessment_all_approval_datatables', [AllApprovalController::class, 'assessment_all_approval_datatables'])->name('assessment_all_approval_datatables');
    });

    Route::get('/all_report', [AllReportController::class, 'all_report'])->name('all_report');
    Route::get('/all_report_asset_coor_kediri', fn () => 1)->name('all_report_asset_coor_kediri');
    Route::get('/all_report_asset_lead', [AllReportController::class, 'all_report_asset_lead'])->name('all_report_asset_lead');
    Route::get('/all_report_helpdesk_coor_jakarta', fn () => 1)->name('all_report_helpdesk_coor_jakarta');
    Route::get('/all_report_itmanager', [AllReportController::class, 'all_report_itmanager'])->name('all_report_itmanager');
    Route::get('/cari_tahun_report_kpi_manager', [AllReportController::class, 'cari_tahun_report_kpi_manager'])->name('cari_tahun_report_kpi_manager');
    Route::get('/all_report_lead_support_chart', [AllReportController::class, 'all_report_lead_support_chart'])->name('all_report_lead_support_chart');
    Route::get('/all_report_lead_support_chart/cari-unit', [AllReportController::class, 'all_report_lead_support_chart_cari_unit'])->name('all_report_lead_support_chart_cari_unit');
    Route::get('/all_report_manager_chart', [AllReportController::class, 'all_report_manager_chart'])->name('all_report_manager_chart');
    Route::get('/all_report_manager_chart/cari_unit', [AllReportController::class, 'all_report_manager_chart_cari_unit'])->name('all_report_manager_chart_cari_unit');
    Route::get('/all_report_support_coor_jakarta', fn () => 1)->name('all_report_support_coor_jakarta');
    Route::get('/all_report_support_coor_kediri', fn () => 1)->name('all_report_support_coor_kediri');
    Route::get('/all_report_support_coor_surabaya', [AllReportController::class, 'all_report_support_coor_surabaya'])->name('all_report_support_coor_surabaya');
    Route::get('/all_report_support_surabaya_chart/cari_unit', [AllReportController::class, 'all_report_coor_sby_chart_cari_unit'])->name('all_report_coor_sby_chart_cari_unit');
    Route::get('/all_report_support_coor_gempol', fn () => 1)->name('all_report_support_coor_gempol');

    Route::get('/specialist_report', [AllReportController::class, 'specialist_report'])->name('specialist_report');
    Route::get('/filter_specialist_report_chart', [AllReportController::class, 'filter_specialist_report_chart'])->name('filter_specialist_report_chart');
    Route::get('/specialist_report_chart', [AllReportController::class, 'specialist_report_chart'])->name('specialist_report_chart');

    Route::get('/report/report_panduan', [AllReportController::class, 'panduan'])->name('report_panduan');
});
