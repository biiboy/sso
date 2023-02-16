<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\Kpi;
use App\Models\Kpid;
use App\Services\KpiTeamService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AllApprovalController extends Controller
{
    public function index()
    {
        $tittle = 'Task To Do > Approval';
        $year = DB::table('d_periode')->get();

        // $log = DB::table('d_log')->insert([
        //     'dl_name' => '' . session('name') . ' akses halaman Task To Do > Approval ',
        //     'dl_desc' => '' . session('unit') . '',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        if (auth()->user()->m_flag == 4) {
            return view('assessment.all_approval.index', compact('tittle', 'year'));
        }
        if (auth()->user()->m_flag == 3) {
            return view('assessment.all_approval.index', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 2) {
            return view('assessment.all_approval.index', compact('tittle', 'year'));
        } elseif (auth()->user()->m_flag == 1) {
            return view('assessment.all_approval.index', compact('tittle', 'year'));
        } else {
            return view('page.previllege_not_access');
        }
    }

    public function assessment_all_approval_datatables(Request $req)
    {
        $data = DB::table('a_kpi')
            ->where(function ($query) use ($req) {
                if ($req->tahun == 'ALL') {
                } else {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->get();
        $data2 = DB::table('a_kpid')->get();

        if (auth()->user()->m_flag == 3) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')

                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_coordinator_id', '=', session('id'))
                ->Where('k_unit', '=', session('unit_flag'))
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 13)
                        ->orWhere('k_status_id', '=', 16);
                })
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->get();
        } elseif (auth()->user()->m_flag == 2) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_leader_id', '=', session('id'))
                ->Where('k_unit', '=', session('unit_flag'))
                ->where(function ($query) {
                    $query->Where('k_status_id', '=', 13)->orWhere('k_status_id', '=', 16);
                })
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->get();
        } elseif (auth()->user()->m_flag == 1) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_manager_id', '=', session('id'))
                ->where(function ($query) {
                    $query->Where('k_status_id', '=', 16);
                })
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->get();
        }

        $data2 = [];
        $data2List = [];

        for ($i = 0; $i < count($data); $i++) {
            $data2List[$i] = DB::table('a_kpid')
                ->select('kd_id', 'kd_duedate', 'kd_kpi_id')
                ->where('kd_kpi_id', $data[$i]->k_id)
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->get();
        }
        for ($i = 0; $i < count($data2List); $i++) {
            for ($j = 0; $j < count($data2List[$i]); $j++) {
                $data2[$i][$j] = $data2List[$i][$j];
            }
        }
        if (auth()->user()->m_flag == 4 && auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.*', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'd_mem_iiii.m_name as spec', 'd_mem_iiiii.m_name as submitter', 'd_mem_i.m_site', 'd_site.s_name')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('lastModified', function ($row) {
                return date('d-M-Y h:i:s', strtotime($row->k_updated_at));
            })
            ->addColumn('created', function ($row) {
                return date('d-M-Y h:i:s', strtotime($row->k_created_at));
            })
            ->addColumn('firstDueDate', function ($row) use ($data2) {
                $dt = [];
                $kolek = '';
                for ($i = 0; $i < count($data2); $i++) {
                    for ($j = 0; $j < count($data2[$i]); $j++) {
                        if ($data2[$i][$j]->kd_kpi_id == $row->k_id) {
                            array_push($dt, date('d-M-Y h:i:s', strtotime($data2[$i][$j]->kd_duedate)));
                            $unik = array_unique($dt);
                            $kolek = collect($unik)->first();
                        }
                    }
                }
                return $kolek;
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($data2) {
                if ($row->k_status_id == 1) {
                    $dt = [];
                    $kolek = '';

                    if ($row->k_status_id == 1) {
                        for ($i = 0; $i < count($data2); $i++) {
                            for ($j = 0; $j < count($data2[$i]); $j++) {
                                if ($data2[$i][$j]->kd_kpi_id == $row->k_id) {
                                    if ($data2[$i][$j]->kd_status_id != 'Completed') {
                                        array_push($dt, (strtotime(date('Y-m-d')) - strtotime($data2[$i][$j]->kd_duedate)) / 86400);
                                        $unik = array_unique($dt);
                                        $kolek = collect($unik)->first();
                                    }
                                }
                            }
                        }

                        if ($kolek >= -7 && $kolek <= 22) {
                            if ($kolek > 0) {
                                $h = '+' . $kolek;
                            } elseif ($kolek == 0) {
                                $h = 'Today';
                            } else {
                                $h = $kolek;
                            }
                            $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline">Active H' . $h . '</span>';
                        } else {
                            $status = 'Active';
                        }
                    }

                    // $status = 'status 1';
                } elseif ($row->k_status_id == 2) {
                    $status = 'Draft';
                    // {{-- SPEC --}}
                } elseif ($row->k_status_id == 3) {
                    $status = 'Final';
                    if ($row->k_finalresult_text == 'Good') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline">Good</span>';
                    } elseif ($row->k_finalresult_text == 'NI') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-warning-lt badge-outline">Need Improvement</span>';
                    } elseif ($row->k_finalresult_text == 'Outstanding') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-success-lt badge-outline">Outstanding</span>';
                    } elseif ($row->k_finalresult_text == 'Unacceptable') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-danger-lt badge-outline">Unacceptable</span>';
                    } elseif ($row->k_finalresult_text == 'N/A') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline" style="background-color: #999 !important">N/A</span>';
                    }
                } elseif ($row->k_status_id == 4) {
                    $status = 'Draft';
                    // {{-- COOR --}}
                } elseif ($row->k_status_id == 5) {
                    $status = 'Draft';
                    // {{-- LEAD --}}
                } elseif ($row->k_status_id == 6) {
                    $status = 'Draft';
                    // {{-- MANAGER --}}
                    // {{-- APPROVE FROM COOR --}}
                } elseif ($row->k_status_id == 10) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'Waiting for Approval ' . $row->coor;
                    } else {
                        $status = 'Waiting for Approval ' . $row->coor;
                    }
                } elseif ($row->k_status_id == 11) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'In Review by ' . $row->coor;
                    } else {
                        $status = 'In Review by ' . $row->coor;
                    }
                } elseif ($row->k_status_id == 12) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->coor . '</span>';

                    // {{-- APPROVE FROM LEAD --}}
                } elseif ($row->k_status_id == 13) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'Waiting for Approval ' . $row->leader;
                    } else {
                        $status = 'Waiting for Approval ' . $row->leader;
                    }
                } elseif ($row->k_status_id == 14) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'In Review by ' . $row->leader;
                    } else {
                        $status = 'In Review by ' . $row->leader;
                    }
                } elseif ($row->k_status_id == 15) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->leader . '</span>';
                    // {{-- APPROVE FROM MANAGER --}}
                } elseif ($row->k_status_id == 16) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'Waiting for Approval ' . $row->manager;
                    } else {
                        $status = 'Waiting for Approval ' . $row->manager;
                    }
                } elseif ($row->k_status_id == 17) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'In Review by ' . $row->manager;
                    } else {
                        $status = 'In Review by ' . $row->manager;
                    }
                } elseif ($row->k_status_id == 18) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->manager . '</span>';
                }
                return $status;
            })
            ->addColumn('collab', function ($row) {
                if ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    $collab = 'IT Helpdesk ';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    $collab = 'IT Asset dan IT Helpdesk';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    $collab = 'IT Support dan IT Helpdesk';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    $collab = 'All IT Services';
                }

                // {{-- Collab sama IT ASset --}}
                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    $collab = 'IT Asset ';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    $collab = 'IT Asset dan IT Support';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    $collab = 'IT Support';
                }

                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    $collab = '-';
                }
                return $collab;
            })
            ->rawColumns(['action', 'date', 'status', 'goal', 'lastModified', 'collab', 'created', 'firstDueDate'])
            ->make(true);
    }

    public function approval($id)
    {
        $data = DB::table('a_kpi')->join('d_mem', 'm_id', 'k_created_by')->where('k_id', $id)->first();
        $datad = DB::table('a_kpid')->where('kd_kpi_id', $id)->get();
        $measure = DB::table('d_measure')->get();

        for ($i = 0; $i < count($datad); $i++) {
            $check_total_cmnt[$i] = DB::table('a_kpi_comment')
                ->where('kc_ref_id', $datad[$i]->kd_id)
                ->count();
        }

        $check_total_header_kra[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data->k_id)
            ->where('kch_flag', 1)
            ->count();

        $check_total_header_goal[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data->k_id)
            ->where('kch_flag', 2)
            ->count();

        $check_total_header_date[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data->k_id)
            ->where('kch_flag', 3)
            ->count();

        if (auth()->user()->m_flag != 4) {
            return view('assessment.all_approval.approval', compact('check_total_cmnt', 'check_total_header_kra', 'check_total_header_goal', 'check_total_header_date', 'data', 'datad', 'measure'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public function appraisal($id)
    {
        $data = DB::table('a_kpi')
            ->join('d_mem', 'm_id', 'k_created_by')
            ->where('k_id', $id)
            ->first();
        $datad = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();
        $measure = DB::table('d_measure')->get();

        return view('assessment.all_approval.appraisal', compact('data', 'datad', 'measure'));
    }

    public function assessment_all_approval_save_proof_doc(Request $request)
    {
        if ($request->file('file1') != null) {
            for ($i = 0; $i < count($request->file1); $i++) {
                $check_count = DB::table('a_kpid_file')
                    ->where('kpf_ref_id', $request->hidden_id_header)
                    ->where('kpf_ref_iddt', $request->kd_id)
                    ->count();
                if ($check_count == 0) {
                    $check_count = 0;
                } else {
                    $check_count += 1;
                }

                $check = array_values(array_filter($request->file('file1')));
                $file = $check[$i];
                $filename = 'public/file/' . 'Proof_Document_' . auth()->user()->m_name . '_' . $request->hidden_id_header . '_' . $check_count . '_' . $request->kd_id . '.pdf';

                Storage::put($filename, file_get_contents($file));

                $save_file = DB::table('a_kpid_file')->insert([
                    'kpf_ref_id' => $request->hidden_id_header,
                    'kpf_ref_iddt' => $request->kd_id,
                    'kpf_file' => $filename,

                    'kpf_created_by' => auth()->user()->m_id,
                    'kpf_upload_date' => date('Y-m-d H:i:s'),
                    'kpf_created_at' => date('Y-m-d H:i:s'),
                    'kpf_updated_at' => date('Y-m-d H:i:s'),
                ]);

                $save_file_1 = DB::table('a_kpid')
                    ->where('kd_id', $request->kd_id)
                    ->where('kd_kpi_id', $request->hidden_id_header)
                    ->update([
                        'kd_comment' => $request->kd_comment,
                    ]);

                $save_file_2 = DB::table('a_kpi')
                    // ->where('k_id',$request->k_id)
                    ->where('k_id', $request->hidden_id_header)
                    ->update([
                        'k_updated_at' => date('Y-m-d H:i:s'),
                    ]);

                // $log_detail = DB::table('d_log')->insert([
                //     'dl_name' => 'Save => Upload Proof Document BY ' . session('name'),
                //     'dl_desc' => $request->kd_comment,
                //     'dl_filename' => $filename,
                //     'dl_menu' => 11,
                //     'dl_ref_id' => $request->hidden_id_header,
                //     'dl_ref_id_detail' => $request->kd_id,
                //     'dl_created_at' => date('Y-m-d H:i'),
                //     'dl_created_by' => auth()->user()->m_id,
                // ]);
            }
        } else {
            $save_file = DB::table('a_kpid')
                ->where('kd_id', $request->kd_id)
                ->where('kd_kpi_id', $request->hidden_id_header)
                ->update([
                    'kd_comment' => $request->kd_comment,
                ]);

            // $log_detail = DB::table('d_log')->insert([
            //     'dl_name' => 'Save => Upload Proof Document BY ' . session('name'),
            //     'dl_desc' => $request->kd_comment,
            //     'dl_filename' => null,
            //     'dl_menu' => 11,
            //     'dl_ref_id' => $request->hidden_id_header,
            //     'dl_ref_id_detail' => $request->kd_id,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);
        }

        return response()->json(['status' => 'sukses']);
    }
    public function finalis($id)
    {
        $data = DB::table('a_kpi')
            ->join('d_mem', 'm_id', 'k_created_by')
            ->where('k_id', $id)
            ->first();
        $datad = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();
        $measure = DB::table('d_measure')->get();
        $result = DB::table('d_result')->get();

        return view('assessment.all_approval.final', compact('data', 'datad', 'measure', 'result'));
    }

    public function show_comment(Request $request)
    {
        $data = DB::table('a_kpi_comment')
            ->leftjoin('d_mem', 'm_id', 'kc_created_by')
            ->where('kc_ref_id', $request->kd_ref_id)
            ->get();

        return response()->json([
            'data_cm' => $data,
            'status' => 'sukses'
        ]);
    }

    public function save_comment(Request $request)
    {
        $data = DB::table('a_kpi_comment')->insert([
            'kc_ref_id' => $request->kd_ref_id,
            'kc_comment' => $request->kd_comment,
            'kc_created_at' => date('Y-m-d H:i'),
            'kc_created_by' => session('id'),
        ]);

        return response()->json([
            'ref' => $request->id,
            'date' => date('Y-m-d H:i'),
            'created_by' => session('username'),
            'comment' => $request->kd_comment,
            'status' => 'sukses'
        ]);
    }

    public function show_comment_kra(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')
            ->leftjoin('d_mem', 'm_id', 'kch_created_by')
            ->where('kch_ref_id', $request->k_id)
            ->where('kch_flag', 1)
            ->get();

        return response()->json([
            'data_cm' => $data,
            'status' => 'sukses'
        ]);
    }

    public function save_comment_kra(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')->insert([
            'kch_ref_id' => $request->k_id,
            'kch_comment' => $request->k_comment,
            'kch_flag' => 1,
            'kch_created_at' => date('Y-m-d H:i'),
            'kch_created_by' => session('id'),
        ]);

        return response()->json([
            'ref' => $request->k_id,
            'date' => date('Y-m-d H:i'),
            'created_by' => session('username'),
            'comment' => $request->k_comment,
            'status' => 'sukses'
        ]);
    }

    public function show_comment_goal(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')
            ->leftjoin('d_mem', 'm_id', 'kch_created_by')
            ->where('kch_ref_id', $request->k_id)
            ->where('kch_flag', 2)
            ->get();

        return response()->json([
            'data_cm' => $data,
            'status' => 'sukses'
        ]);
    }

    public function save_comment_goal(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')->insert([
            'kch_ref_id' => $request->k_id,
            'kch_comment' => $request->k_comment,
            'kch_flag' => 2,
            'kch_created_at' => date('Y-m-d H:i'),
            'kch_created_by' => session('id'),
        ]);

        return response()->json([
            'ref' => $request->k_id,
            'date' => date('Y-m-d H:i'),
            'created_by' => session('username'),
            'comment' => $request->k_comment,
            'status' => 'sukses'
        ]);
    }

    public function show_comment_date(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')
            ->leftjoin('d_mem', 'm_id', 'kch_created_by')
            ->where('kch_ref_id', $request->k_id)
            ->where('kch_flag', 3)
            ->get();

        return response()->json([
            'data_cm' => $data,
            'status' => 'sukses'
        ]);
    }

    public function save_comment_date(Request $request)
    {
        $data = DB::table('a_kpi_comment_header')->insert([
            'kch_ref_id' => $request->k_id,
            'kch_comment' => $request->k_comment,
            'kch_flag' => 3,
            'kch_created_at' => date('Y-m-d H:i'),
            'kch_created_by' => session('id'),
        ]);

        return response()->json([
            'ref' => $request->k_id,
            'date' => date('Y-m-d H:i'),
            'created_by' => session('username'),
            'comment' => $request->k_comment,
            'status' => 'sukses'
        ]);
    }

    private function getStatus($row, $req)
    {
        if ($row->k_status_id == 1) {
            $kolek = '';
            if ($row->k_status_id == 1) {
                $kpid = Kpid::where(function ($q) {
                    $q->where('kd_status_Id', null);
                    $q->orWhere('kd_status_Id', 'In Progress');
                })
                    ->where('kd_kpi_id', $row->k_id)
                    ->where(function ($q) use ($req) {
                        if ($req->tahun != 'ALL') {
                            $q->whereYear('kd_duedate', $req->tahun);
                        }
                    })
                    ->orderBy('kd_duedate', 'ASC')
                    ->first();

                if ($kpid) {
                    $kolek = Carbon::parse($kpid->kd_duedate)->subDays(-1)->diffInDays(Carbon::now());

                    if ($kpid->kd_duedate > Carbon::now()->format('Y-m-d')) {
                        $kolek *= -1;
                    }
                }

                if ($kolek >= -7 && $kolek <= 22) {
                    if ($kolek > 0) {
                        $h = '+' . $kolek;
                    } elseif ($kolek == 0) {
                        $h = 'Today';
                    } else {
                        $h = $kolek;
                    }
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline">Active H' . $h . '</span>';
                } else {
                    $status = 'Active';
                }
            }
        } elseif ($row->k_status_id == 2 || $row->k_status_id == 4 || $row->k_status_id == 5 || $row->k_status_id == 6) {
            $status = 'Draft';
        } elseif ($row->k_status_id == 3) {
            $status = 'Final';
            if ($row->k_finalresult_text == 'Good') {
                $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline">Good</span>';
            } elseif ($row->k_finalresult_text == 'NI') {
                $status = 'Final <span class="badge badge-pill fw-normal bg-warning-lt badge-outline">Need Improvement</span>';
            } elseif ($row->k_finalresult_text == 'Outstanding') {
                $status = 'Final <span class="badge badge-pill fw-normal bg-success-lt badge-outline">Outstanding</span>';
            } elseif ($row->k_finalresult_text == 'Unacceptable') {
                $status = 'Final <span class="badge badge-pill fw-normal bg-danger-lt badge-outline">Unacceptable</span>';
            } elseif ($row->k_finalresult_text == 'N/A') {
                $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline" style="background-color: #999 !important">N/A</span>';
            }
        } elseif ($row->k_status_id == 10) {
            if (auth()->user()->m_flag == 3) {
                $status = 'Waiting for Approval ' . $row->coor;
            } else {
                $status = 'Waiting for Approval ' . $row->coor;
            }
        } elseif ($row->k_status_id == 11) {
            if (auth()->user()->m_flag == 3) {
                $status = 'In Review by ' . $row->coor;
            } else {
                $status = 'In Review by ' . $row->coor;
            }
        } elseif ($row->k_status_id == 12) {
            $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('coor') . '</span>';

            // {{-- APPROVE FROM LEAD --}}
        } elseif ($row->k_status_id == 13) {
            if (auth()->user()->m_flag == 2) {
                $status = 'Waiting for Approval ' . $row->leader;
            } else {
                $status = 'Waiting for Approval ' . $row->leader;
            }
        } elseif ($row->k_status_id == 14) {
            if (auth()->user()->m_flag == 2) {
                $status = 'In Review by ' . $row->leader;
            } else {
                $status = 'In Review by ' . $row->leader;
            }
        } elseif ($row->k_status_id == 15) {
            $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('lead') . '</span>';
            // {{-- APPROVE FROM MANAGER --}}
        } elseif ($row->k_status_id == 16) {
            if (auth()->user()->m_flag == 1) {
                $status = 'Waiting for Approval ' . $row->manager;
            } else {
                $status = 'Waiting for Approval ' . $row->manager;
            }
        } elseif ($row->k_status_id == 17) {
            if (auth()->user()->m_flag == 1) {
                $status = 'In Review by ' . $row->manager;
            } else {
                $status = 'In Review by ' . $row->manager;
            }
        } elseif ($row->k_status_id == 18) {
            $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('manager') . '</span>';
        }
        return $status;
    }

    private function getActionBtns($row)
    {
        if ($row->k_status_id == 2) {
            $actionBtn = 'Not Available';
        } elseif ($row->k_status_id == 10 || $row->k_status_id == 13 || $row->k_status_id == 16) {
            $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_approval', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
        } elseif ($row->k_status_id == 12 || $row->k_status_id == 15 || $row->k_status_id == 18) {
            $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_reject', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
        } elseif ($row->k_status_id == 1) {
            $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_kpi_statusactive', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
        } else {
            $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_final', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
        }
        return $actionBtn;
    }

    public function assessment_all_approval_kpi_team_jakarta_helpdesk()
    {
        return KpiTeamService::filter_jkt_helpdesk();
    }

    public function assessment_all_approval_kpi_team_all_support()
    {
        return KpiTeamService::filter_all_support();
    }

    public function assessment_all_approval_kpi_team_gempol_support()
    {
        return KpiTeamService::filter_gmp_support();
    }

    public function assessment_all_approval_kpi_team_jakarta_support()
    {
        return KpiTeamService::filter_jkt_support();
    }

    public function assessment_all_approval_kpi_team_kediri_support()
    {
        return KpiTeamService::filter_kdr_support();
    }

    public function assessment_all_approval_kpi_team_surabaya_support()
    {
        return KpiTeamService::filter_sby_support();
    }

    public function filter_jkt_helpdesk_datatables(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 1)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 1)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 1)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function filter_all_support_datatables(Request $req)
    {
        $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
            ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
            ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
            ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
            ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
            ->where(function ($query) use ($req) {
                if ($req->tahun != 'ALL') {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->Where('k_unit', '=', 2)
            ->whereHas('kpid', function ($q) use ($req) {
                if ($req->tahun != 'ALL') {
                    $q->whereYear('kd_duedate', $req->tahun);
                }
            })
            ->where(function ($query) {
                $query
                    ->where('k_status_id', '=', 1)
                    ->orWhere('k_status_id', '=', 2)
                    ->orWhere('k_status_id', '=', 4)
                    ->orWhere('k_status_id', '=', 5)
                    ->orWhere('k_status_id', '=', 3)
                    ->orWhere('k_status_id', '=', 10)
                    ->orWhere('k_status_id', '=', 12)
                    ->orWhere('k_status_id', '=', 15)
                    ->orWhere('k_status_id', '=', 18);
            })
            ->where(function ($query) {
                if (session('unit_flag') == 2) {
                    $query->Where('k_leader_id', '=', session('id'));
                } elseif (session('unit_flag') == 2) {
                    $query->Where('k_manager_id', '=', session('id'));
                }
            })
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function filter_gmp_support_datatables(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function filter_jkt_support_datatables(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function filter_kdr_support_datatables(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }
        if (auth()->user()->m_flag == 4) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function filter_sby_support_datatables(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }
        if (auth()->user()->m_flag == 4) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 2)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_all_services()
    {
        return KpiTeamService::filter_all_services();
    }

    public function filter_all_services_datatables(Request $req)
    {
        $year = DB::table('d_periode')->get();
        $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
            ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
            ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
            ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
            ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
            ->where(function ($query) use ($req) {
                if ($req->tahun == 'ALL') {
                    # code...
                } else {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->whereHas('kpid', function ($q) use ($req) {
                if ($req->tahun != 'ALL') {
                    $q->whereYear('kd_duedate', $req->tahun);
                }
            })
            ->where(function ($query) {
                $query
                    ->where('k_status_id', '=', 1)
                    ->orWhere('k_status_id', '=', 2)
                    ->orWhere('k_status_id', '=', 4)
                    ->orWhere('k_status_id', '=', 5)
                    ->orWhere('k_status_id', '=', 3)
                    ->orWhere('k_status_id', '=', 10)
                    ->orWhere('k_status_id', '=', 12)
                    ->orWhere('k_status_id', '=', 15)
                    ->orWhere('k_status_id', '=', 18);
            })
            ->Where('k_manager_id', '=', session('id'))
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_review_kpi_team_all_services()
    {
        return KpiTeamService::filter_review_all_it_services();
    }

    public function filter_review_all_it_services_datatables(Request $req)
    {
        $data = DB::table('a_kpi')
            ->select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'a_kpi.k_collab_helpdesk', 'a_kpi.k_collab_assets', 'a_kpi.k_collab_support', 'a_kpi.k_finalresult_text')
            ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
            ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
            ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
            ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
            ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
            ->where(function ($query) {
                if (session('unit_role') == 1) {
                    $query
                        ->where('k_status_id', '=', 11)
                        ->orWhere('k_status_id', '=', 14)
                        ->orWhere('k_status_id', '=', 17);
                } elseif (session('unit_role') == 2) {
                    $query
                        ->orWhere('k_status_id', '=', 14)
                        ->orWhere('k_status_id', '=', 17);
                } elseif (session('unit_role') == 3) {
                    $query
                        ->orWhere('k_status_id', '=', 11)
                        ->orWhere('k_status_id', '=', 14)
                        ->orWhere('k_status_id', '=', 17);
                }
            })
            ->where(function ($query) {
                if (session('unit_role') == 2) {
                    $query->Where('k_leader_id', '=', session('id'));
                } elseif (session('unit_role') == 1) {
                    $query->Where('k_manager_id', '=', session('id'));
                } elseif (session('unit_role') == 3) {
                    $query->Where('k_coordinator_id', '=', session('id'));
                }
            })
            ->where(function ($query) use ($req) {
                if ($req->tahun == 'ALL') {
                } else {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->get();
        if (auth()->user()->m_flag == 0) {
            $data = DB::table('a_kpi')
                ->select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'a_kpi.k_collab_helpdesk', 'a_kpi.k_collab_assets', 'a_kpi.k_collab_support', 'a_kpi.k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->join('d_site', 'd_mem_i.m_site', '=', 'd_site.s_id')
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 3)
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->get();
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                if ($row->k_status_id == 2) {
                    $actionBtn = 'Not Available';
                } elseif ($row->k_status_id == 10 || $row->k_status_id == 13 || $row->k_status_id == 16) {
                    $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_approval', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
                } elseif ($row->k_status_id == 12 || $row->k_status_id == 15 || $row->k_status_id == 18) {
                    $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_reject', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
                } elseif ($row->k_status_id == 1) {
                    $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_kpi_statusactive', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
                } else {
                    $actionBtn = '<a class="btn btn-sm btn-primary" href="' . route('assessment_all_approval_appraisal', ['id' => $row->k_id]) . '"><i class="ti-eye me-1"></i> View</a>';
                }

                return $actionBtn;
            })
            ->addColumn('status', function ($row) {
                if ($row->k_status_id == 1) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'Active';
                    } else {
                        $status = 'Active';
                    }
                } elseif ($row->k_status_id == 2) {
                    $status = 'Draft';
                    // {{-- SPEC --}}
                } elseif ($row->k_status_id == 3) {
                    $status = 'Final';
                    if ($row->k_finalresult_text == 'Good') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline">Good</span>';
                    } elseif ($row->k_finalresult_text == 'NI') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-warning-lt badge-outline">Need Improvement</span>';
                    } elseif ($row->k_finalresult_text == 'Outstanding') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-success-lt badge-outline">Outstanding</span>';
                    } elseif ($row->k_finalresult_text == 'Unacceptable') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-danger-lt badge-outline">Unacceptable</span>';
                    } elseif ($row->k_finalresult_text == 'N/A') {
                        $status = 'Final <span class="badge badge-pill fw-normal bg-info-lt badge-outline" style="background-color: #999 !important">N/A</span>';
                    }
                } elseif ($row->k_status_id == 4) {
                    $status = 'Draft';
                    // {{-- COOR --}}
                } elseif ($row->k_status_id == 5) {
                    $status = 'Draft';
                    // {{-- LEAD --}}
                } elseif ($row->k_status_id == 6) {
                    $status = 'Draft';
                    // {{-- MANAGER --}}
                    // {{-- APPROVE FROM COOR --}}
                } elseif ($row->k_status_id == 10) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'Waiting for Approval ' . $row->coor;
                    } else {
                        $status = 'Waiting for Approval ' . $row->coor;
                    }
                } elseif ($row->k_status_id == 11) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'In Review by ' . $row->coor;
                    } else {
                        $status = 'In Review by ' . $row->coor;
                    }
                } elseif ($row->k_status_id == 12) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->coor . '</span>';
                    // {{-- APPROVE FROM LEAD --}}
                } elseif ($row->k_status_id == 13) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'Waiting for Approval ' . $row->leader;
                    } else {
                        $status = 'Waiting for Approval ' . $row->leader;
                    }
                } elseif ($row->k_status_id == 14) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'In Review by ' . $row->leader;
                    } else {
                        $status = 'In Review by ' . $row->leader;
                    }
                } elseif ($row->k_status_id == 15) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->coor . '</span>';                    // {{-- APPROVE FROM MANAGER --}}
                } elseif ($row->k_status_id == 16) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'Waiting for Approval ' . $row->manager;
                    } else {
                        $status = 'Waiting for Approval ' . $row->manager;
                    }
                } elseif ($row->k_status_id == 17) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'In Review by ' . $row->manager;
                    } else {
                        $status = 'In Review by ' . $row->manager;
                    }
                } elseif ($row->k_status_id == 18) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . $row->coor . '</span>';
                }
                return $status;
            })
            ->addColumn('collab', function ($row) {
                if ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    $collab = 'IT Helpdesk ';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    $collab = 'IT Asset dan IT Helpdesk';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    $collab = 'IT Support dan IT Helpdesk';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    $collab = 'All IT Services';
                }

                // {{-- Collab sama IT ASset --}}
                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    $collab = 'IT Asset ';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    $collab = 'IT Asset dan IT Support';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    $collab = 'IT Support';
                }

                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    $collab = '-';
                }
                return $collab;
            })
            ->rawColumns(['action', 'date', 'status', 'goal', 'collab'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_all_asset()
    {
        return KpiTeamService::filter_all_asset();
    }

    public function filter_all_asset_datatable(Request $req)
    {

        $year = DB::table('d_periode')->get();

        $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
            ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
            ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
            ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
            ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
            ->where(function ($query) use ($req) {
                if ($req->tahun == 'ALL') {
                    # code...
                } else {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->Where('k_unit', '=', 3)
            ->whereHas('kpid', function ($q) use ($req) {
                if ($req->tahun != 'ALL') {
                    $q->whereYear('kd_duedate', $req->tahun);
                }
            })
            ->where(function ($query) {
                $query
                    ->where('k_status_id', '=', 1)
                    ->orWhere('k_status_id', '=', 2)
                    ->orWhere('k_status_id', '=', 4)
                    ->orWhere('k_status_id', '=', 5)
                    ->orWhere('k_status_id', '=', 3)
                    ->orWhere('k_status_id', '=', 10)
                    ->orWhere('k_status_id', '=', 12)
                    ->orWhere('k_status_id', '=', 15)
                    ->orWhere('k_status_id', '=', 18);
            })
            // ->Where('k_manager_id', '=', session('id'))
            ->where(function ($query) {
                if (session('unit_flag') == 2) {
                    $query->Where('k_leader_id', '=', session('id'));
                } elseif (session('unit_flag') == 2) {
                    $query->Where('k_manager_id', '=', session('id'));
                }
            })
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_gempol_asset()
    {
        return KpiTeamService::filter_gmp_asset();
    }

    public function filter_gmp_asset_datatables(Request $req)
    {

        $year = DB::table('d_periode')->get();

        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 1)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_jakarta_asset()
    {
        return KpiTeamService::filter_jkt_asset();
    }

    public function filter_jkt_asset_datatables(Request $req)
    {

        $year = DB::table('d_periode')->get();

        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 3)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_kediri_asset()
    {
        return KpiTeamService::filter_kdr_asset();
    }

    public function filter_kdr_asset_datatables(Request $req)
    {
        $year = DB::table('d_periode')->get();

        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 4)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }

    public function assessment_all_approval_kpi_team_surabaya_asset()
    {
        return KpiTeamService::filter_sby_asset();
    }

    public function filter_sby_asset_datatables(Request $req)
    {
        $year = DB::table('d_periode')->get();

        if (auth()->user()->m_flag == 1) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_manager_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 2) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_leader_id', '=', session('id'))
                ->get();
        }

        if (auth()->user()->m_flag == 3) {
            $data = Kpi::select('a_kpi.k_goal', 'a_kpi.k_label', 'a_kpi.k_id', 'a_kpi.k_targetdate', 'd_mem_iiiii.m_name as submitter', 'k_status_id', 'd_mem_i.m_name as manager', 'd_mem_ii.m_name as leader', 'd_mem_iii.m_name as coor', 'k_finalresult_text')
                ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
                ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
                ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
                ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
                ->where(function ($query) use ($req) {
                    if ($req->tahun == 'ALL') {
                        # code...
                    } else {
                        $query->whereYear('k_targetdate', $req->tahun);
                    }
                })
                ->Where('k_site', '=', 2)
                ->Where('k_unit', '=', 3)
                ->whereHas('kpid', function ($q) use ($req) {
                    if ($req->tahun != 'ALL') {
                        $q->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where(function ($query) {
                    $query
                        ->where('k_status_id', '=', 1)
                        ->orWhere('k_status_id', '=', 2)
                        ->orWhere('k_status_id', '=', 4)
                        ->orWhere('k_status_id', '=', 5)
                        ->orWhere('k_status_id', '=', 3)
                        ->orWhere('k_status_id', '=', 10)
                        ->orWhere('k_status_id', '=', 12)
                        ->orWhere('k_status_id', '=', 15)
                        ->orWhere('k_status_id', '=', 18);
                })
                ->Where('k_coordinator_id', '=', session('id'))
                ->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'desc');
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-M-Y', strtotime($row->k_targetdate));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('action', function ($row) {
                return self::getActionBtns($row);
            })
            ->addColumn('status', function ($row) use ($req) {
                return self::getStatus($row, $req);
            })
            ->rawColumns(['action', 'date', 'status', 'goal'])
            ->make(true);
    }
    public function reject_kpi($id)
    {
        $data_edit = DB::table('a_kpi')
            ->where('k_id', $id)
            ->first();
        $data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            $check_total_cmnt[$i] = DB::table('a_kpi_comment')
                ->where('kc_ref_id', $data[$i]->kd_id)
                ->count();
        }

        $check_total_header_kra[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data_edit->k_id)
            ->where('kch_flag', 1)
            ->count();
        $check_total_header_goal[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data_edit->k_id)
            ->where('kch_flag', 2)
            ->count();
        $check_total_header_date[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data_edit->k_id)
            ->where('kch_flag', 3)
            ->count();

        $measure = DB::table('d_measure')->get();

        return view('assessment.all_approval.reject', compact('check_total_cmnt', 'check_total_header_kra', 'check_total_header_goal', 'check_total_header_date', 'data', 'data_edit', 'measure'));
    }

    public function save_appraisal(Request $request)
    {
        $check = DB::table('a_kpi as ak')
            ->select('mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead', 'mm_iiiii.m_email as email_submitter', 'mm_iiiii.m_name as name_submitter', 'ak.k_id as crement')
            ->leftjoin('d_mem as mm', 'ak.k_coordinator_id', 'mm.m_id')
            ->leftjoin('d_mem as mm_i', 'ak.k_manager_id', 'mm_i.m_id')
            ->leftjoin('d_mem as mm_ii', 'ak.k_leader_id', 'mm_ii.m_id')
            ->leftjoin('d_mem as mm_iii', 'ak.k_specialist_id', 'mm_iii.m_id')
            ->leftjoin('d_mem as mm_iiiii', 'ak.k_created_by', 'mm_iiiii.m_id')
            ->where('k_id', $request->hidden_id_header)
            ->get();

        $email_spec = $check[0]->email_spec;
        $email_manager = $check[0]->email_manager;
        $email_coor = $check[0]->email_coor;
        $email_lead = $check[0]->email_lead;
        $name_spec = $check[0]->name_spec;
        $name_manager = $check[0]->name_manager;
        $name_coor = $check[0]->name_coor;
        $name_lead = $check[0]->name_lead;
        $name_submitter = $check[0]->name_submitter;
        $crement = $check[0]->crement;

        if (auth()->user()->m_flag == 3) {
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_completed_lead',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_assessment' => $request->k_assessment,
                        'name_spec' => $name_spec,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'crement' => $crement,
                    ]
                );
            }

            // Lead receive notif KPI Coor
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_completed_coor_spec',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_assessment' => $request->k_assessment,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_coor' => $name_coor,
                    ]
                );
            }

            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.completed_by_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_assessment' => $request->k_assessment,
                        'name_spec' => $name_spec,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                    ]
                );
            }

            if ($email_manager != null && $email_lead == null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_completed_coor_hd',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_assessment' => $request->k_assessment,
                        'name_manager' => $name_manager,
                        'name_spec' => $name_spec,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                    ]
                );
            }
            // Log Completed by Coor
            // $log_detail = DB::table('d_log')->insert([
            //     'dl_name' => 'Completed KPI by ' . session('name') . ' AS ' . session('unit'),
            //     'dl_desc' => $request->k_assessment,
            //     'dl_menu' => 31,
            //     'dl_ref_id' => $request->hidden_id_header,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);

            if ($email_lead != null && $email_manager != null) {
                $check_status = 14;
            } elseif ($email_lead == null && $email_manager != null) {
                $check_status = 17;
            }

            // Lead Completed KPI Coor
        } elseif (auth()->user()->m_flag == 2) {
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.completed_by_lead',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_assessment_lead' => $request->k_assessment_lead,
                        'name_spec' => $name_spec,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_coor' => $name_coor,
                        'name_submitter' => $name_submitter,
                        'crement' => $crement,
                    ]
                );
            }

            // Manager receive notif email dari Lead
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_completed_coor2',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_assessment_lead' => $request->k_assessment_lead,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.completed_by_lead_notif_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_assessment_lead' => $request->k_assessment_lead,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'k_created_by' => $request->k_created_by,
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.completed_by_lead',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_assessment_lead' => $request->k_assessment_lead,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'email_manager' => $email_manager,
                    ]
                );
            }
            if ($email_manager != null) {
                $check_status = 17;
            }
            // Log Completed by Lead
            // $log_detail = DB::table('d_log')->insert([
            //     'dl_name' => 'Completed KPI by ' . session('name') . ' AS ' . session('unit'),
            //     'dl_desc' => $request->k_assessment_lead,
            //     'dl_menu' => 31,
            //     'dl_ref_id' => $request->hidden_id_header,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);
            // Manager Completed KPI Coor
        } elseif (auth()->user()->m_flag == 1) {
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_completed_thanks_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_assessment_manager' => $request->k_assessment_manager,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_submitter' => $name_submitter,
                        'k_finalresult_text' => $request->k_finalresult_text,
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.completed_by_manager_spec',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_assessment_manager' => $request->k_assessment_manager,
                        'email_manager' => $email_lead,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_submitter' => $name_submitter,
                        'k_created_by' => $request->k_created_by,
                        'k_finalresult_text' => $request->k_finalresult_text,
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.completed_by_manager_notif_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'k_assessment_manager' => $request->k_assessment_manager,
                        'email_coor' => $email_coor,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'name_submitter' => $name_submitter,
                        'k_created_by' => $request->k_created_by,
                        'k_finalresult_text' => $request->k_finalresult_text,
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.completed_by_manager',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_assessment_manager' => $request->k_assessment_manager,
                        'email_spec' => $email_spec,
                        'name_coor' => $name_coor,
                        'name_submitter' => $name_submitter,
                        'name_manager' => $name_manager,
                        'k_finalresult_text' => $request->k_finalresult_text,
                        'email_manager' => $email_manager,
                    ]
                );
            }
            if ($email_manager != null) {
                $check_status = 3;
            }

            // $log_detail = DB::table('d_log')->insert([
            //     'dl_name' => 'Completed KPI by ' . session('name') . ' AS ' . session('unit'),
            //     'dl_desc' => $request->k_assessment_manager,
            //     'dl_menu' => 31,
            //     'dl_ref_id' => $request->hidden_id_header,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);
        }

        if (auth()->user()->m_flag == 3) {
            for ($i = 0; $i < count($request->id_old); $i++) {
                $data2 = DB::table('a_kpid')
                    ->where('kd_id', $request->id_old[$i])
                    ->update([
                        'kd_result_id' => $request->kd_result_id[$i],
                        'kd_updated_at' => date('Y-m-d H:i'),
                        'kd_value' => $request->add_value[$i],
                        'flag_due_date_checked' => $request->flag_due_date_checked[$i],
                        'flag_ts_checked' => $request->flag_ts_checked[$i],
                    ]);
            }

            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_assessment' => $request->k_assessment,
                    'k_assessment_lead' => $request->k_assessment_lead,
                    'k_assessment_manager' => $request->k_assessment_manager,
                    'k_supplement' => $request->k_supplement,
                    'k_supplement_lead' => $request->k_supplement_lead, // @ospt
                    'k_supplement_manager' => $request->k_supplement_manager, // @ospt
                    'k_justification' => $request->k_justification,
                    'k_coordinatorfinalresult' => $request->fr_coor, //1
                    'k_managerfinalresult' => $request->fr_manager,
                    'k_status_id' => $check_status,
                    'k_completed_coor' => date('Y-m-d H:i'), //1
                    'k_updated_at' => date('Y-m-d H:i'),
                    'k_finalresult' => $request->k_finalresult,
                    'k_finalresult_text' => $request->k_finalresult_text,
                ]);
        } elseif (auth()->user()->m_flag == 2) {
            for ($i = 0; $i < count($request->id_old); $i++) {
                $data2 = DB::table('a_kpid')
                    ->where('kd_id', $request->id_old[$i])
                    ->update([
                        'kd_result_id' => $request->kd_result_id[$i],
                        'kd_updated_at' => date('Y-m-d H:i'),
                        'kd_value' => $request->add_value[$i],
                        'kd_comment' => $request->add_comment[$i],
                        'flag_due_date_checked' => $request->flag_due_date_checked[$i],
                        'flag_ts_checked' => $request->flag_ts_checked[$i],
                    ]);
            }

            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_assessment' => $request->k_assessment,
                    'k_assessment_lead' => $request->k_assessment_lead,
                    'k_assessment_manager' => $request->k_assessment_manager,
                    'k_supplement' => $request->k_supplement,
                    'k_supplement_lead' => $request->k_supplement_lead, // @ospt
                    'k_supplement_manager' => $request->k_supplement_manager, // @ospt
                    'k_justification_lead' => $request->k_justification_lead,
                    'k_leaderfinalresult' => $request->fr_lead,
                    'k_status_id' => $check_status,
                    'k_completed_lead' => date('Y-m-d H:i'), //1
                    'k_finalresult' => $request->k_finalresult,
                    'k_finalresult_text' => $request->k_finalresult_text,
                ]);
        } elseif (auth()->user()->m_flag == 1) {
            for ($i = 0; $i < count($request->id_old); $i++) {
                $data2 = DB::table('a_kpid')
                    ->where('kd_id', $request->id_old[$i])
                    ->update([
                        'kd_result_id' => $request->kd_result_id[$i],
                        'kd_updated_at' => date('Y-m-d H:i'),
                        'kd_value' => $request->add_value[$i],
                        'kd_comment' => $request->add_comment[$i],
                        'flag_due_date_checked' => $request->flag_due_date_checked[$i],
                        'flag_ts_checked' => $request->flag_ts_checked[$i],
                    ]);
            }

            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_assessment' => $request->k_assessment,
                    'k_assessment_lead' => $request->k_assessment_lead,
                    'k_assessment_manager' => $request->k_assessment_manager,
                    'k_supplement' => $request->k_supplement,
                    'k_supplement_lead' => $request->k_supplement_lead, // @ospt
                    'k_supplement_manager' => $request->k_supplement_manager, // @ospt
                    'k_justification' => $request->k_justification,
                    'k_managerfinalresult' => $request->fr_manager,
                    'k_status_id' => $check_status,
                    'k_completed_manager' => date('Y-m-d H:i'), //1
                    'k_updated_at' => date('Y-m-d H:i'),
                    'k_finalresult' => $request->k_finalresult,
                    'k_finalresult_text' => $request->k_finalresult_text,
                ]);

            // $log_detail = DB::table('d_log')->insert([
            //                 'dl_name'=>'Completed KPI by '.session('name').' AS '.session('unit'),
            //                 'dl_desc'=> $request->k_selfassessment,
            //                 // 'dl_filename' => $filename,
            //                 'dl_menu'=> 31,
            //                 'dl_ref_id'=> $request->hidden_id_header,
            //                 // 'dl_ref_id_detail'=> $request->id_old[$i],
            //                 'dl_created_at'=>date('Y-m-d H:i'),
            //                 'dl_created_by'=>auth()->user()->m_id,
            //             ]);
        }

        return response()->json(['status' => 'sukses']);
    }

    public function save(Request $request)
    {
        //MANAGER
        $check = DB::table('a_kpi as ak')
            ->select('mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead', 'mm_i.m_flag as flag_manager', 'mm.m_flag as flag_coor', 'mm_ii.m_flag as flag_lead', 'mm_iii.m_flag as flag_spec', 'ak.k_id as crement')
            ->leftjoin('d_mem as mm', 'ak.k_coordinator_id', 'mm.m_id')
            ->leftjoin('d_mem as mm_i', 'ak.k_manager_id', 'mm_i.m_id')
            ->leftjoin('d_mem as mm_ii', 'ak.k_leader_id', 'mm_ii.m_id')
            ->leftjoin('d_mem as mm_iii', 'ak.k_specialist_id', 'mm_iii.m_id')
            ->where('k_id', $request->hidden_id_header)
            ->get();

        $email_manager = $check[0]->email_manager;
        $email_lead = $check[0]->email_lead;
        $email_coor = $check[0]->email_coor;
        $email_spec = $check[0]->email_spec;
        $name_manager = $check[0]->name_manager;
        $name_lead = $check[0]->name_lead;
        $name_coor = $check[0]->name_coor;
        $name_spec = $check[0]->name_spec;
        $crement = $check[0]->crement;

        if ($request->k_status_id == 13 || $request->k_status_id == 16 || $request->k_status_id == 1) {
            $status_log = 'Approved KPI BY ' . session('name') . ' AS ' . session('role');
        } else {
            $status_log = 'Rejected KPI BY ' . session('name') . ' AS ' . session('role');
        }

        if (auth()->user()->m_flag == 1) {
            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $request->k_status_id,
                    'k_updated_at' => date('Y-m-d H:i'),
                    'k_approval_manager' => date('Y-m-d H:i'), // Bondan
                    'k_justification_manager' => $request->k_justification_manager,
                ]);

            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_manager,
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 32,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            // Notifikasi Email Approve dari Manager

            $k_justification_manager = $request->k_justification_manager;
            // APROVED KE SPEC
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_approve_manager',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //APROVED COOR
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_notif_lead_approve_manager',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'k_created_by' => $request->k_created_by,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //APROVED LEAD
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_notif_approved_spec_manager',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'k_created_by' => $request->k_created_by,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //APROVED MANAGER
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_notif_approved_spec',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'k_created_by' => $request->k_created_by,
                        'name_manager' => $name_manager,
                    ]
                );
            }
        } elseif (auth()->user()->m_flag == 2) { //LEAD
            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $request->k_status_id,
                    'k_updated_at' => date('Y-m-d H:i'),
                    'k_approval_lead' => date('Y-m-d H:i'), // Bondan
                    'k_justification_lead' => $request->k_justification_lead,
                ]);

            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_lead,
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 32,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            $k_justification_lead = $request->k_justification_lead;
            $k_collab = $request->k_collab;

            // EMAIL KE DIRI SENDIRI
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_approved_lead',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_lead' => $name_lead,
                    ]
                );
            }

            // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_notif_lead_approve_spec',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        // 'k_created_by'              => $k_created_by
                        'k_created_by' => $request->k_created_by,
                        'name_lead' => $name_lead,
                    ]
                );
            }
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_notif_approved_spec',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                    ]
                );
            }
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_notif_lead_approved_kpi_spec',
                    'REVIEW: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
        } elseif (auth()->user()->m_flag == 3) { //COOR
            $check_status = $request->k_status_id;
            //email has been approve from coor
            // if ($request->k_status_id != 2) {
            $k_justification_coor = $request->k_justification_coor;
            $k_collab = $request->k_collab;
            // EMAIL KE DIRI SENDIRI
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_approve_coor',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_coor' => $k_justification_coor,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                    ]
                );
            }

            // KPI Specialist Approved by Coor
            // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_notif_approved_spec',
                    'APPROVED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_coor' => $k_justification_coor,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                    ]
                );
            }
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_notif_coor_approved_kpi_spec',
                    'REVIEW: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_coor' => $k_justification_coor,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                    ]
                );
            }

            if ($email_manager != null && $email_lead == null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_notif_2',
                    'REVIEW: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_coor' => $k_justification_coor,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'email_manager' => $email_manager,
                    ]
                );
            }

            if ($email_lead != null && $email_manager == null) {
                $check_status = 13;
            } elseif ($email_lead == null && $email_manager != null) {
                $check_status = 16;
            }

            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_coor,
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 32,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $check_status,
                    'k_updated_at' => date('Y-m-d H:i'),
                    'k_approval_coor' => date('Y-m-d H:i'),
                    'k_justification_coor' => $request->k_justification_coor,
                ]);
        }

        return response()->json(['status' => 'sukses']);
    }

    public function reject(Request $request)
    {
        $status_log = 'Rejected KPI BY ' . session('name') . ' AS ' . session('role');

        $check = DB::table('a_kpi')
            ->select('a_kpi.*', 'k_created_by', 'd_mem_i.m_name as name_manager', 'd_mem_i.m_email as email_manager', 'd_mem_ii.m_name as name_lead', 'd_mem_ii.m_email as email_lead', 'd_mem_iii.m_name as name_coor', 'd_mem_iii.m_email as email_coor', 'd_mem_iiii.m_name as name_spec', 'd_mem_iiii.m_email as email_spec', 'd_mem_iiiii.m_name as submitter')
            ->leftjoin('d_mem as d_mem_i', 'a_kpi.k_manager_id', '=', 'd_mem_i.m_id')
            ->leftjoin('d_mem as d_mem_ii', 'a_kpi.k_leader_id', '=', 'd_mem_ii.m_id')
            ->leftjoin('d_mem as d_mem_iii', 'a_kpi.k_coordinator_id', '=', 'd_mem_iii.m_id')
            ->leftjoin('d_mem as d_mem_iiii', 'a_kpi.k_specialist_id', '=', 'd_mem_iiii.m_id')
            ->leftjoin('d_mem as d_mem_iiiii', 'a_kpi.k_created_by', '=', 'd_mem_iiiii.m_id')
            ->where('k_id', $request->hidden_id_header)
            ->get();

        $email_manager = $check[0]->email_manager;
        $email_lead = $check[0]->email_lead;
        $email_coor = $check[0]->email_coor;
        $email_spec = $check[0]->email_spec;
        $name_manager = $check[0]->name_manager;
        $name_lead = $check[0]->name_lead;
        $name_coor = $check[0]->name_coor;
        $name_spec = $check[0]->name_spec;
        $crement = $check[0]->k_id;
        $submitter = $check[0]->submitter;

        if (auth()->user()->m_flag == 1) {
            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $request->k_status_id,
                    'k_reject_manager' => date('Y-m-d H:i'), //Bondan
                    'k_justification_manager' => $request->k_justification_manager,
                ]);
            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_manager,
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 11,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            $k_justification_manager = $request->k_justification_manager;
            // Notifikasi Email Reject dari Manager
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_rejected_manager',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //REJECTED DARI LEAD KE COOR
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_notif_lead_rejected_manager',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'k_created_by' => $request->k_created_by,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //REJECTED LEAD
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_notif_rejected_spec_manager',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'k_created_by' => $request->k_created_by,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
            //REJECTED MANAGER
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_notif_rejected_spec',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_manager' => $k_justification_manager,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'k_created_by' => $request->k_created_by,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                    ]
                );
            }
        }

        if (auth()->user()->m_flag == 2) {
            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $request->k_status_id,
                    'k_reject_lead' => date('Y-m-d H:i'), // Bondan
                    'k_justification_lead' => $request->k_justification_lead,
                ]);
            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_lead, // Bondan
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 11,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            $k_justification_lead = $request->k_justification_lead;
            // REJECTED KE SPEC
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_rejected_lead',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                    ]
                );
            }
            //REJECTED DARI LEAD KE COOR
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_notif_lead_reject_spec',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'k_created_by' => $request->k_created_by,
                        'name_manager' => $name_manager,
                        'name_coor' => $name_coor,
                    ]
                );
            }
            //REJECTED LEAD
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_notif_rejected_spec',
                    'REJECTED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_justification_lead' => $k_justification_lead,
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'name_coor' => $name_coor,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'crement' => $crement,
                    ]
                );
            }
        }
        if (auth()->user()->m_flag == 3) {
            $data1 = DB::table('a_kpi')
                ->where('k_id', $request->hidden_id_header)
                ->update([
                    'k_status_id' => $request->k_status_id,
                    'k_reject_coor' => date('Y-m-d H:i'), // Bondan
                    'k_justification_coor' => $request->k_justification_coor,
                ]);
            $log = DB::table('d_log')->insert([
                'dl_name' => '"' . $status_log . '"',
                'dl_desc' => $request->k_justification_coor,
                'dl_ref_id' => $request->hidden_id_header,
                'dl_menu' => 11,
                'dl_created_at' => date('Y-m-d H:i'),
                'dl_created_by' => auth()->user()->m_id,
                'dl_site' => session('site'),
            ]);

            $k_justification_coor = $request->k_justification_coor;

            // Specialist receive email reject dari Coor
            SendEmail::dispatch(
                $email_spec,
                'mail.specialist.spec_rejected_coor',
                'REJECTED: Performance Appraisal',
                [
                    'pesan' => 'KPI INFORMATION',
                    'k_justification_coor' => $k_justification_coor,
                    'k_label' => $request->k_label,
                    'goal' => $request->k_goal,
                    'k_targetdate' => $request->k_targetdate,
                    'name_coor' => $name_coor,
                    'k_collab_assets' => $request->k_collab_assets,
                    'k_collab_helpdesk' => $request->k_collab_helpdesk,
                    'k_collab_support' => $request->k_collab_support,
                    'kd_duedate' => $request->kd_duedate[0],
                    'name_spec' => $name_spec,
                    'crement' => $crement,
                ]
            );

            //REJECTED KPI Specialist dari Coor
            SendEmail::dispatch(
                $email_coor,
                'mail.coordinator.coor_notif_rejected_spec',
                'REJECTED: Performance Appraisal',
                [
                    'pesan' => 'KPI INFORMATION',
                    'k_justification_coor' => $k_justification_coor,
                    'k_label' => $request->k_label,
                    'goal' => $request->k_goal,
                    'k_targetdate' => $request->k_targetdate,
                    'name_coor' => $name_coor,
                    'k_collab_assets' => $request->k_collab_assets,
                    'k_collab_helpdesk' => $request->k_collab_helpdesk,
                    'k_collab_support' => $request->k_collab_support,
                    'kd_duedate' => $request->kd_duedate[0],
                    'name_spec' => $name_spec,
                    'crement' => $crement,
                ]
            );
        }
        if ($data1 == true) {
            return response()->json(['status' => 'sukses']);
        }
    }
}
