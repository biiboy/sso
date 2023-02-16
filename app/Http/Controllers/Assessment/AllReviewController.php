<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AllReviewController extends Controller
{
    public function assessment_all_approval_review_kpi_team_asset_kediri()
    {
        return $this->filter_review_kdr_asset();
    }

    public function filter_review_kdr_asset()
    {
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (auth()->user()->m_flag == 3) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11) //In Review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 2) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 1) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }
        // return $data;

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 3)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_review_kpi_team_surabaya_support()
    {
        return $this->filter_review_sby_support();
    }

    public function filter_review_sby_support()
    {
        $menu = DB::table('d_menu')->get();
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (session('id') == $data[$i]->k_coordinator_id) {
                $data = DB::table('a_kpi')
                    ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 2)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query
                            ->where('k_status_id', '=', 11) //KPI Active
                            // ->orWhere('k_status_id', '=', 2) //KPI Draft by IT Specialist
                            // ->orWhere('k_status_id', '=', 3) //KPI Final
                            // ->orWhere('k_status_id', '=', 4) // KPI Draft by IT Coor
                            // ->orWhere('k_status_id', '=', 11) // in review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                        // ->orWhere('k_status_id', '=', 12) // Rejected by Coor
                        // ->orWhere('k_status_id', '=', 15) // Rejected by Lead
                        // ->orWhere('k_status_id', '=', 18); // Rejected by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))
                    ->get();
                // return $data;
            } elseif (session('id') == $data[$i]->k_leader_id) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 2)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query
                            ->where('k_status_id', '=', 11) //KPI Active
                            // ->orWhere('k_status_id', '=', 2) //KPI Draft by IT Specialist
                            // ->orWhere('k_status_id', '=', 3) //KPI Final
                            // ->orWhere('k_status_id', '=', 4) // KPI Draft by IT Coor
                            // ->orWhere('k_status_id', '=', 5) // KPI Draft by IT Lead
                            // ->orWhere('k_status_id', '=', 11) // in review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                        // ->orWhere('k_status_id', '=', 12) // Rejected by Coor
                        // ->orWhere('k_status_id', '=', 15) // Rejected by Lead
                        // ->orWhere('k_status_id', '=', 18); // Rejected by Manager
                    })
                    ->Where('k_leader_id', '=', session('id'))
                    ->get();
                // return $data;
            } elseif (session('id') == $data[$i]->k_manager_id) {
                $data = DB::table('a_kpi')
                    ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 2)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query
                            ->where('k_status_id', '=', 11) //KPI Active
                            // ->orWhere('k_status_id', '=', 2) //KPI Draft by IT Specialist
                            // ->orWhere('k_status_id', '=', 3) //KPI Final
                            // ->orWhere('k_status_id', '=', 4) // KPI Draft by IT Coor
                            // ->orWhere('k_status_id', '=', 5) // KPI Draft by IT Lead
                            // ->orWhere('k_status_id', '=', 11) // in review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                        // ->orWhere('k_status_id', '=', 12) // Rejected by Coor
                        // ->orWhere('k_status_id', '=', 15) // Rejected by Lead
                        // ->orWhere('k_status_id', '=', 18); // Rejected by Manager
                    })
                    ->Where('k_manager_id', '=', session('id'))
                    ->get();
            }
        }
        // return $data;

        // $tittle = 'Assessment > KPI Team > IT Support > Surabaya';
        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . ' Surabaya',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 4) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_review_kpi_team_support_gempol()
    {
        return $this->filter_review_gmp_support();
    }

    public function filter_review_gmp_support()
    {
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (auth()->user()->m_flag == 3) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 1)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11) //In Review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 2) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 1)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 1) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 1)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }
        // return $data;

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 2)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_review_kpi_team_jakarta_helpdesk()
    {
        return $this->filter_review_jkt_helpdesk();
    }

    public function filter_review_jkt_helpdesk()
    {
        $menu = DB::table('d_menu')->get();
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (auth()->user()->m_flag == 3) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 1)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11) //KPI Active
                            // ->orWhere('k_status_id', '=', 2) //KPI Draft by IT Specialist
                            // ->orWhere('k_status_id', '=', 3) //KPI Final
                            // ->orWhere('k_status_id', '=', 4) // KPI Draft by IT Coor
                            // ->orWhere('k_status_id', '=', 11) // in review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                        // ->orWhere('k_status_id', '=', 12) // Rejected by Coor
                        // ->orWhere('k_status_id', '=', 15) // Rejected by Lead
                        // ->orWhere('k_status_id', '=', 18); // Rejected by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 2) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 1)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 1)
                            ->orWhere('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17)
                            ->orWhere('k_status_id', '=', 3);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 1) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 1)
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();
        $log = DB::table('d_log')->insert([
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 1)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_review_kpi_team_jakarta_support()
    {
        return $this->filter_review_jkt_support();
    }

    public function filter_review_jkt_support()
    {
        $menu = DB::table('d_menu')->get();
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (auth()->user()->m_flag == 3) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11) //KPI Active
                            // ->orWhere('k_status_id', '=', 2) //KPI Draft by IT Specialist
                            // ->orWhere('k_status_id', '=', 3) //KPI Final
                            // ->orWhere('k_status_id', '=', 4) // KPI Draft by IT Coor
                            // ->orWhere('k_status_id', '=', 11) // in review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                        // ->orWhere('k_status_id', '=', 12) // Rejected by Coor
                        // ->orWhere('k_status_id', '=', 15) // Rejected by Lead
                        // ->orWhere('k_status_id', '=', 18); // Rejected by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 2) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 1) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 3)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }
        // return $data;

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 2)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_review_kpi_team_support_kediri()
    {
        return $this->filter_review_kdr_support();
    }

    public function filter_review_kdr_support()
    {
        $menu = DB::table('d_menu')->get();
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (auth()->user()->m_flag == 3) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11) //In Review by Coor
                            ->orWhere('k_status_id', '=', 14) //in review by Lead
                            ->orWhere('k_status_id', '=', 17); //in review by Manager
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 2) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (auth()->user()->m_flag == 1) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 4)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }
        // return $data;

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 2)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'menu', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_review_kpi_team_all_support()
    {
        return $this->filter_review_all_support();
    }

    public function filter_review_all_support()
    {
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (session('id') == $data[$i]->k_coordinator_id) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 1)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
            } else if (session('id') == $data[$i]->k_leader_id) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    // ->Where('k_site','=',1)
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
            } else if (session('id') == $data[$i]->k_manager_id) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_unit', '=', 2)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 2)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_review_kpi_team_all_asset()
    {
        return $this->filter_review_all_asset();
    }

    public function filter_review_all_asset()
    {
        $data = DB::table('a_kpi')->get();
        for ($i = 0; $i < count($data); $i++) {
            if (session('id') == $data[$i]->k_coordinator_id) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    ->Where('k_site', '=', 1)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_coordinator_id', '=', session('id'))->get();
                // return $data;
            } else if (session('id') == $data[$i]->k_leader_id) {
                // return 'a';
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    // ->Where('k_site','=',1)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_leader_id', '=', session('id'))->get();
                // return $data;
            } else if (session('id') == $data[$i]->k_manager_id) {
                $data = DB::table('a_kpi')
                    ->select(
                        'a_kpi.*',
                        'd_mem_i.m_name as manager',
                        'd_mem_ii.m_name as leader',
                        'd_mem_iii.m_name as coor',
                        'd_mem_iiii.m_name as spec',
                        'd_mem_iiiii.m_name as submitter',
                        'd_mem_i.m_site',
                        'd_site.s_name'
                    )
                    ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                    ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                    ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                    ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                    ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                    ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                    // ->Where('k_site','=',1)
                    ->Where('k_unit', '=', 3)
                    ->where(function ($query) {
                        $query->where('k_status_id', '=', 11)
                            ->orWhere('k_status_id', '=', 14)
                            ->orWhere('k_status_id', '=', 17);
                    })
                    ->Where('k_manager_id', '=', session('id'))->get();
            }
        }
        // return $data;

        $tittle = 'Task To Do > Review';
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman Task To Do > Review ',
            'dl_desc' => '' . session('unit') . '',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select(
                    'a_kpi.*',
                    'd_mem_i.m_name as manager',
                    'd_mem_ii.m_name as leader',
                    'd_mem_iii.m_name as coor',
                    'd_mem_iiii.m_name as spec',
                    'd_mem_iiiii.m_name as submitter',
                    'd_mem_i.m_site',
                    'd_site.s_name'
                )
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 3)
                ->get();
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else if (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.review', compact('data', 'tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }
}
