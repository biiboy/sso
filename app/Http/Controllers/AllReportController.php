<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllReportController extends Controller
{
    public function all_report_itmanager(Request $request)
    {
        $userunit = DB::table('d_unit')
            ->where('u_id', auth()->user()->m_unit)
            ->first();
        $year = DB::table('d_periode')->get();

        if ($userunit->u_flag == 1) {
            $flag = 'IT Helpdesk';
        } elseif ($userunit->u_flag == 3) {
            $flag = 'IT Asset';
        } elseif ($userunit->u_flag == 2) {
            $flag = 'IT Support';
        } elseif ($userunit->u_flag == 4) {
            $flag = 'Manager';
        } elseif ($userunit->u_flag == 0) {
            $flag = 'Administrator';
        }

        $id = $request->id;

        $all_site = DB::select('
        SELECT m_name,s_name,u_name,m_id,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "N/A" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NA,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "Unacceptable" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Unacceptable,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "NI" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NI,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "Good" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Good,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "Outstanding" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Outstanding,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = "Outstanding" and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as ttl,

        (SELECT COUNT(a_kpi.k_id) FROM a_kpi where k_created_by = m_id and (a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3 OR a_kpi.k_status_id = 11 OR a_kpi.k_status_id = 14 OR a_kpi.k_status_id = 17) group by k_created_by) as ttl_kpi
        -- (SELECT SUM(a_kpi.k_finalresult) FROM a_kpi group by k_created_by) as ttl
        FROM a_kpi
        join d_mem on m_id=k_created_by
        join d_site on s_id=k_site
        JOIN d_unit ON u_id=m_unit
        -- join d_unit on u_id=k_unit
        where a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3
        GROUP BY m_name,s_name,u_name,m_id
        ');

        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Report > All IT Services',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.all_site_manager', compact('id', 'all_site', 'flag', 'year'));
    }

    public function cari_tahun_report_kpi_manager(Request $request)
    {
        if ($request->tahun == 'ALL') {
            $tahun = '';
        } else {
            $tahun = "and year(k_targetdate) = '$request->tahun'";
        }

        $id_mem = auth()->user()->m_id;
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = '';
            } else {
                $unit = '';
            }
        } elseif (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        } elseif (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        } elseif (auth()->user()->m_flag == 4) {
            $unit = "and m_specialist = $id_mem";
        }
        // return $unit;
        $id = $request->id;
        if ($id == null || $id == 'ALL') {
            $ids = '';
        } else {
            $ids = "and s_name = '$id'";
        }
        $userunit = DB::table('d_unit')
            ->where('u_id', auth()->user()->m_unit)
            ->first();

        if ($userunit->u_flag == 1) {
            $flag = 'IT Helpdesk';
        } elseif ($userunit->u_flag == 3) {
            $flag = 'IT Asset';
        } elseif ($userunit->u_flag == 2) {
            $flag = 'IT Support';
        } elseif ($userunit->u_flag == 4) {
            $flag = 'Manager';
        } elseif ($userunit->u_flag == 0) {
            $flag = 'Administrator';
        }

        $all_site = DB::select("
        SELECT m_name,s_name,m_id,u_name,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id $tahun group by k_created_by) as NA,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id $tahun group by k_created_by) as Unacceptable,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id $tahun group by k_created_by) as NI,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id $tahun group by k_created_by) as Good,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id $tahun group by k_created_by) as Outstanding,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id  $tahun group by k_created_by)  as ttl,
        (SELECT COUNT(a_kpi.k_id) FROM a_kpi where k_created_by = m_id and (a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3 OR a_kpi.k_status_id = 11 OR a_kpi.k_status_id = 14 OR a_kpi.k_status_id = 17) $tahun group by k_created_by) as ttl_kpi
        FROM a_kpi
        join d_mem on m_id=k_created_by
        join d_site on s_id=k_site
        join d_unit on m_unit=u_id
        where (a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3) $tahun $ids $unit
        GROUP BY m_name,s_name,m_id,u_name
        ");

        return view('report.kpi.hasil_cari_manager', compact('id', 'all_site', 'flag'));
    }

    public function all_report_manager_chart(Request $request)
    {
        // GEMPOL
        $year = DB::table('d_periode')->get();

        // Asset Gempol
        $totalna_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        // Total Details Denok
        $totaloutstanding_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalna_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalunacceptable_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalni_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalgood_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalall_denok = $totaloutstanding_denok + $totalna_denok + $totalunacceptable_denok + $totalni_denok + $totalgood_denok;

        // Total Details Yudi
        $totaloutstanding_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalna_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalunacceptable_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalni_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalgood_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');

        $totalall_yudi = $totaloutstanding_yudi + $totalna_yudi + $totalunacceptable_yudi + $totalni_yudi + $totalgood_yudi;

        // Total Details Ucis
        $totaloutstanding_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalna_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalunacceptable_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalni_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalgood_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');

        $totalall_ucis = $totaloutstanding_ucis + $totalna_ucis + $totalunacceptable_ucis + $totalni_ucis + $totalgood_ucis;

        // Total Details Lukman
        $totaloutstanding_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalna_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalunacceptable_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalni_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalgood_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');

        $totalall_lukman = $totaloutstanding_lukman + $totalna_lukman + $totalunacceptable_lukman + $totalni_lukman + $totalgood_lukman;

        // Total Details Ical
        $totaloutstanding_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalna_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalunacceptable_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalni_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalgood_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');

        $totalall_ical = $totaloutstanding_ical + $totalna_ical + $totalunacceptable_ical + $totalni_ical + $totalgood_ical;

        // Total Details Hendra
        $totaloutstanding_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalna_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalunacceptable_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalni_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalgood_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');

        $totalall_hendra = $totaloutstanding_hendra + $totalna_hendra + $totalunacceptable_hendra + $totalni_hendra + $totalgood_hendra;

        $totalassetgempol = $totalna_assetsgempol + $totalunacceptable_assetsgempol + $totalni_assetsgempol + $totalgood_assetsgempol + $totaloutstanding_assetsgempol;

        // Asset Jakarta
        $totalna_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalassetjakarta = $totalna_assetsjakarta + $totalunacceptable_assetsjakarta + $totalni_assetsjakarta + $totalgood_assetsjakarta + $totaloutstanding_assetsjakarta;
        // Total Details Wellma
        $totaloutstanding_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalna_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalunacceptable_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalni_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalgood_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalall_wellma = $totaloutstanding_wellma + $totalna_wellma + $totalunacceptable_wellma + $totalni_wellma + $totalgood_wellma;

        // Total Details Marien
        $totaloutstanding_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalna_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalunacceptable_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalni_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalgood_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalall_marien = $totaloutstanding_marien + $totalna_marien + $totalunacceptable_marien + $totalni_marien + $totalgood_marien;

        // Total Details Charis
        $totaloutstanding_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalna_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalunacceptable_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalni_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalgood_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalall_charis = $totaloutstanding_charis + $totalna_charis + $totalunacceptable_charis + $totalni_charis + $totalgood_charis;

        // Total Details Santi
        $totaloutstanding_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalna_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalunacceptable_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalni_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalgood_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalall_santi = $totaloutstanding_santi + $totalna_santi + $totalunacceptable_santi + $totalni_santi + $totalgood_santi;

        // Helpdesk Jakarta
        $totalna_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalhdjakarta = $totalna_helpdeskjakarta + $totalunacceptable_helpdeskjakarta + $totalni_helpdeskjakarta + $totalgood_helpdeskjakarta + $totaloutstanding_helpdeskjakarta;

        // Helpdesk Dana
        $totalna_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalunacceptable_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalni_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalgood_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totaloutstanding_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalall_dana = $totalna_dana + $totalunacceptable_dana + $totalni_dana + $totalgood_dana + $totaloutstanding_dana;

        // Helpdesk Serny
        $totalna_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalunacceptable_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalni_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalgood_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totaloutstanding_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalall_serny = $totalna_serny + $totalunacceptable_serny + $totalni_serny + $totalgood_serny + $totaloutstanding_serny;

        // Helpdesk Ambar
        $totalna_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalunacceptable_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalni_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalgood_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totaloutstanding_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalall_ambar = $totalna_ambar + $totalunacceptable_ambar + $totalni_ambar + $totalgood_ambar + $totaloutstanding_ambar;

        // Helpdesk Chandra Kusuma
        $totalna_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalunacceptable_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalni_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalgood_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totaloutstanding_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalall_chandra = $totalna_chandra + $totalunacceptable_chandra + $totalni_chandra + $totalgood_chandra + $totaloutstanding_chandra;

        // Helpdesk Dana
        $totalna_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalunacceptable_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalni_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalgood_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totaloutstanding_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalall_nanda = $totalna_nanda + $totalunacceptable_nanda + $totalni_nanda + $totalgood_nanda + $totaloutstanding_nanda;

        // Helpdesk noni
        $totalna_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalunacceptable_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalni_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalgood_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totaloutstanding_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalall_noni = $totalna_noni + $totalunacceptable_noni + $totalni_noni + $totalgood_noni + $totaloutstanding_noni;

        // Helpdesk Novita
        $totalna_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalunacceptable_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalni_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalgood_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totaloutstanding_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalall_novita = $totalna_novita + $totalunacceptable_novita + $totalni_novita + $totalgood_novita + $totaloutstanding_novita;

        // Asset Kediri
        $totalna_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalassetkediri = $totalna_assetskediri + $totalunacceptable_assetskediri + $totalni_assetskediri + $totalgood_assetskediri + $totaloutstanding_assetskediri;

        // Total Details Normi
        $totaloutstanding_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalna_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalunacceptable_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalni_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalgood_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalall_normi = $totaloutstanding_normi + $totalna_normi + $totalunacceptable_normi + $totalni_normi + $totalgood_normi;

        // Total Details Dwi
        $totaloutstanding_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalna_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalunacceptable_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalni_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalgood_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalall_dwi = $totaloutstanding_dwi + $totalna_dwi + $totalunacceptable_dwi + $totalni_dwi + $totalgood_dwi;

        // Total Details Desy
        $totaloutstanding_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalna_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalunacceptable_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalni_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalgood_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalall_desy = $totaloutstanding_desy + $totalna_desy + $totalunacceptable_desy + $totalni_desy + $totalgood_desy;

        // Asset SBY
        $totalna_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalassetsurabaya = $totalna_assetssurabaya + $totalunacceptable_assetssurabaya + $totalni_assetssurabaya + $totalgood_assetssurabaya + $totaloutstanding_assetssurabaya;

        // Total Details Khasan
        $totaloutstanding_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalna_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalunacceptable_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalni_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalgood_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalall_khasan = $totaloutstanding_khasan + $totalna_khasan + $totalunacceptable_khasan + $totalni_khasan + $totalgood_khasan;

        // Support Gempol
        $totalna_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalsupportgempol = $totalna_supportgempol + $totalunacceptable_supportgempol + $totalni_supportgempol + $totalgood_supportgempol + $totaloutstanding_supportgempol;

        // Support Jakarta
        $totalna_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalsupportjakarta = $totalna_supportjakarta + $totalunacceptable_supportjakarta + $totalni_supportjakarta + $totalgood_supportjakarta + $totaloutstanding_supportjakarta;

        // Tjandra Hadiwidjaja
        $totalna_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalunacceptable_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalni_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalgood_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totaloutstanding_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalall_tjandra = $totalna_tjandra + $totalunacceptable_tjandra + $totalni_tjandra + $totalgood_tjandra + $totaloutstanding_tjandra;

        // Filsuf Hidayat
        $totalna_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalunacceptable_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalni_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalgood_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totaloutstanding_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalall_ucup = $totalna_ucup + $totalunacceptable_ucup + $totalni_ucup + $totalgood_ucup + $totaloutstanding_ucup;

        // Tri MArgiono
        $totalna_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalunacceptable_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalni_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalgood_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totaloutstanding_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalall_tri = $totalna_tri + $totalunacceptable_tri + $totalni_tri + $totalgood_tri + $totaloutstanding_tri;

        // Tjahyadi Wijaya
        $totalna_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalunacceptable_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalni_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalgood_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totaloutstanding_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalall_chacha = $totalna_chacha + $totalunacceptable_chacha + $totalni_chacha + $totalgood_chacha + $totaloutstanding_chacha;

        // Gilang Tresna
        $totalna_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalunacceptable_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalni_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalgood_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totaloutstanding_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalall_gilang = $totalna_gilang + $totalunacceptable_gilang + $totalni_gilang + $totalgood_gilang + $totaloutstanding_gilang;

        // Vincentius Henry
        $totalna_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalunacceptable_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalni_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalgood_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totaloutstanding_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalall_vhenry = $totalna_vhenry + $totalunacceptable_vhenry + $totalni_vhenry + $totalgood_vhenry + $totaloutstanding_vhenry;

        // Febri Dwi Santoso
        $totalna_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalunacceptable_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalni_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalgood_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totaloutstanding_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalall_febrids = $totalna_febrids + $totalunacceptable_febrids + $totalni_febrids + $totalgood_febrids + $totaloutstanding_febrids;

        // Rony Febriadi
        $totalna_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalunacceptable_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalni_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalgood_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totaloutstanding_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalall_rfebriadi = $totalna_rfebriadi + $totalunacceptable_rfebriadi + $totalni_rfebriadi + $totalgood_rfebriadi + $totaloutstanding_rfebriadi;

        // Abdus Shahrir Rozaq
        $totalna_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalunacceptable_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalni_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalgood_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totaloutstanding_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalall_arozaq = $totalna_arozaq + $totalunacceptable_arozaq + $totalni_arozaq + $totalgood_arozaq + $totaloutstanding_arozaq;

        // Bondan Handoko
        $totalna_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalunacceptable_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalni_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalgood_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totaloutstanding_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalall_bhandoko = $totalna_bhandoko + $totalunacceptable_bhandoko + $totalni_bhandoko + $totalgood_bhandoko + $totaloutstanding_bhandoko;

        // Support Kediri
        $totalna_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalsupportkediri = $totalna_supportkediri + $totalunacceptable_supportkediri + $totalni_supportkediri + $totalgood_supportkediri + $totaloutstanding_supportkediri;

        // Hendrian Rajitama
        $totalna_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalunacceptable_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalni_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalgood_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totaloutstanding_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalall_hendrianr = $totalna_hendrianr + $totalunacceptable_hendrianr + $totalni_hendrianr + $totalgood_hendrianr + $totaloutstanding_hendrianr;

        // Stifanus Benny Sabdiyanto
        $totalna_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalunacceptable_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalni_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalgood_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totaloutstanding_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalall_ssabdiyanto = $totalna_ssabdiyanto + $totalunacceptable_ssabdiyanto + $totalni_ssabdiyanto + $totalgood_ssabdiyanto + $totaloutstanding_ssabdiyanto;

        // Rendra Yuwowono
        $totalna_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalunacceptable_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalni_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalgood_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totaloutstanding_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalall_ryuwono01 = $totalna_ryuwono01 + $totalunacceptable_ryuwono01 + $totalni_ryuwono01 + $totalgood_ryuwono01 + $totaloutstanding_ryuwono01;

        // Reza
        $totalna_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalunacceptable_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalni_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalgood_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totaloutstanding_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalall_liemrjw = $totalna_liemrjw + $totalunacceptable_liemrjw + $totalni_liemrjw + $totalgood_liemrjw + $totaloutstanding_liemrjw;

        // Alief
        $totalna_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalunacceptable_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalni_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalgood_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totaloutstanding_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalall_aliefgaf = $totalna_aliefgaf + $totalunacceptable_aliefgaf + $totalni_aliefgaf + $totalgood_aliefgaf + $totaloutstanding_aliefgaf;

        // Afib
        $totalna_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalunacceptable_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalni_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalgood_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totaloutstanding_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalall_afiba = $totalna_afiba + $totalunacceptable_afiba + $totalni_afiba + $totalgood_afiba + $totaloutstanding_afiba;

        // aditya
        $totalna_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalunacceptable_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalni_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalgood_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totaloutstanding_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalall_adityad = $totalna_adityad + $totalunacceptable_adityad + $totalni_adityad + $totalgood_adityad + $totaloutstanding_adityad;

        // abrahamk
        $totalna_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalunacceptable_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalni_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalgood_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totaloutstanding_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalall_abrahamk = $totalna_abrahamk + $totalunacceptable_abrahamk + $totalni_abrahamk + $totalgood_abrahamk + $totaloutstanding_abrahamk;

        // sigids
        $totalna_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalunacceptable_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalni_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalgood_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totaloutstanding_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalall_sigids = $totalna_sigids + $totalunacceptable_sigids + $totalni_sigids + $totalgood_sigids + $totaloutstanding_sigids;

        // Support Surabaya
        $totalna_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalsupportsurabaya = $totalna_supportsurabaya + $totalunacceptable_supportsurabaya + $totalni_supportsurabaya + $totalgood_supportsurabaya + $totaloutstanding_supportsurabaya;

        // Total NA Services
        // Total keseluruhan

        $totalna_services = $totalna_assetsgempol + $totalna_assetsjakarta + $totalna_helpdeskjakarta + $totalna_assetskediri + $totalna_assetssurabaya + $totalna_supportgempol + $totalna_supportjakarta + $totalna_supportkediri + $totalna_supportsurabaya;

        $totalunacceptable_services = $totalunacceptable_assetsgempol + $totalunacceptable_assetsjakarta + $totalunacceptable_helpdeskjakarta + $totalunacceptable_assetskediri + $totalunacceptable_assetssurabaya + $totalunacceptable_supportgempol + $totalunacceptable_supportjakarta + $totalunacceptable_supportkediri + $totalunacceptable_supportsurabaya;

        $totalni_services = $totalni_assetsgempol + $totalni_assetsjakarta + $totalni_helpdeskjakarta + $totalni_assetskediri + $totalni_assetssurabaya + $totalni_supportgempol + $totalni_supportjakarta + $totalni_supportkediri + $totalni_supportsurabaya;

        $totalgood_services = $totalgood_assetsgempol + $totalgood_assetsjakarta + $totalgood_helpdeskjakarta + $totalgood_assetskediri + $totalgood_assetssurabaya + $totalgood_supportgempol + $totalgood_supportjakarta + $totalgood_supportkediri + $totalgood_supportsurabaya;

        $totaloutstanding_services = $totaloutstanding_assetsgempol + $totaloutstanding_assetsjakarta + $totaloutstanding_helpdeskjakarta + $totaloutstanding_assetskediri + $totaloutstanding_assetssurabaya + $totaloutstanding_supportgempol + $totaloutstanding_supportjakarta + $totaloutstanding_supportkediri + $totaloutstanding_supportsurabaya;

        if ($request->tahun == 'ALL') {
            $tahun = '';
        } else {
            $tahun = "and k_targetdate like '%$request->tahun%'";
        }
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = '';
            }
        }
        if (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        }
        $id_mem = auth()->user()->m_id;
        if (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        }
        // $id = $request->id;
        $menu = DB::table('d_menu')->get();
        $site = DB::table('d_site')->get();
        $year = DB::table('d_periode')->get();

        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $gmpl_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 1 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        //peubahan chart
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $sby_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $jkt_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $kdr_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 4 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }

        $total_sby = 0;
        $total_gmpl = 0;
        $total_jkt = 0;
        $total_kdr = 0;
        // return $total_gmpl;
        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $all_site = [$total_gmpl, $total_jkt, $total_kdr, $total_sby];

        $dt2020 = DB::table('a_kpi')
            ->selectRaw(DB::raw('count(k_site) as user_count'))
            ->groupBy('k_site')
            ->whereYear('k_targetdate', '2020')
            ->orderBy('k_site', 'ASC')
            ->get();

        $site = ['1', '3', '4', '2'];
        // $color = ['#868e96','#ff3300','#f9ed09','#00b300','blue'];
        $color = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        $color_nilai = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        // $color_nilai = ['#868e96','#ef6e6e','#ffbc34','#4798e8','##22c6ab'];
        $unit_as = ['3', '2'];
        $unit_has = ['3', '1', '2'];
        $unit_has_bawah = ['3', '2', '1'];
        $unit_as_text = ['Asset', 'Support'];
        $unit_has_text = ['Asset', 'Helpdesk', 'Support'];
        $nilai = ['N/A', 'Unacceptable', 'NI', 'Good', 'Outstanding'];
        // COLUMN ATAS
        // index ke 1
        for ($i = 0; $i < count($site); $i++) {
            $chart_index_awal[$i] = DB::table('a_kpi')
                ->where('k_status_id', 3)
                ->where('k_site', $site[$i])
                // ->whereYear('k_targetdate',date('Y'))
                ->count('k_id');
        }
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            }
        }
        //index ke 3
        for ($j = 0; $j < count($site); $j++) {
            if ($site[$j] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_as[$k])
                            ->count('k_id');
                    }
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_has[$k])
                            ->count('k_id');
                    }
                }
            }
        }
        // COLUMN BAWAH
        // index ke 1
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            }
        }
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_id')
                        ->get();
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_name')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_id')
                        ->get();
                }
            }
        }
        // return $chart_index_kedua_bawah;
        $dt = [];
        foreach ($site as $i => $value) {
            foreach ($chart_index_kedua_bawah as $i1 => $value1) {
                $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                $array_support[$i] = $chart_index_kedua_bawah[$i][1];
                $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][1];
            }
        }
        // return $array_asset;
        $array_helpdesk = $chart_index_kedua_bawah[1][2];
        $array_helpdesk_id = $chart_index_kedua_bawah_id[1][2];

        for ($i = 0; $i < count($array_asset_id); $i++) {
            for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                $chart_index_kedua_bawah_count_asset[$i][$k] = DB::table('a_kpi')
                    ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                    ->where('k_status_id', 3)
                    ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                    ->count('k_id');
            }
        }
        for ($i = 0; $i < count($array_support_id); $i++) {
            for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                $chart_index_kedua_bawah_count_support[$i][$k] = DB::table('a_kpi')
                    ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                    ->where('k_status_id', 3)
                    ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                    ->count('k_id');
            }
        }
        for ($i = 0; $i < count($array_helpdesk_id); $i++) {
            $chart_index_kedua_bawah_count_helpdesk[$i] = DB::table('a_kpi')
                ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                ->where('k_status_id', 3)
                ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                ->count('k_id');
        }

        for ($i = 0; $i < count($array_asset_id); $i++) {
            for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = DB::table('a_kpi')
                        ->where('k_finalresult_text', '=', $nilai[$j])
                        ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                        ->where('k_status_id', 3)
                        ->count('k_id');
                }
            }
        }

        for ($i = 0; $i < count($array_helpdesk_id); $i++) {
            for ($j = 0; $j < count($nilai); $j++) {
                $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = DB::table('a_kpi')
                    ->where('k_finalresult_text', '=', $nilai[$j])
                    ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                    ->where('k_status_id', 3)
                    ->count('k_id');
            }
        }
        // return $chart_index_kedua_bawah_count_nilai_helpdesk;
        for ($i = 0; $i < count($array_support_id); $i++) {
            for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = DB::table('a_kpi')
                        ->where('k_finalresult_text', '=', $nilai[$j])
                        ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                        ->where('k_status_id', 3)
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_kedua_bawah_count_nilai_asset;
        // for ($i=0; $i <count($chart_index_kedua_bawah_count_nilai_asset) ; $i++) {
        //   for ($k=0; $k <count($chart_index_kedua_bawah_count_nilai_asset[$i]) ; $k++) {
        //     for ($j=0; $j <count($chart_index_kedua_bawah_count_nilai_asset[$i][$k]) ; $j++) {
        //       $dt[$i][$k] = $chart_index_kedua_bawah_count_nilai_asset[$i][$k]/*[$j]*/;

        //     }
        //   }
        // }
        // return $dt;

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Report > KPI Chart',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view(
            'report.kpi.chart',
            compact(
                'chart_index_awal',
                'chart_index_kedua',
                'chart_index_ketiga',
                'unit_as',
                'unit_has_text',
                'unit_as_text',
                'menu',
                'color',
                'nilai',
                'chart_index_awal_bawah',
                'color_nilai',
                'chart_index_kedua_bawah_count_asset',
                'chart_index_kedua_bawah_count_support',
                'chart_index_kedua_bawah_count_helpdesk',
                'chart_index_kedua_bawah_count_nilai_asset',
                'array_asset_id',
                'array_support_id',
                'array_helpdesk_id',
                'array_asset',
                'array_support',
                'array_helpdesk',
                'dt2020',
                'site',
                'menu',
                'site',
                'all_site',
                'all_site_name',
                'sby_site',
                'kdr_site',
                'jkt_site',
                'gmpl_site',
                'year',
                'chart_index_kedua_bawah_count_nilai_helpdesk',
                'chart_index_kedua_bawah_count_nilai_support',
                'totalassetgempol',
                'totalassetjakarta',
                'totalhdjakarta',
                'totalassetkediri',
                'totalassetsurabaya',
                'totalsupportgempol',
                'totalsupportjakarta',
                'totalsupportkediri',
                'totalsupportsurabaya',
                'totalunacceptable_services',
                'totalna_services',
                'totalni_services',
                'totalgood_services',
                'totaloutstanding_services',
                'totaloutstanding_assetsgempol',
                'totalgood_assetsgempol',
                'totalni_assetsgempol',
                'totalunacceptable_assetsgempol',
                'totalna_assetsgempol',
                'totaloutstanding_supportgempol',
                'totalgood_supportgempol',
                'totalni_supportgempol',
                'totalunacceptable_supportgempol',
                'totalna_supportgempol',
                'totaloutstanding_assetsjakarta',
                'totalgood_assetsjakarta',
                'totalni_assetsjakarta',
                'totalunacceptable_assetsjakarta',
                'totalna_assetsjakarta',
                'totaloutstanding_helpdeskjakarta',
                'totalgood_helpdeskjakarta',
                'totalni_helpdeskjakarta',
                'totalunacceptable_helpdeskjakarta',
                'totalna_helpdeskjakarta',
                'totaloutstanding_supportjakarta',
                'totalgood_supportjakarta',
                'totalni_supportjakarta',
                'totalunacceptable_supportjakarta',
                'totalna_supportjakarta',
                'totaloutstanding_assetskediri',
                'totalgood_assetskediri',
                'totalni_assetskediri',
                'totalunacceptable_assetskediri',
                'totalna_assetskediri',
                'totaloutstanding_supportkediri',
                'totalgood_supportkediri',
                'totalni_supportkediri',
                'totalunacceptable_supportkediri',
                'totalna_supportkediri',
                'totaloutstanding_assetssurabaya',
                'totalgood_assetssurabaya',
                'totalni_assetssurabaya',
                'totalunacceptable_assetssurabaya',
                'totalna_assetssurabaya',
                'totaloutstanding_supportsurabaya',
                'totalgood_supportsurabaya',
                'totalni_supportsurabaya',
                'totalunacceptable_supportsurabaya',
                'totalna_supportsurabaya',
                'totaloutstanding_denok',
                'totalna_denok',
                'totalunacceptable_denok',
                'totalni_denok',
                'totalgood_denok',
                'totalall_denok',
                'totaloutstanding_yudi',
                'totalna_yudi',
                'totalunacceptable_yudi',
                'totalni_yudi',
                'totalgood_yudi',
                'totaloutstanding_wellma',
                'totalna_wellma',
                'totalunacceptable_wellma',
                'totalni_wellma',
                'totalgood_wellma',
                'totalall_wellma',
                'totalall_marien',
                'totaloutstanding_marien',
                'totalna_marien',
                'totalunacceptable_marien',
                'totalni_marien',
                'totalgood_marien',
                'totalall_charis',
                'totaloutstanding_charis',
                'totalna_charis',
                'totalunacceptable_charis',
                'totalni_charis',
                'totalgood_charis',
                'totalall_santi',
                'totaloutstanding_santi',
                'totalna_santi',
                'totalunacceptable_santi',
                'totalni_santi',
                'totalgood_santi',
                'totalall_normi',
                'totaloutstanding_normi',
                'totalna_normi',
                'totalunacceptable_normi',
                'totalni_normi',
                'totalgood_normi',
                'totalall_dwi',
                'totaloutstanding_dwi',
                'totalna_dwi',
                'totalunacceptable_dwi',
                'totalni_dwi',
                'totalgood_dwi',
                'totalall_desy',
                'totaloutstanding_desy',
                'totalna_desy',
                'totalunacceptable_desy',
                'totalni_desy',
                'totalgood_desy',
                'totalall_khasan',
                'totaloutstanding_khasan',
                'totalna_khasan',
                'totalunacceptable_khasan',
                'totalni_khasan',
                'totalgood_khasan',
                'totalall_dana',
                'totalna_dana',
                'totalunacceptable_dana',
                'totalni_dana',
                'totalgood_dana',
                'totaloutstanding_dana',
                'totalall_serny',
                'totalna_serny',
                'totalunacceptable_serny',
                'totalni_serny',
                'totalgood_serny',
                'totaloutstanding_serny',
                'totalall_ambar',
                'totalna_ambar',
                'totalunacceptable_ambar',
                'totalni_ambar',
                'totalgood_ambar',
                'totaloutstanding_ambar',
                'totalall_chandra',
                'totalna_chandra',
                'totalunacceptable_chandra',
                'totalni_chandra',
                'totalgood_chandra',
                'totaloutstanding_chandra',
                'totalall_nanda',
                'totalna_nanda',
                'totalunacceptable_nanda',
                'totalni_nanda',
                'totalgood_nanda',
                'totaloutstanding_nanda',
                'totalall_noni',
                'totalna_noni',
                'totalunacceptable_noni',
                'totalni_noni',
                'totalgood_noni',
                'totaloutstanding_noni',
                'totalall_novita',
                'totalna_novita',
                'totalunacceptable_novita',
                'totalni_novita',
                'totalgood_novita',
                'totaloutstanding_novita',
                'totalall_yudi',
                'totaloutstanding_yudi',
                'totalna_yudi',
                'totalunacceptable_yudi',
                'totalni_yudi',
                'totalgood_yudi',
                'totalall_ucis',
                'totaloutstanding_ucis',
                'totalna_ucis',
                'totalunacceptable_ucis',
                'totalni_ucis',
                'totalgood_ucis',
                'totalall_lukman',
                'totaloutstanding_lukman',
                'totalna_lukman',
                'totalunacceptable_lukman',
                'totalni_lukman',
                'totalgood_lukman',
                'totalall_ical',
                'totaloutstanding_ical',
                'totalna_ical',
                'totalunacceptable_ical',
                'totalni_ical',
                'totalgood_ical',
                'totalall_hendra',
                'totaloutstanding_hendra',
                'totalna_hendra',
                'totalunacceptable_hendra',
                'totalni_hendra',
                'totalgood_hendra',
                'totalall_tjandra',
                'totalna_tjandra',
                'totalunacceptable_tjandra',
                'totalni_tjandra',
                'totalgood_tjandra',
                'totaloutstanding_tjandra',
                'totalall_ucup',
                'totalna_ucup',
                'totalunacceptable_ucup',
                'totalni_ucup',
                'totalgood_ucup',
                'totaloutstanding_ucup',
                'totalall_tri',
                'totalna_tri',
                'totalunacceptable_tri',
                'totalni_tri',
                'totalgood_tri',
                'totaloutstanding_tri',
                'totalall_chacha',
                'totalna_chacha',
                'totalunacceptable_chacha',
                'totalni_chacha',
                'totalgood_chacha',
                'totaloutstanding_chacha',
                'totalall_gilang',
                'totalna_gilang',
                'totalunacceptable_gilang',
                'totalni_gilang',
                'totalgood_gilang',
                'totaloutstanding_gilang',
                'totalall_febrids',
                'totalna_febrids',
                'totalunacceptable_febrids',
                'totalni_febrids',
                'totalgood_febrids',
                'totaloutstanding_febrids',
                'totalall_rfebriadi',
                'totalna_rfebriadi',
                'totalunacceptable_rfebriadi',
                'totalni_rfebriadi',
                'totalgood_rfebriadi',
                'totaloutstanding_rfebriadi',
                'totalall_arozaq',
                'totalna_arozaq',
                'totalunacceptable_arozaq',
                'totalni_arozaq',
                'totalgood_arozaq',
                'totaloutstanding_arozaq',
                'totalall_bhandoko',
                'totalna_bhandoko',
                'totalunacceptable_bhandoko',
                'totalni_bhandoko',
                'totalgood_bhandoko',
                'totaloutstanding_bhandoko',
                'totalall_hendrianr',
                'totalna_hendrianr',
                'totalunacceptable_hendrianr',
                'totalni_hendrianr',
                'totalgood_hendrianr',
                'totaloutstanding_hendrianr',
                'totalall_ssabdiyanto',
                'totalna_ssabdiyanto',
                'totalunacceptable_ssabdiyanto',
                'totalni_ssabdiyanto',
                'totalgood_ssabdiyanto',
                'totaloutstanding_ssabdiyanto',
                'totalall_ryuwono01',
                'totalna_ryuwono01',
                'totalunacceptable_ryuwono01',
                'totalni_ryuwono01',
                'totalgood_ryuwono01',
                'totaloutstanding_ryuwono01',
                'totalall_liemrjw',
                'totalna_liemrjw',
                'totalunacceptable_liemrjw',
                'totalni_liemrjw',
                'totalgood_liemrjw',
                'totaloutstanding_liemrjw',
                'totalall_aliefgaf',
                'totalna_aliefgaf',
                'totalunacceptable_aliefgaf',
                'totalni_aliefgaf',
                'totalgood_aliefgaf',
                'totaloutstanding_aliefgaf',
                'totalall_afiba',
                'totalna_afiba',
                'totalunacceptable_afiba',
                'totalni_afiba',
                'totalgood_afiba',
                'totaloutstanding_afiba',
                'totalall_adityad',
                'totalna_adityad',
                'totalunacceptable_adityad',
                'totalni_adityad',
                'totalgood_adityad',
                'totaloutstanding_adityad',
                'totalall_abrahamk',
                'totalna_abrahamk',
                'totalunacceptable_abrahamk',
                'totalni_abrahamk',
                'totalgood_abrahamk',
                'totaloutstanding_abrahamk',
                'totalall_sigids',
                'totalna_sigids',
                'totalunacceptable_sigids',
                'totalni_sigids',
                'totalgood_sigids',
                'totaloutstanding_sigids',
                'totalna_vhenry',
                'totalunacceptable_vhenry',
                'totalni_vhenry',
                'totalgood_vhenry',
                'totaloutstanding_vhenry',
                'totalall_vhenry',
            ),
        );
    }

    public function all_report_manager_chart_cari_unit(Request $req)
    {
        $array_asset_id =
            $array_asset =
            $array_support =
            $array_support_id =
            $array_helpdesk_id =
            $chart_index_kedua_bawah_count_nilai_helpdesk =
            $chart_index_kedua_bawah_count_nilai_support =
            $chart_index_kedua_bawah_count_asset =
            $chart_index_kedua_bawah_count_support =
            $chart_index_kedua_bawah_count_helpdesk =
            $chart_index_kedua_bawah_count_nilai_asset = [];
        $nilai = ['N/A', 'Unacceptable', 'NI', 'Good', 'Outstanding'];
        $unit = ['1', '2', '3'];
        $site = ['1', '3', '4', '2'];
        if ($req->tahun != 'all') {
            $year = $req->tahun;
        } else {
            $year = DB::table('d_periode')->get()->toArray();
        }
        // return $year;
        if ($req->unit == 'IT Services') {
            for ($i = 0; $i < count($nilai); $i++) {
                for ($k = 0; $k < count($unit); $k++) {
                    $pie_awal[$i][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            }
                        })
                        ->where('k_finalresult_text', '=', $nilai[$i])
                        ->where('k_status_id', 3)
                        ->where('k_unit', $unit[$k])
                        ->count('k_id');
                }
            }
            for ($i = 0; $i < count($pie_awal); $i++) {
                $pie[$i] = array_sum($pie_awal[$i]);
            }

            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Assets') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 3)
                    ->count('k_id');
            }

            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 3)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
            // return $year;
        } elseif ($req->unit == 'IT Support') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 2)
                    ->count('k_id');
            }

            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 2)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Helpdesk') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 1)
                    ->count('k_id');
            }

            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 1)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        }
        // return $line;

        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $color = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        $color_nilai = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        // $color_nilai = ['#868e96','#ef6e6e','#ffbc34','#4798e8','##22c6ab'];
        if ($req->unit == 'IT Services') {
            $unit_as = ['3', '2'];
            $unit_has = ['3', '1', '2'];
            $unit_has_bawah = ['3', '2', '1'];
            $unit_as_text = ['Asset', 'Support'];
            $unit_has_text = ['Asset', 'Helpdesk', 'Support'];
        } elseif ($req->unit == 'IT Assets') {
            $unit_as = ['3'];
            $unit_has = ['3'];
            $unit_has_bawah = ['3'];
            $unit_as_text = ['Asset'];
            $unit_has_text = ['Asset'];
        } elseif ($req->unit == 'IT Support') {
            $unit_as = ['2'];
            $unit_has = ['2'];
            $unit_has_bawah = ['2'];
            $unit_as_text = ['Support'];
            $unit_has_text = ['Helpdesk'];
        } else {
            $unit_as = [];
            $unit_has = ['1'];
            $unit_has_bawah = ['1'];
            $unit_as_text = [];
            $unit_has_text = ['Helpdesk'];
        }
        for ($i = 0; $i < count($site); $i++) {
            $chart_index_awal[$i] = DB::table('a_kpi')
                ->where('k_status_id', 3)
                ->where('k_site', $site[$i])
                ->where(function ($q) use ($req) {
                    if ($req->unit == 'IT Support') {
                        $q->orWhere('k_unit', 2);
                    } elseif ($req->unit == 'IT Assets') {
                        $q->orWhere('k_unit', 3);
                    } elseif ($req->unit == 'IT Helpdesk') {
                        $q->orWhere('k_unit', 1);
                    } else {
                        $q->orWhere('k_unit', 3);
                        $q->orWhere('k_unit', 1);
                        $q->orWhere('k_unit', 2);
                    }
                })
                ->where(function ($q) use ($req, $year, $p) {
                    if ($req->tahun != 'all') {
                        $q->whereYear('k_targetdate', $req->tahun);
                    } else {
                    }
                })
                ->count('k_id');
        }
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_kedua;
        //index ke 3
        for ($j = 0; $j < count($site); $j++) {
            if ($site[$j] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_as[$k])
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_has[$k])
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        $chart_index_kedua = array_values($chart_index_kedua);
        $chart_index_ketiga = array_values($chart_index_ketiga);

        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_awal_bawah;
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_id')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_id')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                }
            }
        }
        $chart_index_kedua_bawah = array_values($chart_index_kedua_bawah);
        $chart_index_kedua_bawah_id = array_values($chart_index_kedua_bawah_id);
        $dt = [];
        foreach ($site as $i => $value) {
            foreach ($chart_index_kedua_bawah as $i1 => $value1) {
                if ($req->unit == 'IT Services') {
                    $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                    $array_support[$i] = $chart_index_kedua_bawah[$i][1];
                    $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][1];
                } elseif ($req->unit == 'IT Assets') {
                    $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                } elseif ($req->unit == 'IT Support') {
                    $array_support[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                }
            }
        }

        // return count($array_asset[1]);

        if ($req->unit == 'IT Services') {
            $array_helpdesk = $chart_index_kedua_bawah[1][2];
            $array_helpdesk_id = $chart_index_kedua_bawah_id[1][2];
        } else {
            $array_helpdesk = $chart_index_kedua_bawah[0][0];
            $array_helpdesk_id = $chart_index_kedua_bawah_id[0][0];
        }

        if ($req->unit == 'IT Services' || $req->unit == 'IT Assets') {
            for ($i = 0; $i < count($array_asset_id); $i++) {
                if (count($array_asset[$i]) == 0) {
                    $chart_index_kedua_bawah_count_asset[$i][0] = 0;
                } else {
                    for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                        $chart_index_kedua_bawah_count_asset[$i][$k] = DB::table('a_kpi')
                            ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                            ->where('k_status_id', 3)
                            ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }

        if ($req->unit == 'IT Services' || $req->unit == 'IT Support') {
            for ($i = 0; $i < count($array_support_id); $i++) {
                if (count($array_support_id[$i]) == 0) {
                    $chart_index_kedua_bawah_count_support[$i][0] = 0;
                } else {
                    for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                        $chart_index_kedua_bawah_count_support[$i][$k] = DB::table('a_kpi')
                            ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                            ->where('k_status_id', 3)
                            ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        if ($req->unit == 'IT Services' || $req->unit == 'IT Helpdesk') {
            if (count($array_helpdesk_id) == 0) {
                $chart_index_kedua_bawah_count_helpdesk[$i] = 0;
            } else {
                for ($i = 0; $i < count($array_helpdesk_id); $i++) {
                    $chart_index_kedua_bawah_count_helpdesk[$i] = DB::table('a_kpi')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_kedua_bawah_count_helpdesk;
        if ($req->unit == 'IT Services' || $req->unit == 'IT Assets') {
            for ($i = 0; $i < count($array_asset_id); $i++) {
                if (count($array_asset_id[$i]) == 0) {
                    for ($k = 0; $k < 1; $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = 0;
                        }
                    }
                } else {
                    for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = DB::table('a_kpi')
                                ->where('k_finalresult_text', '=', $nilai[$j])
                                ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                                ->where('k_status_id', 3)
                                ->where(function ($q) use ($req, $year, $p) {
                                    if ($req->tahun != 'all') {
                                        $q->whereYear('k_targetdate', $req->tahun);
                                    } else {
                                    }
                                })
                                ->count('k_id');
                        }
                    }
                }
            }
        }
        if ($req->unit == 'IT Services' || $req->unit == 'IT Helpdesk') {
            if (count($array_helpdesk_id) == 0) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = 0;
                }
                $chart_index_kedua_bawah_count_nilai_helpdesk = array_values($chart_index_kedua_bawah_count_nilai_helpdesk);
            } else {
                for ($i = 0; $i < count($array_helpdesk_id); $i++) {
                    for ($j = 0; $j < count($nilai); $j++) {
                        $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$j])
                            ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                            ->where('k_status_id', 3)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        // return $chart_index_kedua_bawah_count_nilai_helpdesk;
        if ($req->unit == 'IT Services' || $req->unit == 'IT Support') {
            for ($i = 0; $i < count($array_support_id); $i++) {
                if (count($array_support_id[$i]) == 0) {
                    for ($k = 0; $k < 1; $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = 0;
                        }
                    }
                } else {
                    for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = DB::table('a_kpi')
                                ->where('k_finalresult_text', '=', $nilai[$j])
                                ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                                ->where('k_status_id', 3)
                                ->where(function ($q) use ($req, $year, $p) {
                                    if ($req->tahun != 'all') {
                                        $q->whereYear('k_targetdate', $req->tahun);
                                    } else {
                                    }
                                })
                                ->count('k_id');
                        }
                    }
                }
            }
        }

        $title = $req->unit;
        $tahun = $req->tahun;
        return view(
            'report.kpi.chart_filter',
            compact(
                'chart_index_awal',
                'chart_index_kedua',
                'chart_index_ketiga',
                'unit_as',
                'unit_has_text',
                'unit_as_text',
                'color',
                'nilai',
                'chart_index_awal_bawah',
                'color_nilai',
                'chart_index_kedua_bawah_count_asset',
                'chart_index_kedua_bawah_count_support',
                'chart_index_kedua_bawah_count_helpdesk',
                'chart_index_kedua_bawah_count_nilai_asset',
                'array_asset_id',
                'array_support_id',
                'array_helpdesk_id',
                'array_asset',
                'array_support',
                'array_helpdesk',
                'site',
                'all_site_name',
                'year',
                'chart_index_kedua_bawah_count_nilai_helpdesk',
                'chart_index_kedua_bawah_count_nilai_support',
                'title',
                'tahun',
                'pie',
                'line',
            ),
        );
    }

    public function all_report_support_coor_surabaya(Request $request)
    {

        // GEMPOL
        $year = DB::table('d_periode')->get()->toArray();

        // Asset Gempol
        $totalna_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalsemuagempol = $totalna_supportgempol + $totalunacceptable_supportgempol + $totalni_supportgempol + $totalgood_supportgempol + $totaloutstanding_supportgempol;

        // Asset Jakarta
        $totalna_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalsemuajakarta = $totalna_supportjakarta + $totalunacceptable_supportjakarta + $totalni_supportjakarta + $totalgood_supportjakarta + $totaloutstanding_supportjakarta;

        // Helpdesk Jakarta
        $totalna_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalhdjakarta = $totalna_helpdeskjakarta + $totalunacceptable_helpdeskjakarta + $totalni_helpdeskjakarta + $totalgood_helpdeskjakarta + $totaloutstanding_helpdeskjakarta;

        // Asset Kediri
        $totalna_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalsemuakediri = $totalna_supportkediri + $totalunacceptable_supportkediri + $totalni_supportkediri + $totalgood_supportkediri + $totaloutstanding_supportkediri;

        // Asset SBY
        $totalna_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalsupportsurabaya = $totalna_supportsurabaya + $totalunacceptable_supportsurabaya + $totalni_supportsurabaya + $totalgood_supportsurabaya + $totaloutstanding_supportsurabaya;

        // Support Gempol
        $totalna_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalsupportgempol = $totalna_supportgempol + $totalunacceptable_supportgempol + $totalni_supportgempol + $totalgood_supportgempol + $totaloutstanding_supportgempol;

        // Support Jakarta
        $totalna_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalsupportjakarta = $totalna_supportjakarta + $totalunacceptable_supportjakarta + $totalni_supportjakarta + $totalgood_supportjakarta + $totaloutstanding_supportjakarta;

        // Support Kediri
        $totalna_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalsupportkediri = $totalna_supportkediri + $totalunacceptable_supportkediri + $totalni_supportkediri + $totalgood_supportkediri + $totaloutstanding_supportkediri;

        // Support Surabaya
        $totalna_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalsemuasurabaya = $totalna_supportsurabaya + $totalunacceptable_supportsurabaya + $totalni_supportsurabaya + $totalgood_supportsurabaya + $totaloutstanding_supportsurabaya;

        $totalna_support = $totalna_supportgempol + $totalna_supportjakarta + $totalna_supportkediri + $totalna_supportsurabaya;
        $totalunacceptable_support = $totalunacceptable_supportgempol + $totalunacceptable_supportjakarta + $totalunacceptable_supportkediri + $totalunacceptable_supportsurabaya;
        $totalni_support = $totalni_supportgempol + $totalni_supportjakarta + $totalni_supportkediri + $totalni_supportsurabaya;
        $totalgood_support = $totalgood_supportgempol + $totalgood_supportjakarta + $totalgood_supportkediri + $totalgood_supportsurabaya;
        $totaloutstanding_support = $totaloutstanding_supportgempol + $totaloutstanding_supportjakarta + $totaloutstanding_supportkediri + $totaloutstanding_supportsurabaya;

        if ($request->tahun == 'ALL') {
            $tahun = "";
        } else {
            $tahun = "and k_targetdate like '%$request->tahun%'";
        }
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = "";
            }
        }
        if (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        }
        $id_mem = auth()->user()->m_id;
        if (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        }
        // $id = $request->id;
        $menu = DB::table('d_menu')->get();
        $site = DB::table('d_site')->get();

        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $gmpl_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 1 AND k_unit = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        //peubahan chart
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $sby_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 2 AND k_unit = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                -- where k_unit = 2
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $jkt_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 3 AND k_unit = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count(is_array($year) ? $year : [$year]); $i++) {
            $t[$i] = $year[$i]->p_year;
            $kdr_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 4 AND k_unit = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }

        $total_sby = 0;
        $total_gmpl = 0;
        $total_jkt = 0;
        $total_kdr = 0;
        // return $total_gmpl;
        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $all_site = [$total_gmpl, $total_jkt, $total_kdr, $total_sby];

        $dt2020 =  DB::table('a_kpi')->selectRaw(DB::raw('count(k_site) as user_count'))
            ->groupBy('k_site')
            ->whereYear('k_targetdate', '2020')
            ->orderBy('k_site', 'ASC')
            ->get();



        $site = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $menu  = DB::table('d_menu')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman All Report',
            'dl_desc' => '' . session('unit') . ' Surabaya',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 3 && auth()->user()->m_unit == 37) {
            return view('report.kpi.chart_coor_support_surabaya', compact(
                'menu',
                'totalna_supportsurabaya',
                'totalunacceptable_supportsurabaya',
                'totalni_supportsurabaya',
                'totalgood_supportsurabaya',
                'totaloutstanding_supportsurabaya',
                'totalsupportsurabaya',
                'year',
                'sby_site'
            ));
        } else {
            return view('page.previlege_not_access');
        }
    }

    public function all_report_coor_sby_chart_cari_unit(Request $req)
    {
        $nilai = ['N/A', 'Unacceptable', 'NI', 'Good', 'Outstanding'];
        $unit = ['1', '2', '3'];
        $site = ['1', '3', '4', '2'];



        if ($req->tahun != 'all') {
            $year = $req->tahun;
        } else {
            $year = DB::table('d_periode')->get()->toArray();
        }
        if ($req->unit == 'IT Service') {
            for ($i = 0; $i < count($nilai); $i++) {
                for ($k = 0; $k < count($unit); $k++) {
                    $pie_awal[$i][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            }
                        })
                        ->where('k_finalresult_text', '=', $nilai[$i])
                        ->where('k_status_id', 3)
                        ->where('k_unit', $unit[$k])
                        ->where('k_site', 2)
                        ->count('k_id');
                }
            }
            for ($i = 0; $i < count($pie_awal); $i++) {
                $pie[$i] = array_sum($pie_awal[$i]);
            }

            for ($i = 0; $i < count($site); $i++) {
                for ($k = 0; $k < count($unit); $k++) {
                    $column[$i][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            }
                        })
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit[$k])
                        ->count('k_id');
                }
            }
            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Assets') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 3)
                    ->where('k_site', 2)
                    ->count('k_id');
            }
            for ($i = 0; $i < count($site); $i++) {
                $column[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_status_id', 3)
                    ->where('k_unit', 3)
                    ->where('k_site', $site[$i])
                    ->count('k_id');
            }
            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 3)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
            // return $year;
        } elseif ($req->unit == 'IT Support') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 2)
                    ->where('k_site', 2)
                    ->count('k_id');
            }
            for ($i = 0; $i < count($site); $i++) {
                $column[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_status_id', 3)
                    ->where('k_unit', 2)
                    ->where('k_site', $site[$i])
                    ->count('k_id');
            }
            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 2)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Helpdesk') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 1)
                    ->where('k_site', 2)
                    ->count('k_id');
            }
            for ($i = 0; $i < count($site); $i++) {
                $column[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_status_id', 3)
                    ->where('k_unit', 1)
                    ->where('k_site', $site[$i])
                    ->count('k_id');
            }
            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 1)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        }

        return response()->json(['pie' => $pie, 'column' => $column, 'line' => $line, 'tittle' => $req->unit, 'tahun' => $req->tahun, 'year' => $year]);
    }

    public function all_report_asset_lead(Request $request)
    {
        // GEMPOL
        $year = DB::table('d_periode')->get();

        // Asset Gempol
        $totalna_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalassetgempol = $totalna_assetsgempol + $totalunacceptable_assetsgempol + $totalni_assetsgempol + $totalgood_assetsgempol + $totaloutstanding_assetsgempol;

        // Asset Jakarta
        $totalna_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalassetjakarta = $totalna_assetsjakarta + $totalunacceptable_assetsjakarta + $totalni_assetsjakarta + $totalgood_assetsjakarta + $totaloutstanding_assetsjakarta;

        // Helpdesk Jakarta
        $totalna_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalhdjakarta = $totalna_helpdeskjakarta + $totalunacceptable_helpdeskjakarta + $totalni_helpdeskjakarta + $totalgood_helpdeskjakarta + $totaloutstanding_helpdeskjakarta;



        // Asset Kediri
        $totalna_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalassetkediri = $totalna_assetskediri + $totalunacceptable_assetskediri + $totalni_assetskediri + $totalgood_assetskediri + $totaloutstanding_assetskediri;

        // Asset SBY
        $totalna_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalassetsurabaya = $totalna_assetssurabaya + $totalunacceptable_assetssurabaya + $totalni_assetssurabaya + $totalgood_assetssurabaya + $totaloutstanding_assetssurabaya;

        // Support Gempol
        $totalna_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalsupportgempol = $totalna_supportgempol + $totalunacceptable_supportgempol + $totalni_supportgempol + $totalgood_supportgempol + $totaloutstanding_supportgempol;

        // Support Jakarta
        $totalna_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalsupportjakarta = $totalna_supportjakarta + $totalunacceptable_supportjakarta + $totalni_supportjakarta + $totalgood_supportjakarta + $totaloutstanding_supportjakarta;

        // Support Kediri
        $totalna_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalsupportkediri = $totalna_supportkediri + $totalunacceptable_supportkediri + $totalni_supportkediri + $totalgood_supportkediri + $totaloutstanding_supportkediri;

        // Support Surabaya
        $totalna_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalsupportsurabaya = $totalna_supportsurabaya + $totalunacceptable_supportsurabaya + $totalni_supportsurabaya + $totalgood_supportsurabaya + $totaloutstanding_supportsurabaya;

        $totalna_assets = $totalna_assetsgempol + $totalna_assetsjakarta + $totalna_assetskediri + $totalna_assetssurabaya;
        $totalunacceptable_assets = $totalunacceptable_assetsgempol + $totalunacceptable_assetsjakarta + $totalunacceptable_assetskediri + $totalunacceptable_assetssurabaya;
        $totalni_assets = $totalni_assetsgempol + $totalni_assetsjakarta + $totalni_assetskediri + $totalni_assetssurabaya;
        $totalgood_assets = $totalgood_assetsgempol + $totalgood_assetsjakarta + $totalgood_assetskediri + $totalgood_assetssurabaya;
        $totaloutstanding_assets = $totaloutstanding_assetsgempol + $totaloutstanding_assetsjakarta + $totaloutstanding_assetskediri + $totaloutstanding_assetssurabaya;

        if ($request->tahun == 'ALL') {
            $tahun = "";
        } else {
            $tahun = "and k_targetdate like '%$request->tahun%'";
        }
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = "";
            }
        }
        if (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        }
        $id_mem = auth()->user()->m_id;
        if (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        }
        // $id = $request->id;
        $menu = DB::table('d_menu')->get();
        $site = DB::table('d_site')->get();
        $year = DB::table('d_periode')->get();

        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $gmpl_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 1 AND k_unit = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        //peubahan chart
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $sby_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 2 AND k_unit = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                -- where k_unit = 3
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $jkt_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 3 AND k_unit = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $kdr_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 4 AND k_unit = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }

        $total_sby = 0;
        $total_gmpl = 0;
        $total_jkt = 0;
        $total_kdr = 0;
        // return $total_gmpl;
        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $all_site = [$total_gmpl, $total_jkt, $total_kdr, $total_sby];

        $dt2020 =  DB::table('a_kpi')->selectRaw(DB::raw('count(k_site) as user_count'))
            ->groupBy('k_site')
            ->whereYear('k_targetdate', '2020')
            ->orderBy('k_site', 'ASC')
            ->get();



        $site = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $menu  = DB::table('d_menu')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Report > KPI Chart ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.chart_lead_asset', compact(
            'menu',
            'dt2020',
            'site',
            'all_site',
            'all_site_name',
            'sby_site',
            'kdr_site',
            'jkt_site',
            'gmpl_site',
            'year',
            'totalgood_assets',
            'totalni_assets',
            'totalna_assets',
            'totalassetgempol',
            'totalassetjakarta',
            'totalhdjakarta',
            'totalassetkediri',
            'totalassetsurabaya',
            'totalsupportgempol',
            'totalsupportjakarta',
            'totalsupportkediri',
            'totalsupportsurabaya',
            'totalna_assets',
            'totalunacceptable_assets',
            'totalni_assets',
            'totalgood_assets',
            'totaloutstanding_assets',
        ));
    }

    public function all_report_lead_support_chart(Request $request)
    {
        // return 'a';

        // GEMPOL
        // GEMPOL
        $year = DB::table('d_periode')->get()->toArray();

        // Asset Gempol
        $totalna_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_assetsgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->count('k_id');

        // Total Details Denok
        $totaloutstanding_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalna_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalunacceptable_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalni_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalgood_denok = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 1)
            ->where('k_created_by', 33)
            ->count('k_id');
        $totalall_denok = $totaloutstanding_denok + $totalna_denok + $totalunacceptable_denok + $totalni_denok + $totalgood_denok;

        // Total Details Yudi
        $totaloutstanding_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalna_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalunacceptable_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalni_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');
        $totalgood_yudi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 28)
            ->count('k_id');

        $totalall_yudi = $totaloutstanding_yudi + $totalna_yudi + $totalunacceptable_yudi + $totalni_yudi + $totalgood_yudi;

        // Total Details Ucis
        $totaloutstanding_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalna_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalunacceptable_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalni_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');
        $totalgood_ucis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 29)
            ->count('k_id');

        $totalall_ucis = $totaloutstanding_ucis + $totalna_ucis + $totalunacceptable_ucis + $totalni_ucis + $totalgood_ucis;

        // Total Details Lukman
        $totaloutstanding_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalna_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalunacceptable_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalni_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');
        $totalgood_lukman = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 30)
            ->count('k_id');

        $totalall_lukman = $totaloutstanding_lukman + $totalna_lukman + $totalunacceptable_lukman + $totalni_lukman + $totalgood_lukman;

        // Total Details Ical
        $totaloutstanding_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalna_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalunacceptable_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalni_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');
        $totalgood_ical = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 31)
            ->count('k_id');

        $totalall_ical = $totaloutstanding_ical + $totalna_ical + $totalunacceptable_ical + $totalni_ical + $totalgood_ical;

        // Total Details Hendra
        $totaloutstanding_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalna_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalunacceptable_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalni_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');
        $totalgood_hendra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->where('k_created_by', 32)
            ->count('k_id');

        $totalall_hendra = $totaloutstanding_hendra + $totalna_hendra + $totalunacceptable_hendra + $totalni_hendra + $totalgood_hendra;

        $totalassetgempol = $totalna_assetsgempol + $totalunacceptable_assetsgempol + $totalni_assetsgempol + $totalgood_assetsgempol + $totaloutstanding_assetsgempol;

        // Asset Jakarta
        $totalna_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_assetsjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->count('k_id');

        $totalassetjakarta = $totalna_assetsjakarta + $totalunacceptable_assetsjakarta + $totalni_assetsjakarta + $totalgood_assetsjakarta + $totaloutstanding_assetsjakarta;
        // Total Details Wellma
        $totaloutstanding_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalna_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalunacceptable_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalni_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalgood_wellma = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalall_wellma = $totaloutstanding_wellma + $totalna_wellma + $totalunacceptable_wellma + $totalni_wellma + $totalgood_wellma;

        // Total Details Marien
        $totaloutstanding_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalna_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalunacceptable_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalni_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalgood_marien = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 43)
            ->count('k_id');
        $totalall_marien = $totaloutstanding_marien + $totalna_marien + $totalunacceptable_marien + $totalni_marien + $totalgood_marien;

        // Total Details Charis
        $totaloutstanding_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalna_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalunacceptable_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalni_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalgood_charis = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 66)
            ->count('k_id');
        $totalall_charis = $totaloutstanding_charis + $totalna_charis + $totalunacceptable_charis + $totalni_charis + $totalgood_charis;

        // Total Details Santi
        $totaloutstanding_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalna_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalunacceptable_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalni_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalgood_santi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 3)
            ->where('k_created_by', 45)
            ->count('k_id');
        $totalall_santi = $totaloutstanding_santi + $totalna_santi + $totalunacceptable_santi + $totalni_santi + $totalgood_santi;

        // Helpdesk Jakarta
        $totalna_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_helpdeskjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->count('k_id');

        $totalhdjakarta = $totalna_helpdeskjakarta + $totalunacceptable_helpdeskjakarta + $totalni_helpdeskjakarta + $totalgood_helpdeskjakarta + $totaloutstanding_helpdeskjakarta;

        // Helpdesk Dana
        $totalna_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalunacceptable_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalni_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalgood_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totaloutstanding_dana = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 46)
            ->count('k_id');

        $totalall_dana = $totalna_dana + $totalunacceptable_dana + $totalni_dana + $totalgood_dana + $totaloutstanding_dana;

        // Helpdesk Serny
        $totalna_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalunacceptable_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalni_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalgood_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totaloutstanding_serny = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 47)
            ->count('k_id');

        $totalall_serny = $totalna_serny + $totalunacceptable_serny + $totalni_serny + $totalgood_serny + $totaloutstanding_serny;

        // Helpdesk Ambar
        $totalna_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalunacceptable_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalni_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalgood_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totaloutstanding_ambar = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 48)
            ->count('k_id');

        $totalall_ambar = $totalna_ambar + $totalunacceptable_ambar + $totalni_ambar + $totalgood_ambar + $totaloutstanding_ambar;

        // Helpdesk Chandra Kusuma
        $totalna_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalunacceptable_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalni_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalgood_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totaloutstanding_chandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 49)
            ->count('k_id');

        $totalall_chandra = $totalna_chandra + $totalunacceptable_chandra + $totalni_chandra + $totalgood_chandra + $totaloutstanding_chandra;

        // Helpdesk Dana
        $totalna_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalunacceptable_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalni_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalgood_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totaloutstanding_nanda = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 50)
            ->count('k_id');

        $totalall_nanda = $totalna_nanda + $totalunacceptable_nanda + $totalni_nanda + $totalgood_nanda + $totaloutstanding_nanda;

        // Helpdesk noni
        $totalna_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalunacceptable_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalni_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalgood_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totaloutstanding_noni = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 51)
            ->count('k_id');

        $totalall_noni = $totalna_noni + $totalunacceptable_noni + $totalni_noni + $totalgood_noni + $totaloutstanding_noni;

        // Helpdesk Novita
        $totalna_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalunacceptable_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalni_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalgood_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totaloutstanding_novita = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 1)
            ->where('k_site', 3)
            ->where('k_created_by', 52)
            ->count('k_id');

        $totalall_novita = $totalna_novita + $totalunacceptable_novita + $totalni_novita + $totalgood_novita + $totaloutstanding_novita;

        // Asset Kediri
        $totalna_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_assetskediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->count('k_id');

        $totalassetkediri = $totalna_assetskediri + $totalunacceptable_assetskediri + $totalni_assetskediri + $totalgood_assetskediri + $totaloutstanding_assetskediri;

        // Total Details Normi
        $totaloutstanding_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalna_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalunacceptable_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalni_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalgood_normi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 53)
            ->count('k_id');
        $totalall_normi = $totaloutstanding_normi + $totalna_normi + $totalunacceptable_normi + $totalni_normi + $totalgood_normi;

        // Total Details Dwi
        $totaloutstanding_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalna_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalunacceptable_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalni_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalgood_dwi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 55)
            ->count('k_id');
        $totalall_dwi = $totaloutstanding_dwi + $totalna_dwi + $totalunacceptable_dwi + $totalni_dwi + $totalgood_dwi;

        // Total Details Desy
        $totaloutstanding_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalna_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalunacceptable_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalni_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalgood_desy = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 4)
            ->where('k_created_by', 54)
            ->count('k_id');
        $totalall_desy = $totaloutstanding_desy + $totalna_desy + $totalunacceptable_desy + $totalni_desy + $totalgood_desy;

        // Asset SBY
        $totalna_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_assetssurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->count('k_id');

        $totalassetsurabaya = $totalna_assetssurabaya + $totalunacceptable_assetssurabaya + $totalni_assetssurabaya + $totalgood_assetssurabaya + $totaloutstanding_assetssurabaya;

        // Total Details Khasan
        $totaloutstanding_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalna_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalunacceptable_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalni_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalgood_khasan = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 3)
            ->where('k_site', 2)
            ->where('k_created_by', 38)
            ->count('k_id');
        $totalall_khasan = $totaloutstanding_khasan + $totalna_khasan + $totalunacceptable_khasan + $totalni_khasan + $totalgood_khasan;

        // Support Gempol
        $totalna_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalunacceptable_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalni_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalgood_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totaloutstanding_supportgempol = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 1)
            ->count('k_id');

        $totalsupportgempol = $totalna_supportgempol + $totalunacceptable_supportgempol + $totalni_supportgempol + $totalgood_supportgempol + $totaloutstanding_supportgempol;

        // Support Jakarta
        $totalna_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalunacceptable_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalni_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalgood_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totaloutstanding_supportjakarta = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->count('k_id');

        $totalsupportjakarta = $totalna_supportjakarta + $totalunacceptable_supportjakarta + $totalni_supportjakarta + $totalgood_supportjakarta + $totaloutstanding_supportjakarta;

        // Tjandra Hadiwidjaja
        $totalna_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalunacceptable_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalni_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalgood_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totaloutstanding_tjandra = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 26)
            ->count('k_id');

        $totalall_tjandra = $totalna_tjandra + $totalunacceptable_tjandra + $totalni_tjandra + $totalgood_tjandra + $totaloutstanding_tjandra;

        // Filsuf Hidayat
        $totalna_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalunacceptable_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalni_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalgood_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totaloutstanding_ucup = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 39)
            ->count('k_id');

        $totalall_ucup = $totalna_ucup + $totalunacceptable_ucup + $totalni_ucup + $totalgood_ucup + $totaloutstanding_ucup;

        // Tri MArgiono
        $totalna_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalunacceptable_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalni_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalgood_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totaloutstanding_tri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 40)
            ->count('k_id');

        $totalall_tri = $totalna_tri + $totalunacceptable_tri + $totalni_tri + $totalgood_tri + $totaloutstanding_tri;

        // Tjahyadi Wijaya
        $totalna_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalunacceptable_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalni_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalgood_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totaloutstanding_chacha = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 41)
            ->count('k_id');

        $totalall_chacha = $totalna_chacha + $totalunacceptable_chacha + $totalni_chacha + $totalgood_chacha + $totaloutstanding_chacha;

        // Gilang Tresna
        $totalna_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalunacceptable_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalni_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalgood_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totaloutstanding_gilang = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 42)
            ->count('k_id');

        $totalall_gilang = $totalna_gilang + $totalunacceptable_gilang + $totalni_gilang + $totalgood_gilang + $totaloutstanding_gilang;

        // Vincentius Henry
        $totalna_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalunacceptable_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalni_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalgood_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totaloutstanding_vhenry = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 3)
            ->where('k_created_by', 65)
            ->count('k_id');

        $totalall_vhenry = $totalna_vhenry + $totalunacceptable_vhenry + $totalni_vhenry + $totalgood_vhenry + $totaloutstanding_vhenry;

        // Febri Dwi Santoso
        $totalna_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalunacceptable_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalni_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalgood_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totaloutstanding_febrids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 34)
            ->count('k_id');

        $totalall_febrids = $totalna_febrids + $totalunacceptable_febrids + $totalni_febrids + $totalgood_febrids + $totaloutstanding_febrids;

        // Rony Febriadi
        $totalna_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalunacceptable_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalni_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalgood_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totaloutstanding_rfebriadi = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 35)
            ->count('k_id');

        $totalall_rfebriadi = $totalna_rfebriadi + $totalunacceptable_rfebriadi + $totalni_rfebriadi + $totalgood_rfebriadi + $totaloutstanding_rfebriadi;

        // Abdus Shahrir Rozaq
        $totalna_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalunacceptable_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalni_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalgood_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totaloutstanding_arozaq = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 36)
            ->count('k_id');

        $totalall_arozaq = $totalna_arozaq + $totalunacceptable_arozaq + $totalni_arozaq + $totalgood_arozaq + $totaloutstanding_arozaq;

        // Bondan Handoko
        $totalna_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalunacceptable_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalni_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalgood_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totaloutstanding_bhandoko = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->where('k_created_by', 37)
            ->count('k_id');

        $totalall_bhandoko = $totalna_bhandoko + $totalunacceptable_bhandoko + $totalni_bhandoko + $totalgood_bhandoko + $totaloutstanding_bhandoko;



        // Support Kediri
        $totalna_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalunacceptable_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalni_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalgood_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totaloutstanding_supportkediri = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->count('k_id');

        $totalsupportkediri = $totalna_supportkediri + $totalunacceptable_supportkediri + $totalni_supportkediri + $totalgood_supportkediri + $totaloutstanding_supportkediri;

        // Hendrian Rajitama
        $totalna_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalunacceptable_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalni_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalgood_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totaloutstanding_hendrianr = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 56)
            ->count('k_id');

        $totalall_hendrianr = $totalna_hendrianr + $totalunacceptable_hendrianr + $totalni_hendrianr + $totalgood_hendrianr + $totaloutstanding_hendrianr;

        // Stifanus Benny Sabdiyanto
        $totalna_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalunacceptable_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalni_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalgood_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totaloutstanding_ssabdiyanto = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 57)
            ->count('k_id');

        $totalall_ssabdiyanto = $totalna_ssabdiyanto + $totalunacceptable_ssabdiyanto + $totalni_ssabdiyanto + $totalgood_ssabdiyanto + $totaloutstanding_ssabdiyanto;

        // Rendra Yuwowono
        $totalna_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalunacceptable_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalni_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalgood_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totaloutstanding_ryuwono01 = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 58)
            ->count('k_id');

        $totalall_ryuwono01 = $totalna_ryuwono01 + $totalunacceptable_ryuwono01 + $totalni_ryuwono01 + $totalgood_ryuwono01 + $totaloutstanding_ryuwono01;

        // Reza
        $totalna_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalunacceptable_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalni_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalgood_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totaloutstanding_liemrjw = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 59)
            ->count('k_id');

        $totalall_liemrjw = $totalna_liemrjw + $totalunacceptable_liemrjw + $totalni_liemrjw + $totalgood_liemrjw + $totaloutstanding_liemrjw;

        // Alief
        $totalna_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalunacceptable_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalni_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalgood_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totaloutstanding_aliefgaf = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 60)
            ->count('k_id');

        $totalall_aliefgaf = $totalna_aliefgaf + $totalunacceptable_aliefgaf + $totalni_aliefgaf + $totalgood_aliefgaf + $totaloutstanding_aliefgaf;

        // Afib
        $totalna_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalunacceptable_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalni_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalgood_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totaloutstanding_afiba = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 61)
            ->count('k_id');

        $totalall_afiba = $totalna_afiba + $totalunacceptable_afiba + $totalni_afiba + $totalgood_afiba + $totaloutstanding_afiba;

        // aditya
        $totalna_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalunacceptable_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalni_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalgood_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totaloutstanding_adityad = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 62)
            ->count('k_id');

        $totalall_adityad = $totalna_adityad + $totalunacceptable_adityad + $totalni_adityad + $totalgood_adityad + $totaloutstanding_adityad;

        // abrahamk
        $totalna_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalunacceptable_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalni_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalgood_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totaloutstanding_abrahamk = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 63)
            ->count('k_id');

        $totalall_abrahamk = $totalna_abrahamk + $totalunacceptable_abrahamk + $totalni_abrahamk + $totalgood_abrahamk + $totaloutstanding_abrahamk;

        // sigids
        $totalna_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalunacceptable_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalni_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalgood_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totaloutstanding_sigids = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 4)
            ->where('k_created_by', 64)
            ->count('k_id');

        $totalall_sigids = $totalna_sigids + $totalunacceptable_sigids + $totalni_sigids + $totalgood_sigids + $totaloutstanding_sigids;

        // Support Surabaya
        $totalna_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'N/A')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalunacceptable_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Unacceptable')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalni_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'NI')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalgood_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Good')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totaloutstanding_supportsurabaya = DB::table('a_kpi')
            ->where('k_finalresult_text', '=', 'Outstanding')
            ->where('k_status_id', 3)
            ->where('k_unit', 2)
            ->where('k_site', 2)
            ->count('k_id');

        $totalsupportsurabaya = $totalna_supportsurabaya + $totalunacceptable_supportsurabaya + $totalni_supportsurabaya + $totalgood_supportsurabaya + $totaloutstanding_supportsurabaya;

        // Total NA Services
        // Total keseluruhan

        $totalna_services = $totalna_assetsgempol + $totalna_assetsjakarta + $totalna_helpdeskjakarta + $totalna_assetskediri + $totalna_assetssurabaya + $totalna_supportgempol + $totalna_supportjakarta + $totalna_supportkediri + $totalna_supportsurabaya;

        $totalna_support = $totalna_supportgempol + $totalna_supportjakarta + $totalna_supportkediri + $totalna_supportsurabaya;


        $totalunacceptable_services = $totalunacceptable_assetsgempol + $totalunacceptable_assetsjakarta + $totalunacceptable_helpdeskjakarta + $totalunacceptable_assetskediri + $totalunacceptable_assetssurabaya + $totalunacceptable_supportgempol + $totalunacceptable_supportjakarta + $totalunacceptable_supportkediri + $totalunacceptable_supportsurabaya;

        $totalunacceptable_support = $totalunacceptable_supportgempol + $totalunacceptable_supportjakarta + $totalunacceptable_supportkediri + $totalunacceptable_supportsurabaya;

        $totalni_services = $totalni_assetsgempol + $totalni_assetsjakarta + $totalni_helpdeskjakarta + $totalni_assetskediri + $totalni_assetssurabaya + $totalni_supportgempol + $totalni_supportjakarta + $totalni_supportkediri + $totalni_supportsurabaya;
        $totalni_support = $totalni_supportgempol + $totalni_supportjakarta + $totalni_supportkediri + $totalni_supportsurabaya;

        $totalgood_services = $totalgood_assetsgempol + $totalgood_assetsjakarta + $totalgood_helpdeskjakarta + $totalgood_assetskediri + $totalgood_assetssurabaya + $totalgood_supportgempol + $totalgood_supportjakarta + $totalgood_supportkediri + $totalgood_supportsurabaya;

        $totalgood_support = $totalgood_supportgempol + $totalgood_supportjakarta + $totalgood_supportkediri + $totalgood_supportsurabaya;

        $totaloutstanding_services = $totaloutstanding_assetsgempol + $totaloutstanding_assetsjakarta + $totaloutstanding_helpdeskjakarta + $totaloutstanding_assetskediri + $totaloutstanding_assetssurabaya + $totaloutstanding_supportgempol + $totaloutstanding_supportjakarta + $totaloutstanding_supportkediri + $totaloutstanding_supportsurabaya;

        $totaloutstanding_support = $totaloutstanding_supportgempol + $totaloutstanding_supportjakarta + $totaloutstanding_supportkediri + $totaloutstanding_supportsurabaya;

        if ($request->tahun == 'ALL') {
            $tahun = "";
        } else {
            $tahun = "and k_targetdate like '%$request->tahun%'";
        }
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = "";
            }
        }
        if (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        }
        $id_mem = auth()->user()->m_id;
        if (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        }
        // $id = $request->id;
        $menu = DB::table('d_menu')->get();
        $site = DB::table('d_site')->get();

        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $gmpl_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 1 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        //peubahan chart
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $sby_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 2 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $jkt_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 3 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }
        for ($i = 0; $i < count($year); $i++) {
            $t[$i] = $year[$i]->p_year;
            $kdr_site[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_site = 4 AND (k_status_id = 1 OR k_status_id = 11 OR k_status_id = 14 OR k_status_id = 17 OR k_status_id = 3)
                and year(k_targetdate) = '$t[$i]'
                group by k_site,s_name;
          ");
        }

        $total_sby = 0;
        $total_gmpl = 0;
        $total_jkt = 0;
        $total_kdr = 0;
        // return $total_gmpl;
        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $all_site = [$total_gmpl, $total_jkt, $total_kdr, $total_sby];

        $dt2020 =  DB::table('a_kpi')->selectRaw(DB::raw('count(k_site) as user_count'))
            ->groupBy('k_site')
            ->whereYear('k_targetdate', '2020')
            ->orderBy('k_site', 'ASC')
            ->get();



        $site = ['1', '3', '4', '2'];
        // $color = ['#868e96','#ff3300','#f9ed09','#00b300','blue'];
        $color = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        $color_nilai = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        // $color_nilai = ['#868e96','#ef6e6e','#ffbc34','#4798e8','##22c6ab'];
        $unit_as = ['3', '2'];
        $unit_has = ['3', '1', '2'];
        $unit_has_bawah = ['3', '2', '1'];
        $unit_as_text = ['Asset', 'Support'];
        $unit_has_text = ['Asset', 'Helpdesk', 'Support'];
        $nilai = ['N/A', 'Unacceptable', 'NI', 'Good', 'Outstanding'];
        // COLUMN ATAS
        // index ke 1
        for ($i = 0; $i < count($site); $i++) {
            $chart_index_awal[$i] = DB::table('a_kpi')
                ->where('k_status_id', 3)
                ->where('k_site', $site[$i])
                // ->whereYear('k_targetdate',date('Y'))
                ->count('k_id');
        }
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            }
        }
        //index ke 3
        for ($j = 0; $j < count($site); $j++) {
            if ($site[$j] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_as[$k])
                            ->count('k_id');
                    }
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_has[$k])
                            ->count('k_id');
                    }
                }
            }
        }
        // COLUMN BAWAH
        // index ke 1 
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->count('k_id');
                }
            }
        }
        // index ke 2 
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_id')
                        ->get();
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_name')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        // ->where('k_targetdate',date('Y'))
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->groupBy('d_mem.m_id')
                        ->get();
                }
            }
        }
        // return $chart_index_kedua_bawah;
        $dt = [];
        foreach ($site as $i => $value) {
            foreach ($chart_index_kedua_bawah as $i1 => $value1) {
                $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                $array_support[$i] = $chart_index_kedua_bawah[$i][1];
                $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][1];
            }
        }
        // return $array_asset;
        $array_helpdesk = $chart_index_kedua_bawah[1][2];
        $array_helpdesk_id = $chart_index_kedua_bawah_id[1][2];

        for ($i = 0; $i < count($array_asset_id); $i++) {
            for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                $chart_index_kedua_bawah_count_asset[$i][$k] = DB::table('a_kpi')
                    ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                    ->where('k_status_id', 3)
                    ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                    ->count('k_id');
            }
        }
        for ($i = 0; $i < count($array_support_id); $i++) {
            for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                $chart_index_kedua_bawah_count_support[$i][$k] = DB::table('a_kpi')
                    ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                    ->where('k_status_id', 3)
                    ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                    ->count('k_id');
            }
        }
        for ($i = 0; $i < count($array_helpdesk_id); $i++) {
            $chart_index_kedua_bawah_count_helpdesk[$i] = DB::table('a_kpi')
                ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                ->where('k_status_id', 3)
                ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                ->count('k_id');
        }

        for ($i = 0; $i < count($array_asset_id); $i++) {
            for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = DB::table('a_kpi')
                        ->where('k_finalresult_text', '=', $nilai[$j])
                        ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                        ->where('k_status_id', 3)
                        ->count('k_id');
                }
            }
        }

        for ($i = 0; $i < count($array_helpdesk_id); $i++) {
            for ($j = 0; $j < count($nilai); $j++) {
                $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = DB::table('a_kpi')
                    ->where('k_finalresult_text', '=', $nilai[$j])
                    ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                    ->where('k_status_id', 3)
                    ->count('k_id');
            }
        }
        // return $chart_index_kedua_bawah_count_nilai_helpdesk;
        for ($i = 0; $i < count($array_support_id); $i++) {
            for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = DB::table('a_kpi')
                        ->where('k_finalresult_text', '=', $nilai[$j])
                        ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                        ->where('k_status_id', 3)
                        ->count('k_id');
                }
            }
        }

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Report > KPI Chart',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.chart_lead_support', compact(
            'chart_index_awal',
            'chart_index_kedua',
            'chart_index_ketiga',
            'unit_as',
            'unit_has_text',
            'unit_as_text',
            'menu',
            'color',
            'nilai',
            'chart_index_awal_bawah',
            'color_nilai',
            'chart_index_kedua_bawah_count_asset',
            'chart_index_kedua_bawah_count_support',
            'chart_index_kedua_bawah_count_helpdesk',
            'chart_index_kedua_bawah_count_nilai_asset',
            'array_asset_id',
            'array_support_id',
            'array_helpdesk_id',
            'array_asset',
            'array_support',
            'array_helpdesk',
            'totalna_support',
            'totalunacceptable_support',
            'totalni_support',
            'totalgood_support',
            'totaloutstanding_support',
            'dt2020',
            'site',
            'menu',
            'site',
            'all_site',
            'all_site_name',
            'sby_site',
            'kdr_site',
            'jkt_site',
            'gmpl_site',
            'year',
            'chart_index_kedua_bawah_count_nilai_helpdesk',
            'chart_index_kedua_bawah_count_nilai_support',
            'totalassetgempol',
            'totalassetjakarta',
            'totalhdjakarta',
            'totalassetkediri',
            'totalassetsurabaya',
            'totalsupportgempol',
            'totalsupportjakarta',
            'totalsupportkediri',
            'totalsupportsurabaya',
            'totalunacceptable_services',
            'totalna_services',
            'totalni_services',
            'totalgood_services',
            'totaloutstanding_services',
            'totaloutstanding_assetsgempol',
            'totalgood_assetsgempol',
            'totalni_assetsgempol',
            'totalunacceptable_assetsgempol',
            'totalna_assetsgempol',
            'totaloutstanding_supportgempol',
            'totalgood_supportgempol',
            'totalni_supportgempol',
            'totalunacceptable_supportgempol',
            'totalna_supportgempol',
            'totaloutstanding_assetsjakarta',
            'totalgood_assetsjakarta',
            'totalni_assetsjakarta',
            'totalunacceptable_assetsjakarta',
            'totalna_assetsjakarta',
            'totaloutstanding_helpdeskjakarta',
            'totalgood_helpdeskjakarta',
            'totalni_helpdeskjakarta',
            'totalunacceptable_helpdeskjakarta',
            'totalna_helpdeskjakarta',
            'totaloutstanding_supportjakarta',
            'totalgood_supportjakarta',
            'totalni_supportjakarta',
            'totalunacceptable_supportjakarta',
            'totalna_supportjakarta',
            'totaloutstanding_assetskediri',
            'totalgood_assetskediri',
            'totalni_assetskediri',
            'totalunacceptable_assetskediri',
            'totalna_assetskediri',
            'totaloutstanding_supportkediri',
            'totalgood_supportkediri',
            'totalni_supportkediri',
            'totalunacceptable_supportkediri',
            'totalna_supportkediri',
            'totaloutstanding_assetssurabaya',
            'totalgood_assetssurabaya',
            'totalni_assetssurabaya',
            'totalunacceptable_assetssurabaya',
            'totalna_assetssurabaya',
            'totaloutstanding_supportsurabaya',
            'totalgood_supportsurabaya',
            'totalni_supportsurabaya',
            'totalunacceptable_supportsurabaya',
            'totalna_supportsurabaya',
            'totaloutstanding_denok',
            'totalna_denok',
            'totalunacceptable_denok',
            'totalni_denok',
            'totalgood_denok',
            'totalall_denok',
            'totaloutstanding_yudi',
            'totalna_yudi',
            'totalunacceptable_yudi',
            'totalni_yudi',
            'totalgood_yudi',
            'totaloutstanding_wellma',
            'totalna_wellma',
            'totalunacceptable_wellma',
            'totalni_wellma',
            'totalgood_wellma',
            'totalall_wellma',
            'totalall_marien',
            'totaloutstanding_marien',
            'totalna_marien',
            'totalunacceptable_marien',
            'totalni_marien',
            'totalgood_marien',
            'totalall_charis',
            'totaloutstanding_charis',
            'totalna_charis',
            'totalunacceptable_charis',
            'totalni_charis',
            'totalgood_charis',
            'totalall_santi',
            'totaloutstanding_santi',
            'totalna_santi',
            'totalunacceptable_santi',
            'totalni_santi',
            'totalgood_santi',
            'totalall_normi',
            'totaloutstanding_normi',
            'totalna_normi',
            'totalunacceptable_normi',
            'totalni_normi',
            'totalgood_normi',
            'totalall_dwi',
            'totaloutstanding_dwi',
            'totalna_dwi',
            'totalunacceptable_dwi',
            'totalni_dwi',
            'totalgood_dwi',
            'totalall_desy',
            'totaloutstanding_desy',
            'totalna_desy',
            'totalunacceptable_desy',
            'totalni_desy',
            'totalgood_desy',
            'totalall_khasan',
            'totaloutstanding_khasan',
            'totalna_khasan',
            'totalunacceptable_khasan',
            'totalni_khasan',
            'totalgood_khasan',
            'totalall_dana',
            'totalna_dana',
            'totalunacceptable_dana',
            'totalni_dana',
            'totalgood_dana',
            'totaloutstanding_dana',
            'totalall_serny',
            'totalna_serny',
            'totalunacceptable_serny',
            'totalni_serny',
            'totalgood_serny',
            'totaloutstanding_serny',
            'totalall_ambar',
            'totalna_ambar',
            'totalunacceptable_ambar',
            'totalni_ambar',
            'totalgood_ambar',
            'totaloutstanding_ambar',
            'totalall_chandra',
            'totalna_chandra',
            'totalunacceptable_chandra',
            'totalni_chandra',
            'totalgood_chandra',
            'totaloutstanding_chandra',
            'totalall_nanda',
            'totalna_nanda',
            'totalunacceptable_nanda',
            'totalni_nanda',
            'totalgood_nanda',
            'totaloutstanding_nanda',
            'totalall_noni',
            'totalna_noni',
            'totalunacceptable_noni',
            'totalni_noni',
            'totalgood_noni',
            'totaloutstanding_noni',
            'totalall_novita',
            'totalna_novita',
            'totalunacceptable_novita',
            'totalni_novita',
            'totalgood_novita',
            'totaloutstanding_novita',
            'totalall_yudi',
            'totaloutstanding_yudi',
            'totalna_yudi',
            'totalunacceptable_yudi',
            'totalni_yudi',
            'totalgood_yudi',
            'totalall_ucis',
            'totaloutstanding_ucis',
            'totalna_ucis',
            'totalunacceptable_ucis',
            'totalni_ucis',
            'totalgood_ucis',
            'totalall_lukman',
            'totaloutstanding_lukman',
            'totalna_lukman',
            'totalunacceptable_lukman',
            'totalni_lukman',
            'totalgood_lukman',
            'totalall_ical',
            'totaloutstanding_ical',
            'totalna_ical',
            'totalunacceptable_ical',
            'totalni_ical',
            'totalgood_ical',
            'totalall_hendra',
            'totaloutstanding_hendra',
            'totalna_hendra',
            'totalunacceptable_hendra',
            'totalni_hendra',
            'totalgood_hendra',
            'totalall_tjandra',
            'totalna_tjandra',
            'totalunacceptable_tjandra',
            'totalni_tjandra',
            'totalgood_tjandra',
            'totaloutstanding_tjandra',
            'totalall_ucup',
            'totalna_ucup',
            'totalunacceptable_ucup',
            'totalni_ucup',
            'totalgood_ucup',
            'totaloutstanding_ucup',
            'totalall_tri',
            'totalna_tri',
            'totalunacceptable_tri',
            'totalni_tri',
            'totalgood_tri',
            'totaloutstanding_tri',
            'totalall_chacha',
            'totalna_chacha',
            'totalunacceptable_chacha',
            'totalni_chacha',
            'totalgood_chacha',
            'totaloutstanding_chacha',
            'totalall_gilang',
            'totalna_gilang',
            'totalunacceptable_gilang',
            'totalni_gilang',
            'totalgood_gilang',
            'totaloutstanding_gilang',
            'totalall_febrids',
            'totalna_febrids',
            'totalunacceptable_febrids',
            'totalni_febrids',
            'totalgood_febrids',
            'totaloutstanding_febrids',
            'totalall_rfebriadi',
            'totalna_rfebriadi',
            'totalunacceptable_rfebriadi',
            'totalni_rfebriadi',
            'totalgood_rfebriadi',
            'totaloutstanding_rfebriadi',
            'totalall_arozaq',
            'totalna_arozaq',
            'totalunacceptable_arozaq',
            'totalni_arozaq',
            'totalgood_arozaq',
            'totaloutstanding_arozaq',
            'totalall_bhandoko',
            'totalna_bhandoko',
            'totalunacceptable_bhandoko',
            'totalni_bhandoko',
            'totalgood_bhandoko',
            'totaloutstanding_bhandoko',
            'totalall_hendrianr',
            'totalna_hendrianr',
            'totalunacceptable_hendrianr',
            'totalni_hendrianr',
            'totalgood_hendrianr',
            'totaloutstanding_hendrianr',
            'totalall_ssabdiyanto',
            'totalna_ssabdiyanto',
            'totalunacceptable_ssabdiyanto',
            'totalni_ssabdiyanto',
            'totalgood_ssabdiyanto',
            'totaloutstanding_ssabdiyanto',
            'totalall_ryuwono01',
            'totalna_ryuwono01',
            'totalunacceptable_ryuwono01',
            'totalni_ryuwono01',
            'totalgood_ryuwono01',
            'totaloutstanding_ryuwono01',
            'totalall_liemrjw',
            'totalna_liemrjw',
            'totalunacceptable_liemrjw',
            'totalni_liemrjw',
            'totalgood_liemrjw',
            'totaloutstanding_liemrjw',
            'totalall_aliefgaf',
            'totalna_aliefgaf',
            'totalunacceptable_aliefgaf',
            'totalni_aliefgaf',
            'totalgood_aliefgaf',
            'totaloutstanding_aliefgaf',
            'totalall_afiba',
            'totalna_afiba',
            'totalunacceptable_afiba',
            'totalni_afiba',
            'totalgood_afiba',
            'totaloutstanding_afiba',
            'totalall_adityad',
            'totalna_adityad',
            'totalunacceptable_adityad',
            'totalni_adityad',
            'totalgood_adityad',
            'totaloutstanding_adityad',
            'totalall_abrahamk',
            'totalna_abrahamk',
            'totalunacceptable_abrahamk',
            'totalni_abrahamk',
            'totalgood_abrahamk',
            'totaloutstanding_abrahamk',
            'totalall_sigids',
            'totalna_sigids',
            'totalunacceptable_sigids',
            'totalni_sigids',
            'totalgood_sigids',
            'totaloutstanding_sigids',
            'totalna_vhenry',
            'totalunacceptable_vhenry',
            'totalni_vhenry',
            'totalgood_vhenry',
            'totaloutstanding_vhenry',
            'totalall_vhenry'
        ));
    }

    public function all_report_lead_support_chart_cari_unit(Request $req)
    {
        $nilai = ['N/A', 'Unacceptable', 'NI', 'Good', 'Outstanding'];
        $unit = ['1', '2', '3'];
        $site = ['1', '3', '4', '2'];
        if ($req->tahun != 'all') {
            $year = $req->tahun;
        } else {
            $year = DB::table('d_periode')->get()->toArray();
        }
        // return $year;
        if ($req->unit == 'IT Services') {
            for ($i = 0; $i < count($nilai); $i++) {
                for ($k = 0; $k < count($unit); $k++) {
                    $pie_awal[$i][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            }
                        })
                        ->where('k_finalresult_text', '=', $nilai[$i])
                        ->where('k_status_id', 3)
                        ->where('k_unit', $unit[$k])
                        ->count('k_id');
                }
            }
            for ($i = 0; $i < count($pie_awal); $i++) {
                $pie[$i] = array_sum($pie_awal[$i]);
            }



            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Assets') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 3)
                    ->count('k_id');
            }

            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 3)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
            // return $year;
        } elseif ($req->unit == 'IT Support') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 2)
                    ->count('k_id');
            }

            for ($p = 0; $p < count(is_array($year) ? $year : [$year]); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 2)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        } elseif ($req->unit == 'IT Helpdesk') {
            for ($i = 0; $i < count($nilai); $i++) {
                $pie[$i] = DB::table('a_kpi')
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'all') {
                            $q->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->where('k_finalresult_text', '=', $nilai[$i])
                    ->where('k_status_id', 3)
                    ->where('k_unit', 1)
                    ->count('k_id');
            }

            for ($p = 0; $p < count($year); $p++) {
                for ($k = 0; $k < count($site); $k++) {
                    $line[$p][$k] = DB::table('a_kpi')
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                                $q->whereYear('k_targetdate', $year[$p]->p_year);
                            }
                        })
                        ->where('k_unit', 1)
                        ->where(function ($q) {
                            $q->orWhere('k_status_id', 1);
                            $q->orWhere('k_status_id', 11);
                            $q->orWhere('k_status_id', 14);
                            $q->orWhere('k_status_id', 17);
                            $q->orWhere('k_status_id', 3);
                        })
                        ->where('k_site', $site[$k])
                        ->count('k_id');
                }
            }
        }
        // return $line;

        $all_site_name = ['Gempol', 'Jakarta', 'Kediri', 'Surabaya'];
        $color = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        $color_nilai = ['#868e96', '#ff3300', '#f9ed09', '#225bb7', '#00b300'];
        // $color_nilai = ['#868e96','#ef6e6e','#ffbc34','#4798e8','##22c6ab'];
        if ($req->unit == 'IT Services') {
            $unit_as = ['3', '2'];
            $unit_has = ['3', '1', '2'];
            $unit_has_bawah = ['3', '2', '1'];
            $unit_as_text = ['Asset', 'Support'];
            $unit_has_text = ['Asset', 'Helpdesk', 'Support'];
        } elseif ($req->unit == 'IT Assets') {
            $unit_as = ['3'];
            $unit_has = ['3'];
            $unit_has_bawah = ['3'];
            $unit_as_text = ['Asset'];
            $unit_has_text = ['Asset'];
        } elseif ($req->unit == 'IT Support') {
            $unit_as = ['2'];
            $unit_has = ['2'];
            $unit_has_bawah = ['2'];
            $unit_as_text = ['Support'];
            $unit_has_text = ['Helpdesk'];
        } else {
            $unit_as = [];
            $unit_has = ['1'];
            $unit_has_bawah = ['1'];
            $unit_as_text = [];
            $unit_has_text = ['Helpdesk'];
        }
        for ($i = 0; $i < count($site); $i++) {
            $chart_index_awal[$i] = DB::table('a_kpi')
                ->where('k_status_id', 3)
                ->where('k_site', $site[$i])
                ->where(function ($q) use ($req) {
                    if ($req->unit == 'IT Support') {
                        $q->orWhere('k_unit', 2);
                    } elseif ($req->unit == 'IT Assets') {
                        $q->orWhere('k_unit', 3);
                    } elseif ($req->unit == 'IT Helpdesk') {
                        $q->orWhere('k_unit', 1);
                    } else {
                        $q->orWhere('k_unit', 3);
                        $q->orWhere('k_unit', 1);
                        $q->orWhere('k_unit', 2);
                    }
                })
                ->where(function ($q) use ($req, $year, $p) {
                    if ($req->tahun != 'all') {
                        $q->whereYear('k_targetdate', $req->tahun);
                    } else {
                    }
                })
                ->count('k_id');
        }
        // index ke 2
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    $chart_index_kedua[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_kedua;
        //index ke 3
        for ($j = 0; $j < count($site); $j++) {
            if ($site[$j] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_as[$k])
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            } else {
                for ($k = 0; $k < count($unit_has); $k++) {
                    for ($i = 0; $i < count($nilai); $i++) {
                        $chart_index_ketiga[$j][$k][$i] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$i])
                            ->where('k_status_id', 3)
                            ->where('k_site', $site[$j])
                            ->where('k_unit', $unit_has[$k])
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        $chart_index_kedua = array_values($chart_index_kedua);
        $chart_index_ketiga = array_values($chart_index_ketiga);

        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_awal_bawah[$i][$k] = DB::table('a_kpi')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_awal_bawah;
        // index ke 2 
        for ($i = 0; $i < count($site); $i++) {
            if ($site[$i] != 3) {
                for ($k = 0; $k < count($unit_as); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_as[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_id')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                }
            } else {
                for ($k = 0; $k < count($unit_has_bawah); $k++) {
                    $chart_index_kedua_bawah[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_name')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_name')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                    $chart_index_kedua_bawah_id[$i][$k] = DB::table('a_kpi')
                        ->select('d_mem.m_id')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_site', $site[$i])
                        ->where('k_unit', $unit_has_bawah[$k])
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->groupBy('d_mem.m_id')
                        ->orderBy('d_mem.m_name', 'ASC')
                        ->get();
                }
            }
        }
        $chart_index_kedua_bawah = array_values($chart_index_kedua_bawah);
        $chart_index_kedua_bawah_id = array_values($chart_index_kedua_bawah_id);
        $dt = [];
        foreach ($site as $i => $value) {
            foreach ($chart_index_kedua_bawah as $i1 => $value1) {
                if ($req->unit == 'IT Services') {
                    $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                    $array_support[$i] = $chart_index_kedua_bawah[$i][1];
                    $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][1];
                } elseif ($req->unit == 'IT Assets') {
                    $array_asset[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_asset_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                } elseif ($req->unit == 'IT Support') {
                    $array_support[$i] = $chart_index_kedua_bawah[$i][0];
                    $array_support_id[$i] = $chart_index_kedua_bawah_id[$i][0];
                }
            }
        }

        // return count($array_asset[1]);

        if ($req->unit == 'IT Services') {
            $array_helpdesk = $chart_index_kedua_bawah[1][2];
            $array_helpdesk_id = $chart_index_kedua_bawah_id[1][2];
        } else {
            $array_helpdesk = $chart_index_kedua_bawah[0][0];
            $array_helpdesk_id = $chart_index_kedua_bawah_id[0][0];
        }

        if ($req->unit == 'IT Services' || $req->unit == 'IT Assets') {
            for ($i = 0; $i < count($array_asset_id); $i++) {
                if (count($array_asset[$i]) == 0) {
                    $chart_index_kedua_bawah_count_asset[$i][0] = 0;
                } else {
                    for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                        $chart_index_kedua_bawah_count_asset[$i][$k] = DB::table('a_kpi')
                            ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                            ->where('k_status_id', 3)
                            ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }

        if ($req->unit == 'IT Services' || $req->unit == 'IT Support') {
            for ($i = 0; $i < count($array_support_id); $i++) {
                if (count($array_support_id[$i]) == 0) {
                    $chart_index_kedua_bawah_count_support[$i][0] = 0;
                } else {
                    for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                        $chart_index_kedua_bawah_count_support[$i][$k] = DB::table('a_kpi')
                            ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                            ->where('k_status_id', 3)
                            ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        if ($req->unit == 'IT Services' || $req->unit == 'IT Helpdesk') {
            if (count($array_helpdesk_id) == 0) {
                $chart_index_kedua_bawah_count_helpdesk[$i] = 0;
            } else {
                for ($i = 0; $i < count($array_helpdesk_id); $i++) {
                    $chart_index_kedua_bawah_count_helpdesk[$i] = DB::table('a_kpi')
                        ->join('d_mem', 'd_mem.m_id', 'a_kpi.k_created_by')
                        ->where('k_status_id', 3)
                        ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                        ->where(function ($q) use ($req, $year, $p) {
                            if ($req->tahun != 'all') {
                                $q->whereYear('k_targetdate', $req->tahun);
                            } else {
                            }
                        })
                        ->count('k_id');
                }
            }
        }
        // return $chart_index_kedua_bawah_count_helpdesk;
        if ($req->unit == 'IT Services' || $req->unit == 'IT Assets') {
            for ($i = 0; $i < count($array_asset_id); $i++) {
                if (count($array_asset_id[$i]) == 0) {
                    for ($k = 0; $k < 1; $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = 0;
                        }
                    }
                } else {
                    for ($k = 0; $k < count($array_asset_id[$i]); $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_asset[$i][$k][$j] = DB::table('a_kpi')
                                ->where('k_finalresult_text', '=', $nilai[$j])
                                ->where('k_created_by', $array_asset_id[$i][$k]->m_id)
                                ->where('k_status_id', 3)
                                ->where(function ($q) use ($req, $year, $p) {
                                    if ($req->tahun != 'all') {
                                        $q->whereYear('k_targetdate', $req->tahun);
                                    } else {
                                    }
                                })
                                ->count('k_id');
                        }
                    }
                }
            }
        }
        if ($req->unit == 'IT Services' || $req->unit == 'IT Helpdesk') {
            if (count($array_helpdesk_id) == 0) {
                for ($j = 0; $j < count($nilai); $j++) {
                    $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = 0;
                }
                $chart_index_kedua_bawah_count_nilai_helpdesk = array_values($chart_index_kedua_bawah_count_nilai_helpdesk);
            } else {
                for ($i = 0; $i < count($array_helpdesk_id); $i++) {
                    for ($j = 0; $j < count($nilai); $j++) {
                        $chart_index_kedua_bawah_count_nilai_helpdesk[$i][$j] = DB::table('a_kpi')
                            ->where('k_finalresult_text', '=', $nilai[$j])
                            ->where('k_created_by', $array_helpdesk_id[$i]->m_id)
                            ->where('k_status_id', 3)
                            ->where(function ($q) use ($req, $year, $p) {
                                if ($req->tahun != 'all') {
                                    $q->whereYear('k_targetdate', $req->tahun);
                                } else {
                                }
                            })
                            ->count('k_id');
                    }
                }
            }
        }
        // return $chart_index_kedua_bawah_count_nilai_helpdesk;
        if ($req->unit == 'IT Services' || $req->unit == 'IT Support') {
            for ($i = 0; $i < count($array_support_id); $i++) {
                if (count($array_support_id[$i]) == 0) {
                    for ($k = 0; $k < 1; $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = 0;
                        }
                    }
                } else {
                    for ($k = 0; $k < count($array_support_id[$i]); $k++) {
                        for ($j = 0; $j < count($nilai); $j++) {
                            $chart_index_kedua_bawah_count_nilai_support[$i][$k][$j] = DB::table('a_kpi')
                                ->where('k_finalresult_text', '=', $nilai[$j])
                                ->where('k_created_by', $array_support_id[$i][$k]->m_id)
                                ->where('k_status_id', 3)
                                ->where(function ($q) use ($req, $year, $p) {
                                    if ($req->tahun != 'all') {
                                        $q->whereYear('k_targetdate', $req->tahun);
                                    } else {
                                    }
                                })
                                ->count('k_id');
                        }
                    }
                }
            }
        }
        $title = $req->unit;
        $tahun = $req->tahun;
        return view('report.kpi.chart_filter', compact('chart_index_awal', 'chart_index_kedua', 'chart_index_ketiga', 'unit_as', 'unit_has_text', 'unit_as_text', 'color', 'nilai', 'chart_index_awal_bawah', 'color_nilai', 'chart_index_kedua_bawah_count_support', 'array_support_id', 'array_helpdesk_id', 'array_support', 'array_helpdesk', 'site', 'all_site_name', 'year', 'chart_index_kedua_bawah_count_nilai_support', 'title', 'tahun', 'pie', 'line'));
    }

    public function specialist_report_chart(Request $request)
    {
        $year = DB::table('d_periode')->get()->toArray();
        $flag = session('unit_flag');
        if (auth()->user()->m_flag == 1 || auth()->user()->m_flag == 0) {
            if (auth()->user()->m_unit == 10 || auth()->user()->m_unit == 31) {
                $unit = "";
            }
        }

        if (auth()->user()->m_flag == 2) {
            if (auth()->user()->m_unit == 32) {
                $unit = "and u_name LIKE '%support%'";
            }
            if (auth()->user()->m_unit == 33) {
                $unit = "and u_name LIKE '%asset%'";
            }
        }
        $id_mem = auth()->user()->m_id;
        $name_mem = auth()->user()->m_name;
        if (auth()->user()->m_flag == 3) {
            $unit = "and m_coordinator = $id_mem";
        }

        $userunit = DB::table('d_unit')->where('u_id', auth()->user()->m_unit)->first();

        if ($userunit->u_flag == 1) {
            $flag = 'IT Helpdesk';
        } elseif ($userunit->u_flag == 3) {
            $flag = 'IT Asset';
        } elseif ($userunit->u_flag == 2) {
            $flag = 'IT Support';
        } elseif ($userunit->u_flag == 4) {
            $flag = 'Manager';
        } elseif ($userunit->u_flag == 0) {
            $flag = 'Administrator';
        }

        $id = $request->id;
        $all_site = DB::select("
        SELECT m_name,s_name,m_id,u_name,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NA,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Unacceptable,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NI,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Good,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Outstanding,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as ttl,
        (SELECT COUNT(a_kpi.k_id) FROM a_kpi where a_kpi.k_created_by = m_id group by k_created_by) as ttl_kpi
        FROM a_kpi
        join d_mem on m_id=k_created_by
        join d_site on s_id=k_site
        join d_unit on m_unit=u_id
        where k_created_by = $id_mem  and (a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3) 
        GROUP BY m_name,s_name,m_id,u_name
        ");


        for ($i = 0; $i < count($year); $i++) {

            $t[$i] = $year[$i]->p_year;
            $line[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_status_id = 3
                and year(k_targetdate) = '$t[$i]'
                and k_created_by = '$id_mem'
                group by k_site,s_name;
          ");
        }


        $menu  = DB::table('d_menu')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Report Chart ',
            'dl_desc' => '-',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.all_spec', compact('id', 'all_site', 'menu', 'flag', 'year', 'line', 'name_mem'));
    }

    public function filter_specialist_report_chart(Request $req)
    {
        if ($req->tahun == 'ALL') {
            $year = DB::table('d_periode')->get();
            for ($i = 0; $i < count($year); $i++) {
                $t[$i] = $year[$i]->p_year;
                $line[$i] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_status_id = 3
                and year(k_targetdate) = '$t[$i]'
                and k_created_by = '$req->id'
                group by k_site,s_name;
          ");
            }
            $pie = DB::select("
            SELECT m_name,s_name,m_id,u_name,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NA,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Unacceptable,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NI,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Good,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Outstanding,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as ttl,
            (SELECT COUNT(a_kpi.k_id) FROM a_kpi where a_kpi.k_created_by = m_id group by k_created_by) as ttl_kpi
            FROM a_kpi
            join d_mem on m_id=k_created_by
            join d_site on s_id=k_site
            join d_unit on m_unit=u_id
            and k_created_by = '$req->id'
            GROUP BY m_name,s_name,m_id,u_name
            ");
        } else {
            $year = DB::table('d_periode')->where('p_year', $req->tahun)->get();
            $line[0] = DB::select("SELECT count(k_site) as total,s_name FROM d_site
                left join a_kpi on d_site.s_id = a_kpi.k_site
                where k_status_id = 3
                and year(k_targetdate) = '$req->tahun'
                and k_created_by = '$req->id'
                group by k_site,s_name;
          ");

            $pie = DB::select("
            SELECT m_name,s_name,m_id,u_name,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as NA,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as Unacceptable,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as NI,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as Good,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as Outstanding,
            (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id and year(k_targetdate) = '$req->tahun' group by k_created_by) as ttl,
            (SELECT COUNT(a_kpi.k_id) FROM a_kpi where a_kpi.k_created_by = m_id and k_status_id = 3 and year(k_targetdate) = '$req->tahun' group by k_created_by) as ttl_kpi
            FROM a_kpi
            join d_mem on m_id=k_created_by
            join d_site on s_id=k_site
            join d_unit on m_unit=u_id
            and year(k_targetdate) = '$req->tahun'
            and k_created_by = '$req->id'
            GROUP BY m_name,s_name,m_id,u_name
            ");
        }
        $name_mem = auth()->user()->m_name;
        // return $pie;
        return view('report.kpi.all_spec_filter', compact('pie', 'year', 'line', 'name_mem'));
    }

    public function all_report(Request $request)
    {
        // return 'a';
        $year = DB::table('d_periode')->get();

        $id = $request->id;
        if ($id == 'ALL') {
            $site = "";
        } else {
            $site = "and s_name = '$id'";
        }
        $flag = $request->flag;
        $cabang = $id;
        $years = date('Y');
        // $now = "and k_targetdate = '$years'";
        $now = "";


        $all_site = DB::select("
        SELECT m_name,s_name,m_id,u_name,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NA,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Unacceptable,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NI,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Good,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Outstanding,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and year(k_targetdate) = $years and a_kpi.k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as ttl,
        (SELECT COUNT(a_kpi.k_id) FROM a_kpi where k_created_by = m_id and year(k_targetdate) = $years and (a_kpi.k_status_id = 1 OR a_kpi.k_status_id = 3 OR a_kpi.k_status_id = 11 OR a_kpi.k_status_id = 14 OR a_kpi.k_status_id = 17) group by k_created_by) as ttl_kpi
        FROM a_kpi
        join d_mem on m_id=k_created_by
        join d_site on s_id=k_site
        join d_unit on m_unit=u_id
        where k_unit = '$request->flag'  $site 
        GROUP BY m_name,s_name,m_id,u_name
        ");

        $menu  = DB::table('d_menu')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman All Total Report',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.all_site_manager', compact('id', 'all_site', 'menu', 'flag', 'year', 'cabang'));
    }

    public function specialist_report(Request $request)
    {
        $id = $request->id;
        $year = DB::table('d_periode')->get();
        $id_mem = auth()->user()->m_id;
        $cabang = session('site_name');
        $flag = session('unit_flag');

        $all_site = DB::select("
        SELECT m_name,s_name,m_id,u_name,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'N/A' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NA,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Unacceptable' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Unacceptable,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'NI' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as NI,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Good' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Good,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as Outstanding,
        (SELECT COUNT(a_kpi.k_finalresult_text) FROM a_kpi where k_finalresult_text = 'Outstanding' and k_status_id = 3 and a_kpi.k_created_by = m_id group by k_created_by) as ttl,
        (SELECT COUNT(a_kpi.k_id) FROM a_kpi where a_kpi.k_created_by = m_id group by k_created_by) as ttl_kpi
        FROM a_kpi
        join d_mem on m_id=k_created_by
        join d_site on s_id=k_site
        join d_unit on m_unit=u_id
        where k_created_by = $id_mem 
        GROUP BY m_name,s_name,m_id,u_name
        ");


        $menu  = DB::table('d_menu')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Total Report ',
            'dl_desc' => '-',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('report.kpi.all_site_manager', compact('id', 'all_site', 'menu', 'year', 'flag', 'cabang'));
    }

    public function panduan()
    {
        $data = DB::table('r_panduan')->get();
        return view('report.panduan',compact('data'));
    }
}
