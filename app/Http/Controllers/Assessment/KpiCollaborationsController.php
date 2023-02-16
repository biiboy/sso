<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class KpiCollaborationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = Periode::all();
        return view('assessment.kpi_collaboration.index', compact('year'));
    }

    public function kpi_collaboration_datatable(Request $req)
    {
        if (auth()->user()->m_flag == 1) {
            $data = DB::table('a_kpi')
                ->leftjoin('d_mem', 'm_id', 'k_created_by')
                ->leftjoin('d_unit', 'u_id', 'k_unit')
                ->where('k_status_id', 1)
                ->where('k_collaboration', null)
                ->where(function ($query) {
                    $query
                        ->where('k_collab_helpdesk', '=', 'ya')
                        ->orWhere('k_collab_assets', '=', 'ya')
                        ->orWhere('k_collab_support', '=', 'ya');
                })
                ->get();
        } else {
            if (session('unit_flag') == 2) {
                $data = DB::table('a_kpi')
                    ->leftjoin('d_mem', 'm_id', 'k_created_by')
                    ->leftjoin('d_unit', 'u_id', 'k_unit')
                    // ->where('k_unit',session('unit_flag'))
                    ->where('k_collaboration', null)
                    ->where('k_status_id', 1)
                    ->where(function ($query) {
                        $query->where('k_collab_support', '=', 'ya');
                    })
                    ->where(function ($query) use ($req) {
                        if ($req->tahun == '') {
                        } else {
                            $query->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->get();
            } elseif (session('unit_flag') == 3) {
                $data = DB::table('a_kpi')
                    ->leftjoin('d_mem', 'm_id', 'k_created_by')
                    ->leftjoin('d_unit', 'u_id', 'k_unit')
                    // ->where('k_unit',session('unit_flag'))
                    ->where('k_collaboration', null)
                    ->where('k_status_id', 1)
                    ->where(function ($query) {
                        $query->where('k_collab_assets', '=', 'ya');
                    })
                    ->where(function ($query) use ($req) {
                        if ($req->tahun == '') {
                        } else {
                            $query->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->get();
            } elseif (session('unit_flag') == 1) {
                $data = DB::table('a_kpi')
                    ->leftjoin('d_mem', 'm_id', 'k_created_by')
                    ->leftjoin('d_unit', 'u_id', 'k_unit')
                    // ->where('k_unit',session('unit_flag'))
                    ->where('k_collaboration', null)
                    ->where('k_status_id', 1)
                    ->where(function ($query) {
                        $query->where('k_collab_helpdesk', '=', 'ya');
                    })
                    ->where(function ($query) use ($req) {
                        if ($req->tahun == '') {
                        } else {
                            $query->whereYear('k_targetdate', $req->tahun);
                        }
                    })
                    ->get();
            }
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
            ->addColumn('status', function ($row) {
                if ($row->k_status_id == 1) {
                    return 'Active';
                } elseif ($row->k_status_id == 2) {
                    return 'Draft'; //spec
                } elseif ($row->k_status_id == 3) {
                    return 'Final';

                    if ($row->k_finalresult_text == 'Good') {
                        return '<span class="label label-rounded label-info">Good</span>';
                    } elseif ($row->k_finalresult_text == 'NI') {
                        return '<span class="label label-rounded label-warning">Need
                                        Improvement</span>';
                    } elseif ($row->k_finalresult_text == 'Outstanding') {
                        return '<span class="label label-rounded label-success">Outstanding</span>';
                    } elseif ($row->k_finalresult_text == 'Unacceptable') {
                        return '<span class="label label-rounded label-danger">Unacceptable</span>';
                    } elseif ($row->k_finalresult_text == 'N/A') {
                        return '<span class="label label-rounded label-info"
                                        style="background-color: #999 !important">N/A</span>';
                    }
                } elseif ($row->k_status_id == 4) {
                    return 'Draft'; //coor
                } elseif ($row->k_status_id == 5) {
                    return 'Draft'; //lead
                } elseif ($row->k_status_id == 6) {
                    return 'Draft'; //manager
                    //approve from coor
                } elseif ($row->k_status_id == 10) {
                    if (auth()->user()->m_flag == 3) {
                        return 'Waiting for Approval ' . session('coor');
                    } else {
                        return 'Waiting for Approval ' . session('coor');
                    }
                } elseif ($row->k_status_id == 11) {
                    if (auth()->user()->m_flag == 3) {
                        return 'In Review by' . session('coor');
                    } else {
                        return 'In Review by' . session('coor');
                    }
                } elseif ($row->k_status_id == 12) {
                    return 'Rejected' . session('coor');
                    // PPROVE FROM LEAD
                } elseif ($row->k_status_id == 13) {
                    if (auth()->user()->m_flag == 2) {
                        return 'Waiting for Approval' . session('lead');
                    } else {
                        return 'Waiting for Approval' . session('lead');
                    }
                } elseif ($row->k_status_id == 14) {
                    if (auth()->user()->m_flag == 2) {
                        return 'In Review by' . session('lead');
                    } else {
                        return 'In Review by' . session('lead');
                    }
                } elseif ($row->k_status_id == 15) {
                    return 'Rejected' . session('lead');
                    // APPROVE FROM MANAGER
                } elseif ($row->k_status_id == 16) {
                    if (auth()->user()->m_flag == 1) {
                        return 'Waiting for Approval' . session('manager');
                    } else {
                        return 'Waiting for Approval' . session('manager');
                    }
                } elseif ($row->k_status_id == 17) {
                    if (auth()->user()->m_flag == 1) {
                        return 'In Review by' . session('manager');
                    } else {
                        return 'In Review by' . session('manager');
                    }
                } elseif ($row->k_status_id == 18) {
                    return 'Rejected' . session('manager');
                }
            })
            ->addColumn('action', function ($row) {
                // $actionBtn ='<div class="col"><a class="btn waves-effect waves-light btn-sm btn-primary tombol"href="' .route('assessment_kpi_active_collab', ['id' => $row->k_id]) .'"Style="width: 130px;"><i class="fas fa-eye"></i> View</a></div><div class="col"><button type="button" class="btn waves-effect waves-light btn-sm btn-success resubmit" value="' .$row->k_id .'" Style="width: 130px;"><iclass="fas fa-check"></iclass=> Add To My KPI</button></div>';$actionBtn = '<a class="btn py-1 btn-sm btn-primary mb-1" href="#" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '<br>' . '<a class="btn py-1 btn-sm btn-warning mb-1" href="#" style="width: 100px;"><i class="ti-pencil me-1"></i> Add to my kpi</a>';
                $actionBtn = '<div class="col"><a class="btn waves-effect waves-light btn-sm btn-primary tombol mb-2" href="' . route('assessment_kpi_active_collab', ['id' => $row->k_id]) . '"Style="width: 130px;"><i class="ti-eye me-1"></i> View</a></div><div class="col"><button type="button" class="btn waves-effect waves-light btn-sm btn-success resubmit"value="' . $row->k_id . '" Style="width: 130px;"><i class="ti-pencil me-1"></i> Add To My KPI</button></div>';

                return $actionBtn;
            })

            ->addColumn('collaboration', function ($row) {
                if ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    return '<strong>IT Helpdesk  </strong>';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    return '<strong>IT Asset dan IT Helpdesk </strong>';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    return '<strong>IT Support dan IT Helpdesk </strong>';
                } elseif ($row->k_collab_helpdesk == 'ya' && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    return '<strong>All IT Services </strong>';
                }

                // {{-- Collab sama IT ASset --}}
                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == null) {
                    return '<strong>IT Asset  </strong>';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == 'ya' && $row->k_collab_support == 'ya') {
                    return '<strong>IT Asset dan IT Support </strong>';
                } elseif ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == 'ya') {
                    return '<strong>IT Support </strong>';
                }

                if ($row->k_collab_helpdesk == null && $row->k_collab_assets == null && $row->k_collab_support == null) {
                    return '<strong>- </strong>';
                }
            })
            ->addColumn('submited_date', function ($row) {
                return date('d-M-Y', strtotime($row->k_created_at)) . '<br>' . date('H:i A', strtotime($row->k_created_at));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->rawColumns(['action', 'date', 'collaboration', 'submited_date', 'goal'])
            ->make(true);
    }

    public function active_collab($id)
    {
        $menu = DB::table('d_menu')->get();
        $data_edit = DB::table('a_kpi')
            ->leftjoin('d_mem', 'm_id', 'k_created_by')
            ->where('k_id', $id)
            ->first();
        $data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();

        // ddd($data_edit);
        for ($i = 0; $i < count($data); $i++) {
            $check_total_file[$i] = DB::table('a_kpid_file')
                ->where('kpf_ref_iddt', $data[$i]->kd_id)
                ->where('kpf_ref_id', $data_edit->k_id)
                ->count();
        }

        for ($i = 0; $i < count($data); $i++) {
            $check_total_cmnt[$i] = DB::table('a_kpi_comment')
                ->where('kc_ref_id', $data[$i]->kd_id)
                ->count();
        }
        for ($i = 0; $i < 1; $i++) {
            $check_total_header_kra[$i] = DB::table('a_kpi_comment_header')
                ->where('kch_ref_id', $data_edit->k_id)
                ->where('kch_flag', 1)
                ->count();
        }
        // for ($i = 0; $i < count($data_edit); $i++) {
            $check_total_header_goal[$i] = DB::table('a_kpi_comment_header')
                ->where('kch_ref_id', $data_edit->k_id)
                ->where('kch_flag', 2)
                ->count();
        // }
        // for ($i = 0; $i < count($data_edit); $i++) {
            $check_total_header_date[$i] = DB::table('a_kpi_comment_header')
                ->where('kch_ref_id', $data_edit->k_id)
                ->where('kch_flag', 3)
                ->count();
        // }

        $data_kpi = DB::table('a_kpi')
            ->where('k_created_by', session('id'))
            ->get();
        $check_data_total = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->count();
        $check_data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->where('kd_status_id', 'Completed')
            ->count();
        // return [$check_data_total,$check_data];
        if ($check_data_total == $check_data) {
            $status_data = true;
        } else {
            $status_data = false;
        }

        $measure = DB::table('d_measure')->get();

        return view('assessment.kpi_collaboration.active_collab', compact('check_total_cmnt', 'check_total_header_kra', 'check_total_header_goal', 'check_total_header_date', 'status_data', 'data', 'menu', 'data_edit', 'measure', 'check_total_file', 'data_kpi'));
    }

    public function update_file(Request $request)
    {
        $checking = DB::table('a_kpid')
            ->where('kd_id', $request->id)
            ->get();
        if ($request->file('file1') != null) {
            $check = array_values(array_filter($request->file('file1')));
            for ($i = 0; $i < count($request->id_old); $i++) {
                if ($request->add_comment[$i] != null) {
                    $dt = $request->id_old[$i];
                    for ($h = 0; $h < count($check); $h++) {
                        $file = $check[$h];
                        $filename = $checking;
                        Storage::put($filename, file_get_contents($file));
                        $data2 = DB::table('a_kpid')
                            ->where('kd_id', $dt)
                            ->update([
                                'kd_file' => $filename,
                                'kd_comment' => $request->add_comment[$i],
                                'kd_updated_at' => date('Y-m-d H:i'),
                                'kd_upload_date' => date('Y-m-d H:i'),
                            ]);

                        // $log_detail = DB::table('d_log')->insert([
                        //     'dl_name'=>'"INSERT FILE KPI AFTER KPI APPROVAL DETAIL',
                        //     'dl_desc'=> $request->add_comment[$i],
                        //     'dl_filename' => $filename,
                        //     'dl_menu'=> 11,
                        //     'dl_ref_id'=> $request->hidden_id_header,
                        //     'dl_ref_id_detail'=> $request->id_old[$i],
                        //     'dl_created_at'=>date('Y-m-d H:i'),
                        //     'dl_created_by'=>auth()->user()->m_id,
                        // ]);
                    }
                }
            }
        }
        if ($checking == true) {
            return response()->json(['status' => 'sukses']);
        } else {
            return response()->json(['status' => 'gagal']);
        }
    }

    public function save_after_approve(Request $request)
    {
        $data1 = DB::table('a_kpi')
            ->where('k_id', $request->hidden_id_header)
            ->update([
                'k_selfassessment' => $request->assessment_self,
            ]);
        if ($request->file('file1') != null) {
            $check = array_values(array_filter($request->file('file1')));
            for ($i = 0; $i < count($request->id_old); $i++) {
                if ($request->add_comment[$i] != null) {
                    $dt = $request->id_old[$i];
                    for ($h = 0; $h < count($check); $h++) {
                        $file = $check[$h];
                        // count($file);
                        $filename = 'file/' . 'Proof_Document_' . auth()->user()->m_name . '_' . $request->hidden_id_header . '_' . $dt . '.pdf';

                        Storage::put($filename, file_get_contents($file));

                        $data2 = DB::table('a_kpid')
                            ->where('kd_id', $dt)
                            ->update([
                                'kd_file' => $filename,
                                'kd_comment' => $request->add_comment[$i],
                                'kd_updated_at' => date('Y-m-d H:i'),
                                'kd_upload_date' => date('Y-m-d H:i'),
                            ]);

                        $log_detail = DB::table('d_log')->insert([
                            'dl_name' => '"INSERT FILE KPI AFTER KPI APPROVAL DETAIL',
                            'dl_desc' => $request->add_comment[$i],
                            'dl_filename' => $filename,
                            'dl_menu' => 11,
                            'dl_ref_id' => $request->hidden_id_header,
                            'dl_ref_id_detail' => $request->id_old[$i],
                            'dl_created_at' => date('Y-m-d H:i'),
                            'dl_created_by' => auth()->user()->m_id,
                        ]);
                    }
                }
            }
        }

        $log = DB::table('d_log')->insert([
            'dl_name' => '"INSERT FILE KPI AFTER KPI APPROVAL',
            'dl_desc' => $request->assessment_self,
            'dl_ref_id' => $request->hidden_id_header,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i'),
            'dl_created_by' => auth()->user()->m_id,
            'dl_site' => session('site'),
        ]);

        return response()->json(['status' => 'sukses']);
    }

    public function checking_file(Request $request)
    {
        $check_file = DB::table('a_kpid_file')
            ->where('kpf_ref_iddt', $request->id)
            ->count();
        return response()->json(['status' => 'sukses', 'total_data' => $check_file]);
    }

    public function update_status_to_complete(Request $request)
    {
        // dd($request->all());
        // return 'a';

        ini_set('max_execution_time', 180);
        // return count($request->file1);
        ini_set('memory_limit', '-1');

        $filename = null;

        if ($request->k_status == 'Completed') {
            $status_ts = 'Completed';
        } elseif ($request->k_status == 'In Progress') {
            $status_ts = 'In Progress';
        } else {
            $status_ts = 'N/A';
        }

        if ($request->k_status == 'Completed' || $request->k_status == 'In Progress') {
            $data = DB::table('a_kpid')
                ->where('kd_id', $request->kd_id)
                ->update([
                    'kd_completed_date' => date('Y-m-d H:i'),
                    'kd_status_id' => $request->k_status,
                ]);

            // $data1 = DB::table('a_kpi')->where('k_id',$request->hidden_id_header)->update([
            //     'k_selfassessment'=>$request->assessment_self,
            //     'k_supplement'=>$request->k_supplement,
            // ]);

            // $data2 = DB::table('a_kpid')
            //             ->where('kd_id',$request->kd_id)
            //             ->update([
            //                 'kd_comment' => $request->add_comment,
            //             ]);
            // return $request->add_comment;

            // $check_files = DB::table('a_kpid_file')
            //                     ->where('kpf_ref_id',$request->hidden_id_header)
            //                     ->where('kpf_ref_iddt',$request->kd_id)
            //                     ->count();

            // $filename = null;
            // if ($request->file('file1') != null) {
            //     for ($i=0; $i <count($request->file1) ; $i++) {
            //         $check = array_values(array_filter($request->file('file1')));
            //         $file = $check[$i];
            //         $check_files += $i;
            //         $filename = 'file/'.'Proof_Document_'.auth()->user()->m_name.'_'.$request->hidden_id_header.'_'.$check_files.'_'.$request->kd_id.'.pdf';
            //         Storage::put($filename,file_get_contents($file));

            //         $save_file = DB::table('a_kpid_file')->insert([
            //             'kpf_ref_id'=>$request->hidden_id_header,
            //             'kpf_ref_iddt'=>$request->kd_id,
            //             'kpf_file'=>$filename,
            //             'kpf_created_by'=>auth()->user()->m_id,
            //             'kpf_upload_date'=>date('Y-m-d H:i:s'),
            //             'kpf_created_at'=>date('Y-m-d H:i:s'),
            //             'kpf_updated_at'=>date('Y-m-d H:i:s'),
            //         ]);
            //     }
            // }

            // if($request->k_status != 'In Progress'){
            //     $log_detail = DB::table('d_log')->insert([
            //         'dl_name'=>'"INSERT FILE KPI AFTER KPI APPROVAL DETAIL',
            //         'dl_desc'=> $request->add_comment,
            //         'dl_filename' => $filename,
            //         'dl_menu'=> 11,
            //         'dl_ref_id'=> $request->hidden_id_header,
            //         'dl_ref_id_detail'=> $request->kd_id,
            //         'dl_created_at'=>date('Y-m-d H:i'),
            //         'dl_created_by'=>auth()->user()->m_id,
            //     ]);
            // }
        } else {
            // $data2 = DB::table('a_kpid')
            //             ->where('kd_id',$request->kd_id)
            //             ->update([
            //                 'kd_comment' => $request->kd_comment,
            //             ]);
            $data = DB::table('a_kpid')
                ->where('kd_id', $request->kd_id)
                ->update([
                    'kd_completed_date' => date('Y-m-d H:i'),
                    'kd_status_id' => $request->k_status,
                ]);
        }

        //Bondan
        $data1 = DB::table('a_kpi')
            ->where('k_id', $request->k_id)
            ->update([
                'k_updated_at' => date('Y-m-d H:i:s'),
            ]);

        $log_detail = DB::table('d_log')->insert([
            'dl_name' => 'Change Status to ' . $status_ts . ' BY ' . session('name'),
            'dl_desc' => $request->kd_comment,
            'dl_filename' => $filename,
            'dl_menu' => 11,
            'dl_ref_id' => $request->hidden_id_header,
            'dl_ref_id_detail' => $request->kd_id,
            'dl_created_at' => date('Y-m-d H:i'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return response()->json(['ref' => $request->id, 'date' => date('Y-m-d H:i'), 'created_by' => session('username'), 'comment' => $request->kd_comment, 'status' => 'sukses']);
    }
}
