<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class KpiTeamService
{
    public static function filter_all_Services()
    {
        ini_set('max_execution_time', 3600);
        ini_set('memory_limit', '-1');

        $menu = DB::table('d_menu')->get();

        $year = DB::table('d_periode')->get();

        $tittle = 'Assessment > KPI Team > All IT Services';
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_review_all_it_services()
    {
        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        // $log = DB::table('d_log')->insert([
        //     'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
        //     'dl_desc' => '' . session('unit') . '',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.review', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_all_asset()
    {
        $menu = DB::table('d_menu')->get();
        $tittle = 'Assessment > KPI Team > All IT Asset';
        // $tittle = 'Task To Do > Review';

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > All IT Asset ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        $year = DB::table('d_periode')->get();
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year' ));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year' ));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year' ));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year' ));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_gmp_asset()
    {
        $menu = DB::table('d_menu')->get();
        $data = DB::table('a_kpi')->get();
        $year = date('Y');
        $tittle = 'Assessment > KPI Team > IT Asset Gempol';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Asset Gempol ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('data', 'menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('data', 'menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('data', 'menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('data', 'menu', 'tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_jkt_asset()
    {
        $menu = DB::table('d_menu')->get();
        $tittle = 'Assessment > KPI Team > IT Asset Jakarta';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Asset Jakarta ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_kdr_asset()
    {
        $menu = DB::table('d_menu')->get();
        $tittle = 'Assessment > KPI Team > IT Asset Kediri';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Asset Kediri ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_sby_asset()
    {
        $menu = DB::table('d_menu')->get();
        $tittle = 'Assessment > KPI Team > IT Asset Surabaya';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Asset Surabaya ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year', 'file'));
        }
        if (auth()->user()->m_flag == 3) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year', 'file'));
        } elseif (auth()->user()->m_flag == 2) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year', 'file'));
        } elseif (auth()->user()->m_flag == 1) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('menu', 'tittle', 'year', 'file'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_jkt_helpdesk()
    {
        $tittle = 'Assessment > KPI Team > IT Helpdesk Jakarta';
        $year = DB::table('d_periode')->get();

        // $log = DB::table('d_log')->insert([
        //     'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Helpdesk Jakarta ',
        //     'dl_desc' => '' . session('unit') . '',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_all_support()
    {
        $tittle = 'Assessment > KPI Team > All IT Support';

        // $log = DB::table('d_log')->insert([
        //     'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > All IT Support ',
        //     'dl_desc' => '' . session('unit') . '',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        $year = DB::table('d_periode')->get();
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_gmp_support()
    {
        $tittle = 'Assessment > KPI Team > IT Support Gempol';
        $year = DB::table('d_periode')->get();

        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_jkt_support()
    {
        $year = DB::table('d_periode')->get();

        // $log = DB::table('d_log')->insert([
        //     'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Support Jakarta ',
        //     'dl_desc' => '' . session('unit') . '',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        }
        $tittle = 'Assessment > KPI Team > IT Support Jakarta';
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_kdr_support()
    {
        $tittle = 'Assessment > KPI Team > IT Support Kediri';
        $year = DB::table('d_periode')->get();
        if (auth()->user()->m_flag == 0) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public static function filter_sby_support()
    {
        $tittle = 'Assessment > KPI Team > IT Support Surabaya';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Assessment > KPI Team > IT Support Surabaya',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 4) {
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year', 'file'));
        } elseif (auth()->user()->m_flag == 2) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year', 'file'));
        } elseif (auth()->user()->m_flag == 1) {
            $file = DB::table('a_kpi_pdf')
                ->where('kpdf_site', '2')
                ->get();
            return view('assessment.all_approval.kpi_team', compact('tittle', 'year', 'file'));
        } else {
            return view('page.privilege_not_access');
        }
    }
}
