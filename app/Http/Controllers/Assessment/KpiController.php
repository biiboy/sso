<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KpiController extends Controller
{
    public function active($id)
    {
        $data_edit = DB::table('a_kpi')->where('k_id', $id)->first();
        $data = DB::table('a_kpid')->where('kd_kpi_id', $id)->get();

        for ($i = 0; $i < count($data); $i++) {
            $check_total_file[$i] = DB::table('a_kpid_file')
                ->where('kpf_ref_iddt', $data[$i]->kd_id)
                ->where('kpf_ref_id', $data_edit->k_id)
                ->count();
        }

        $measure = DB::table('d_measure')->get();

        return view('assessment.my_kpi.active', compact('data', 'data_edit', 'measure', 'check_total_file'));
    }

    public function active_lead($id)
    {
        $data_edit = DB::table('a_kpi')
            ->where('k_id', $id)
            ->first();
        $data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            $check_total_file[$i] = DB::table('a_kpid_file')
                ->where('kpf_ref_iddt', $data[$i]->kd_id)
                ->where('kpf_ref_id', $data_edit->k_id)
                ->count();
        }

        $measure = DB::table('d_measure')->get();

        return view('assessment.my_kpi.statusactive', compact('data', 'data_edit', 'measure', 'check_total_file'));
    }

    public function assessment_kpi_complete_on_show(Request $request)
    {
        $check = DB::table('d_mem')
            ->select('mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead')
            ->leftjoin('d_mem as mm', 'd_mem.m_coordinator', 'mm.m_id')
            ->leftjoin('d_mem as mm_i', 'd_mem.m_manager', 'mm_i.m_id')
            ->leftjoin('d_mem as mm_ii', 'd_mem.m_lead', 'mm_ii.m_id')
            ->leftjoin('d_mem as mm_iii', 'd_mem.m_specialist', 'mm_iii.m_id')
            ->where('d_mem.m_id', auth()->user()->m_id)
            ->get();

        $email_manager = $check[0]->email_manager;
        $email_lead = $check[0]->email_lead;
        $email_coor = $check[0]->email_coor;
        $email_spec = $check[0]->email_spec;
        $name_manager = $check[0]->name_manager;
        $name_lead = $check[0]->name_lead;
        $name_coor = $check[0]->name_coor;
        $name_spec = $check[0]->name_spec;

        $check_dua = DB::table('a_kpi as ak')
            ->select('mm_iii.m_flag as flag', 'mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead', 'ak.k_id as crement')
            ->leftjoin('d_mem as mm', 'ak.k_coordinator_id', 'mm.m_id')
            ->leftjoin('d_mem as mm_i', 'ak.k_manager_id', 'mm_i.m_id')
            ->leftjoin('d_mem as mm_ii', 'ak.k_leader_id', 'mm_ii.m_id')
            ->leftjoin('d_mem as mm_iii', 'ak.k_created_by', 'mm_iii.m_id')
            ->where('ak.k_id', $request->hidden_id_header)
            ->get();

        $crement = $check_dua[0]->crement;

        if (auth()->user()->m_flag == 4) {
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.coor_completed',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_selfassessment' => $request->k_selfassessment,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'name_spec' => $name_spec,
                        'kd_duedate' => $request->kd_duedate[0],
                        'crement' => $crement,
                    ]
                );
            }
            if ($email_coor == null && $email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_completed_coor_2',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_selfassessment' => $request->k_selfassessment,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_spec' => $name_spec,
                        'name_lead' => $name_lead,
                    ]
                );
            }
            if ($email_spec != null) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_completed',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_spec' => $name_spec,
                        'k_selfassessment' => $request->k_selfassessment,
                        'name_spec' => $name_spec,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'kd_duedate' => $request->kd_duedate[0],
                        'crement' => $crement,
                    ]
                );
            }

            // completed by spec
            if ($email_coor != null) {
                $check_status = 11;
            } elseif ($email_coor == null && $email_lead != null) {
                $check_status = 14;
            } elseif ($email_coor == null && $email_lead == null && $email_manager != null) {
                $check_status = 17;
            }
        } elseif (auth()->user()->m_flag == 3) {
            if ($email_coor != null) {
                SendEmail::dispatch(
                    $email_coor,
                    'mail.coordinator.completed_by_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'k_selfassessment' => $request->k_selfassessment,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                    ]
                );
            }

            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_completed_coor',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_selfassessment' => $request->k_selfassessment,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                    ]
                );
            }

            //completed by coor
            if ($email_lead != null) {
                $check_status = 14;
            } elseif ($email_lead == null && $email_manager != null) {
                $check_status = 17;
            }
        } elseif (auth()->user()->m_flag == 2) {
            if ($email_lead != null) {
                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_completed',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_selfassessment' => $request->k_selfassessment,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'kd_duedate' => $request->kd_duedate[0],
                        'name_coor' => $name_coor,
                    ]
                );
            }
            if ($email_manager != null) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_completed_lead',
                    'COMPLETED: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_lead' => $name_lead,
                        'k_selfassessment' => $request->k_selfassessment,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'name_coor' => $name_coor,
                        'name_manager' => $name_manager,
                        'k_created_by' => $request->k_created_by,
                        'kd_duedate' => $request->kd_duedate[0],
                        'email_manager' => $email_manager,
                    ]
                );
            }

            // completed by manager
            if ($email_manager != null) {
                $check_status = 17;
            }
        }

        $checking = DB::table('a_kpi')
            ->where('k_id', $request->hidden_id_header)
            ->update([
                'k_status_id' => $check_status,
                'k_selfassessment' => $request->k_selfassessment,
                'k_completed_spec' => date('Y-m-d H:i:s'),
            ]);

        // $log_detail = DB::table('d_log')->insert([
        //     'dl_name' => 'Completed KPI by ' . session('name') . ' AS ' . session::get('unit'),
        //     'dl_desc' => $request->k_selfassessment,
        //     // 'dl_filename' => $filename,
        //     'dl_menu' => 31,
        //     'dl_ref_id' => $request->hidden_id_header,
        //     // 'dl_ref_id_detail'=> $request->id_old[$i],
        //     'dl_created_at' => date('Y-m-d H:i'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        if ($checking == true) {
            return response()->json(['status' => 'sukses']);
        } else {
            return response()->json(['status' => 'gagal']);
        }
    }

    public function create()
    {
        $measure = DB::table('d_measure')->get();
        return view('assessment.my_kpi.create', compact('measure'));
    }

    public function datatable_assessment_kpi(Request $req)
    {
        $data = DB::table('a_kpi')
            ->where('k_created_by', session('id'))
            ->where(function ($query) use ($req) {
                if ($req->tahun) {
                    $query->whereYear('k_targetdate', $req->tahun);
                }
            })
            ->get();

        $data2 = [];
        for ($i = 0; $i < count($data); $i++) {
            $data2[$i] = DB::table('a_kpid')
                ->where(function ($query) use ($req) {
                    if ($req->tahun) {
                        $query->whereYear('kd_duedate', $req->tahun);
                    }
                })
                ->where('kd_kpi_id', $data[$i]->k_id)
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
            ->addColumn('submittedDate', function ($row) {
                return date('d-M-Y H:i A', strtotime($row->k_created_at));
            })
            ->addColumn('goal', function ($row) {
                return $row->k_goal;
            })
            ->addColumn('collab', function ($row) {
                if ($row->k_collab_helpdesk == 'ya') {
                    if ($row->k_collab_assets == 'ya') {
                        if ($row->k_collab_support == 'ya') {
                            $collab = 'All IT Services';
                        } else {
                            $collab = 'IT Asset dan IT Helpdesk';
                        }
                    } else {
                        if ($row->k_collab_support == 'ya') {
                            $collab = 'IT Support dan IT Helpdesk';
                        } else {
                            $collab = 'IT Helpdesk';
                        }
                    }
                } else {
                    if ($row->k_collab_assets == 'ya') {
                        if ($row->k_collab_support == 'ya') {
                            $collab = 'IT Asset dan IT Support';
                        } else {
                            $collab = 'IT Asset';
                        }
                    } else {
                        if ($row->k_collab_support == 'ya') {
                            $collab = 'IT Support';
                        } else {
                            $collab = '-';
                        }
                    }
                }

                return '<label>' . $collab . '</label>';
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

                        // {{-- Jika DD H-7 ada 2 maka akan menjadi merah yang mendekati --}}
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
                        $status = 'Waiting for Approval ' . session('coor');
                    } else {
                        $status = 'Waiting for Approval ' . session('coor');
                    }
                } elseif ($row->k_status_id == 11) {
                    if (auth()->user()->m_flag == 3) {
                        $status = 'In Review by ' . session('coor');
                    } else {
                        $status = 'In Review by ' . session('coor');
                    }
                } elseif ($row->k_status_id == 12) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('coor') . '</span>';

                    // {{-- APPROVE FROM LEAD --}}
                } elseif ($row->k_status_id == 13) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'Waiting for Approval ' . session('lead');
                    } else {
                        $status = 'Waiting for Approval ' . session('lead');
                    }
                } elseif ($row->k_status_id == 14) {
                    if (auth()->user()->m_flag == 2) {
                        $status = 'In Review by ' . session('lead');
                    } else {
                        $status = 'In Review by ' . session('lead');
                    }
                } elseif ($row->k_status_id == 15) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('lead') . '</span>';
                    // {{-- APPROVE FROM MANAGER --}}
                } elseif ($row->k_status_id == 16) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'Waiting for Approval ' . session('manager');
                    } else {
                        $status = 'Waiting for Approval ' . session('manager');
                    }
                } elseif ($row->k_status_id == 17) {
                    if (auth()->user()->m_flag == 1) {
                        $status = 'In Review by ' . session('manager');
                    } else {
                        $status = 'In Review by ' . session('manager');
                    }
                } elseif ($row->k_status_id == 18) {
                    $status = '<span class="badge badge-pill fw-normal bg-danger-lt badge-outline" >Rejected ' . session('manager') . '</span>';
                }
                return $status;
            })
            ->addColumn('action', function ($element) {
                // {{-- jika status di reject --}}
                if ($element->k_status_id == 12 || $element->k_status_id == 15 || $element->k_status_id == 18) {
                    $action = '<div class="col">' . '<a class="btn py-1 mb-1 btn-sm btn-primary tombol" href="' . route('assessment_all_approval_reject', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>' . '<div class="col" >' . '<a class="btn py-1 mb-1 btn-sm btn-warning tombol" href="' . route('assessment_kpi_edit', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-pencil me-1"></i> Edit</a>' . '</div>' . '<div class="col" >' . '<button type="button" class="btn py-1 btn-sm btn-danger delete tombol" value="' . $element->k_id . '" onclick="deleteData()" style="width: 100px;"><i class="ti-trash me-1"></i> Delete</button>' . '</div>';
                }

                // {{-- jika waiting approval --}}
                if ($element->k_status_id == 10 || $element->k_status_id == 13 || $element->k_status_id == 16) {
                    $action = '<div class="col">' . '<a class="btn py-1 btn-sm btn-primary tombol" href="' . route('assessment_kpi_waiting', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>';
                }

                // {{-- jika active --}}
                if ($element->k_status_id == 1) {
                    $action = '<div class="col">' . '<a class="btn py-1 btn-sm btn-primary tombol" href="' . route('assessment_kpi_active', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>';
                }

                // {{-- jika in review --}}
                if ($element->k_status_id == 11 || $element->k_status_id == 14 || $element->k_status_id == 17) {
                    $action = '<div class="col">' . '<a class="btn py-1 btn-sm btn-primary tombol" href="' . route('assessment_all_approval_appraisal', ['id' => $element->k_id]) . '"  style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>';
                }

                // {{-- status draft --}}
                if ($element->k_status_id == 2 || $element->k_status_id == 4 || $element->k_status_id == 5) {
                    $action = '<div class="col">' . '<a class="btn py-1 mb-1 btn-sm btn-primary tombol" href="' . route('assessment_kpi_draft', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>' . '<div class="col" >' . '<a class="btn py-1 mb-1 btn-sm btn-warning tombol" href="' . route('assessment_kpi_edit', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-pencil me-1"></i> Edit</a>' . '</div>' . '<div class="col" >' . '<button type="button" class="btn py-1 btn-sm btn-danger delete tombol" value="' . $element->k_id . '" onclick="deleteData()" style="width: 100px;"><i class="ti-trash me-1"></i> Delete</button>' . '</div>';
                }

                if ($element->k_status_id == 3) {
                    $action = '<div class="col">' . '<a class="btn py-1 mb-1 btn-sm btn-primary tombol" href="' . route('assessment_all_approval_final', ['id' => $element->k_id]) . '" style="width: 100px;"><i class="ti-eye me-1"></i> View</a>' . '</div>' . '<div class="col">' . '<button type="button" class="btn py-1 btn-sm btn-success resubmit" onclick="resubmitData(' . $element->k_id . ')" value="' . $element->k_id . '" style="width: 100px;"><i class="ti-check me-1"></i> Resubmit</button>' . '</div>';
                }
                return $action;
            })

            ->rawColumns(['action', 'date', 'status', 'goal', 'submittedDate', 'collab'])
            ->make(true);
    }

    public function delete($id)
    {
        $check_data = DB::table('a_kpi')
            ->where('k_id', $id)
            ->get();

        if ($check_data[0]->k_status_id == 2 || $check_data[0]->k_status_id == 4 || $check_data[0]->k_status_id == 5 || $check_data[0]->k_status_id == 6 || $check_data[0]->k_status_id == 12 || $check_data[0]->k_status_id == 15 || $check_data[0]->k_status_id == 18) {
            $check_data_detail = DB::table('a_kpid')
                ->where('kd_kpi_id', $id)
                ->get();

            // $log = DB::table('d_log')->insert([
            //     'dl_name' => 'Delete KPI by ' . session('name'),
            //     'dl_ref_id' => $id,
            //     'dl_menu' => 11,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);

            // for ($i = 0; $i < count($check_data_detail); $i++) {
            //     $log_detail = DB::table('d_log')->insert([
            //         'dl_name' => '"Delete KPI Tactical Step ' . ($i + 1) . ' "',
            //         'dl_ref_id' => $id,
            //         'dl_ref_id_detail' => $check_data_detail[$i]->kd_id,
            //         'dl_menu' => 11,
            //         'dl_created_at' => date('Y-m-d H:i'),
            //         'dl_created_by' => auth()->user()->m_id,
            //     ]);
            // }

            $a = DB::table('a_kpid')
                ->where('kd_kpi_id', $id)
                ->get();
            for ($i = 0; $i < count($a); $i++) {
                $data_detail3 = DB::table('a_kpi_comment')
                    ->where('kc_ref_id', $a[$i]->kd_id)
                    ->delete();
            }
            $b = DB::table('a_kpid')
                ->where('kd_kpi_id', $id)
                ->delete();
            $c = DB::table('a_kpi')
                ->where('k_id', $id)
                ->delete();
            $d = DB::table('a_kpi_comment_header')
                ->where('kch_ref_id', $id)
                ->delete();

            return response()->json(['status' => 'sukses']);
        } else {
            return view('page.privilege_not_access');
        }
    }

    public function deleting_file(Request $request)
    {
        $check_file = DB::table('a_kpid_file')->where('kpf_file', $request->filename)->first();
        // $log_1 = DB::table('d_log')->insert([
        //     'dl_name' => '"Delete Proof Document"',
        //     'dl_desc' => $request->filename,
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);
        $checking_file = DB::table('a_kpid_file')
            ->where('kpf_ref_iddt', $check_file->kpf_ref_iddt)
            ->count();
        $delete_file = DB::table('a_kpid_file')
            ->where('kpf_file', $request->filename)
            ->delete();
        Storage::delete($request->filename);

        return response()->json([
            'status' => 'sukses',
            'filename' => $request->filename,
            'kpf_id' => $check_file->kpf_id,
            'kpf_ref_id' => $check_file->kpf_ref_iddt,
            'total_file' => $checking_file
        ]);
    }

    public function draft($id)
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

        $check_data_total = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->count();
        $check_data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->where('kd_status_id', 'Completed')
            ->count();

        $measure = DB::table('d_measure')->get();

        if ($data_edit->k_created_by == auth()->user()->m_id) {
            return view('assessment.my_kpi.draft', compact('check_total_cmnt', 'check_total_header_kra', 'check_total_header_goal', 'check_total_header_date', 'data', 'data_edit', 'measure'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public function edit($id)
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
        if ($data_edit->k_status_id == 2 || $data_edit->k_status_id == 1 || $data_edit->k_status_id == 12 || $data_edit->k_status_id == 15 || $data_edit->k_status_id == 18 || $data_edit->k_status_id == 4 || $data_edit->k_status_id == 5 || $data_edit->k_status_id == 6) {
            return view('assessment.my_kpi.edit', compact('check_total_header_kra', 'check_total_header_goal', 'check_total_header_date', 'check_total_cmnt', 'data', 'data_edit', 'measure'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    public function index()
    {
        $data = DB::table('a_kpi')
            ->where('k_created_by', session('id'))
            ->whereYear('k_targetdate', date('Y'))
            ->get();

        $total = count($data);
        $year = Periode::all();

        // $log = DB::table('d_log')->insert([
        //     // 'dl_name'=>'"Berada di Halaman My KPI"',
        //     'dl_name' => '' . session('name') . ' akses halaman My KPI ',
        //     'dl_desc' => '-',
        //     'dl_filename' => '-',
        //     'dl_ref_id' => '0',
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i:s'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);
        return view('assessment.my_kpi.index', compact('year', 'total'));
    }

    public function resubmit($id)
    {
        $data_edit = DB::table('a_kpi')
            ->where('k_id', $id)
            ->first();
        $data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->get();
        $measure = DB::table('d_measure')->get();

        return view('assessment.my_kpi.resubmit', compact('data', 'data_edit', 'measure'));
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

    public function show_file(Request $request)
    {
        $check_file = DB::table('a_kpid_file')
            ->where('kpf_ref_iddt', $request->iddetail)
            ->where('kpf_ref_iddt', $request->iddetail)
            ->join('a_kpid', 'kd_id', 'kpf_ref_iddt')
            ->get();

        return response()->json(['status' => 'sukses', 'file' => $check_file]);
    }

    public function store(Request $request)
    {
        try {
            for ($i = 0; $i < count((array) $request->kd_duedate_dt); $i++) {
                if ($request->kd_tacticalstep[$i] == null) {
                    return response()->json(['status' => 'Validasi', 'key' => $i]);
                }
                if ($request->kd_duedate[$i] == null) {
                    return response()->json(['status' => 'Validasi_date', 'key' => $i]);
                }
            }

            $mail = DB::Table('d_mem')
                ->select('mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead')
                ->leftjoin('d_mem as mm', 'd_mem.m_coordinator', 'mm.m_id')
                ->leftjoin('d_mem as mm_i', 'd_mem.m_manager', 'mm_i.m_id')
                ->leftjoin('d_mem as mm_ii', 'd_mem.m_lead', 'mm_ii.m_id')
                ->leftjoin('d_mem as mm_iii', 'd_mem.m_specialist', 'mm_iii.m_id')
                ->where('d_mem.m_id', auth()->user()->m_id)
                ->first();
            // return $mail;
            $email_manager = $mail->email_manager;
            $email_lead = $mail->email_lead;
            $email_coor = $mail->email_coor;
            $email_spec = $mail->email_spec;
            $name_manager = $mail->name_manager;
            $name_lead = $mail->name_lead;
            $name_coor = $mail->name_coor;
            $name_spec = $mail->name_spec;

            $incre = DB::table('a_kpi')->max('k_id') + 1;
            if ($incre == null) {
                $crement = 1;
            } else {
                $crement = $incre;
            }

            if (auth()->user()->m_flag == 1) {
            } elseif (auth()->user()->m_flag == 2) {
                if ($request->k_status_id != 5) {
                    //EMAIL KE MANANGER
                    if ($email_manager != null) {
                        SendEmail::dispatch(
                            $email_manager,
                            'mail.manager.manager_notif',
                            'REVIEW: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_coor' => $name_coor,
                                'crement' => $crement,
                                'name_lead' => $name_lead,
                                'name_manager' => $name_manager,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }

                    // EMAIL KE DIRI SENDIRI
                    if ($email_lead != null) {
                        SendEmail::dispatch(
                            $email_lead,
                            'mail.lead.lead_submit',
                            'SUBMIT: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_lead' => $name_lead,
                                'crement' => $crement,
                                'name_manager' => $name_manager,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                }

                if ($request->k_status_id == 5) {
                    $check_status = 5;
                } else {
                    $check_status = 16;
                }
                // return 'a';
            } elseif (auth()->user()->m_flag == 3) {
                // Submit Coordinator
                if ($request->k_status_id != 4) {
                    if ($email_coor != null) {
                        SendEmail::dispatch(
                            $email_coor,
                            'mail.coordinator.coor_submit',
                            'SUBMIT: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_coor' => $name_coor,
                                'name_manager' => $name_manager,
                                'crement' => $crement,
                                'name_lead' => $name_lead,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'k_created_by' => $request->k_created_by,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                    // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER
                    if ($email_lead != null) {
                        SendEmail::dispatch(
                            $email_lead,
                            'mail.lead.lead_notif',
                            'REVIEW: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_lead' => $name_lead,
                                'crement' => $crement,
                                'name_coor' => $name_coor,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                    if ($email_lead == null && $email_manager != null) {
                        SendEmail::dispatch(
                            $email_manager,
                            'mail.manager.manager_notif3',
                            'REVIEW: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_lead' => $name_lead,
                                'crement' => $crement,
                                'name_coor' => $name_coor,
                                'name_manager' => $name_manager,
                                'email_manager' => $email_manager,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                }
                if ($request->k_status_id == 4) {
                    $check_status = 4;
                } else {
                    if ($email_lead != null && $email_manager != null) {
                        $check_status = 13;
                    } elseif ($email_lead == null && $email_manager != null) {
                        $check_status = 16;
                    }
                }

                // Submit KPI IT Speialist dari Create.blade.php
            } elseif (auth()->user()->m_flag == 4) {
                if ($request->k_status_id != 2) {
                    // EMAIL KE DIRI SENDIRI

                    SendEmail::dispatch(
                        $email_spec,
                        'mail.specialist.spec_submit',
                        'SUBMIT: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_coor' => $name_coor,
                            'name_lead' => $name_lead,
                            'name_spec' => $name_spec,
                            'name_lead' => $name_lead,
                            'crement' => $crement,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'kd_duedate' => $request->kd_duedate[0],
                        ]
                    );

                    // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER
                    if ($email_coor != null) {
                        SendEmail::dispatch(
                            $email_coor,
                            'mail.coordinator.coor_notif',
                            'REVIEW: Performance Appraisal',
                            [
                                'pesan' => 'KPI INFORMATION',
                                'k_label' => $request->k_label,
                                'goal' => $request->k_goal,
                                'k_targetdate' => $request->k_targetdate,
                                'name_coor' => $name_coor,
                                'name_lead' => $name_lead,
                                'k_collab_assets' => $request->k_collab_assets,
                                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                                'k_collab_support' => $request->k_collab_support,
                                'name_spec' => $name_spec,
                                'crement' => $crement,
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                    if ($email_coor == null && $email_lead != null) {
                        SendEmail::dispatch(
                            $email_lead,
                            'mail.coordinator.coor_submit',
                            'REVIEW: Performance Appraisal',
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
                                'kd_duedate' => $request->kd_duedate[0],
                            ]
                        );
                    }
                }

                if ($request->k_status_id == 2) {
                    $check_status = 2;
                } else {
                    if ($email_coor != null) {
                        $check_status = 10;
                    } elseif ($email_coor == null && $email_lead != null) {
                        $check_status = 13;
                    } elseif ($email_coor == null && $email_lead == null && $email_manager != null) {
                        $check_status = 16;
                    }
                }
            }

            $sup = nl2br($request->k_supplement);
            $data = DB::table('a_kpi')->insert([
                'k_id' => $crement,
                'k_label' => $request->k_label,
                'k_goal' => $request->k_goal,
                'k_targetdate' => date('Y-m-d', strtotime($request->k_targetdate)), //start revisi 060119
                'k_selfassessment' => $request->assessment_self,
                'k_supplement' => $sup,
                'k_coordinator_id' => session('coor_id'),
                'k_specialist_id' => session('spec_id'),
                'k_site' => session('site'),
                'k_unit' => session('unit_flag'),
                'k_leader_id' => session('lead_id'),
                'k_manager_id' => session('manager_id'),
                'k_status_id' => $check_status,
                'k_collab_assets' => $request->k_collab_assets,
                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                'k_collab_support' => $request->k_collab_support,
                'k_collaboration' => $request->k_collaboration,

                'k_created_at' => date('Y-m-d H:i'),
                'k_updated_at' => date('Y-m-d H:i'),
                'k_created_by' => session('id'),
                'k_reject_coor' => $request->k_reject_coor,
                'k_approval_coor' => $request->k_approval_coor,
                'k_reject_lead' => $request->k_reject_lead,
                'k_approval_lead' => $request->k_approval_lead,
                'k_reject_manager' => $request->k_reject_manager,
                'k_approval_manager' => $request->k_approval_manager,
                'k_justification_coor' => $request->k_justification_coor,
                'k_justification_lead' => $request->k_justification_lead,
                'k_justification_manager' => $request->k_justification_manager,
            ]);
            if ($request->k_status_id == 2 || $request->k_status_id == 4 || $request->k_status_id == 5 || $request->k_status_id == 6) {
                $status_log = 'Save KPI by ' . session('name') . ' AS ' . session('unit');
                $status_log_1 = 'Create KPI by ' . session('name') . ' AS ' . session('unit');
            } else {
                $status_log_1 = 'Create KPI by ' . session('name') . ' AS ' . session('unit');
                $status_log = 'Submit KPI by ' . session('name') . ' AS ' . session('unit');
            }

            // $log_1 = DB::table('d_log')->insert([
            //     'dl_name' => '"' . $status_log_1 . '"',
            //     'dl_desc' => $request->k_label,
            //     'dl_ref_id' => $crement,
            //     'dl_menu' => 11,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);

            for ($i = 0; $i < count($request->kd_duedate); $i++) {
                $incre_detail = DB::table('a_kpid')->max('kd_id');

                if ($incre_detail == null) {
                    $incre_detail = 1;
                } else {
                    $incre_detail += 1;
                }

                if ($request->kd_tacticalstep[$i] == null) {
                    return response()->json(['status' => 'Validasi', 'key' => $i]);
                }
                if ($request->kd_duedate[$i] == null) {
                    return response()->json(['status' => 'Validasi_date', 'key' => $i]);
                }

                $data1[$i] = DB::table('a_kpid')->insert([
                    'kd_id' => $incre_detail,
                    'kd_kpi_id' => $crement,
                    'kd_tacticalstep' => $request->kd_tacticalstep[$i],
                    'kd_measure_id' => $request->kd_measure_id[$i],
                    'kd_duedate' => date('Y-m-d', strtotime($request->kd_duedate[$i])),
                    'kd_result_id' => null,
                    'kd_created_at' => date('Y-m-d H:i'),
                ]);

                // $log_detail_1 = DB::table('d_log')->insert([
                //     'dl_name'=>'"'.$status_log_1.' DETAIL '.($i+1).'"',
                //     'dl_desc'=>$request->kd_tacticalstep[$i],
                //     'dl_ref_id'=> $crement,
                //     'dl_ref_id_detail'=> $incre_detail,
                //     'dl_menu'=> 11,
                //     'dl_created_at'=>date('Y-m-d H:i'),
                //     'dl_created_by'=>auth()->user()->m_id,
                // ]);

                // $log_detail = DB::table('d_log')->insert([
                //     'dl_name' => '"' . $status_log_1 . ' Tactical Step ' . ($i + 1) . '"',
                //     'dl_desc' => $request->kd_tacticalstep[$i],
                //     'dl_ref_id' => $crement,
                //     'dl_ref_id_detail' => $incre_detail,
                //     'dl_menu' => 11,
                //     'dl_created_at' => date('Y-m-d H:i'),
                //     'dl_created_by' => auth()->user()->m_id,
                // ]);
            }
            // $log = DB::table('d_log')->insert([
            //     'dl_name' => '"' . $status_log . '"',
            //     'dl_desc' => $request->k_label,
            //     'dl_ref_id' => $crement,
            //     'dl_menu' => 11,
            //     'dl_created_at' => date('Y-m-d H:i'),
            //     'dl_created_by' => auth()->user()->m_id,
            // ]);

            return response()->json(['status' => 'sukses']);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['status' => 'gagal']);
        }
    }

    function total_kpi(Request $req)
    {
        if ($req->tahun) {
            $data = DB::table('a_kpi')
                ->where('k_created_by', session('id'))
                ->whereYear('k_targetdate', $req->tahun)
                ->get();
        } else {
            $data = DB::table('a_kpi')
                ->where('k_created_by', session('id'))
                ->get();
        }
        $total = count($data);

        return response()->json($total);
    }

    public function update(Request $request)
    {
        if ($request->k_status_id == 2 || $request->k_status_id == 4 || $request->k_status_id == 5 || $request->k_status_id == 6) {
            $status_log = 'Save KPI From edit.blade by ' . session('name') . ' AS ' . session('unit');
        } else {
            $status_log = 'Submit KPI From edit.blade by ' . session('name') . ' AS ' . session('unit');
        }

        $checked_data = DB::table('a_kpi')
            ->where('k_id', '=', $request->hidden_id_header)
            ->first();
        $crement = $checked_data->k_id;

        $check = DB::Table('d_mem')
            ->select('mm_i.m_email as email_manager', 'mm_i.m_name as name_manager', 'mm.m_email as email_coor', 'mm.m_name as name_coor', 'mm_iii.m_email as email_spec', 'mm_iii.m_name as name_spec', 'mm_ii.m_email as email_lead', 'mm_ii.m_name as name_lead')
            ->leftjoin('d_mem as mm', 'd_mem.m_coordinator', 'mm.m_id')
            ->leftjoin('d_mem as mm_i', 'd_mem.m_manager', 'mm_i.m_id')
            ->leftjoin('d_mem as mm_ii', 'd_mem.m_lead', 'mm_ii.m_id')
            ->leftjoin('d_mem as mm_iii', 'd_mem.m_specialist', 'mm_iii.m_id')
            ->where('d_mem.m_id', auth()->user()->m_id)
            ->get();

        $email_manager = $check[0]->email_manager;
        $email_lead = $check[0]->email_lead;
        $email_coor = $check[0]->email_coor;
        $email_spec = $check[0]->email_spec;
        $name_manager = $check[0]->name_manager;
        $name_lead = $check[0]->name_lead;
        $name_coor = $check[0]->name_coor;
        $name_spec = $check[0]->name_spec;

        if (auth()->user()->m_flag == 1) {
        } elseif (auth()->user()->m_flag == 2) {
            // Lead input via Edit Page
            if ($request->k_status_id != 5) {
                SendEmail::dispatch(
                    $email_manager,
                    'mail.manager.manager_notif',
                    'REVIEW: Performance Appraisal',
                    [
                        'nama' => 'APA INI',
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_manager' => $name_manager,
                        'name_coor' => $name_coor,
                        'name_lead' => $name_lead,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate_old[0],
                        'crement' => $crement,
                    ]
                );

                SendEmail::dispatch(
                    $email_lead,
                    'mail.lead.lead_submit',
                    'SUBMIT: Performance Appraisal',
                    [
                        'nama' => 'APA INI',
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'email_coor' => $email_coor,
                        'name_lead' => $name_lead,
                        'name_manager' => $name_manager,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate_old[0],
                        'crement' => $crement,
                    ]
                );
            }
            if ($request->k_status_id == 5) {
                $check_status = 5;
            } else {
                if ($email_manager != null) {
                    $check_status = 16;
                }
            }

            // Coordinator Submit dari show.blade
        } elseif (auth()->user()->m_flag == 3) {
            // Submit Coordinator dari edit.blade.php
            if ($request->k_status_id != 4) {
                $this->updateMailConfig();
                if ($email_coor != null) {
                    SendEmail::dispatch(
                        $email_coor,
                        'mail.coordinator.coor_submit',
                        'SUBMIT: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_coor' => $name_coor,
                            'name_spec' => $name_spec,
                            'name_lead' => $name_lead,
                            'name_manager' => $name_manager,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'kd_duedate' => $request->kd_duedate_old[0],
                            'crement' => $crement,
                        ]
                    );
                }
                // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER
                if ($email_lead != null) {
                    SendEmail::dispatch(
                        $email_lead,
                        'mail.lead.lead_notif',
                        'REVIEW: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_lead' => $name_lead,
                            'name_coor' => $name_coor,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'kd_duedate' => $request->kd_duedate_old[0],
                            'name_spec' => $name_spec,
                            'crement' => $crement,
                        ]
                    );
                }

                if ($email_lead == null && $email_manager != null) {
                    SendEmail::dispatch(
                        $email_manager,
                        'mail.manager.manager_notif3',
                        'REVIEW: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_lead' => $name_lead,
                            'name_coor' => $name_coor,
                            'name_manager' => $name_manager,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'name_spec' => $name_spec,
                            'kd_duedate' => $request->kd_duedate_old[0],
                            'name_spec' => $name_spec,
                            'crement' => $crement,
                        ]
                    );
                }
            }
            if ($request->k_status_id == 4) {
                $check_status = 4;
            } else {
                if ($email_lead != null && $email_manager != null) {
                    $check_status = 13;
                } elseif ($email_lead == null && $email_manager != null) {
                    $check_status = 16;
                }
            }

            // Specialist Submit KPI dari Edit.blade
        } elseif (auth()->user()->m_flag == 4) {
            //Submit IT Specialist dari edit.blade.php
            if ($request->k_status_id != 2) {
                SendEmail::dispatch(
                    $email_spec,
                    'mail.specialist.spec_submit',
                    'SUBMIT: Performance Appraisal',
                    [
                        'pesan' => 'KPI INFORMATION',
                        'k_label' => $request->k_label,
                        'goal' => $request->k_goal,
                        'k_targetdate' => $request->k_targetdate,
                        'name_coor' => $name_coor,
                        'name_lead' => $name_lead,
                        'name_spec' => $name_spec,
                        'crement' => $crement,
                        'k_collab_assets' => $request->k_collab_assets,
                        'k_collab_helpdesk' => $request->k_collab_helpdesk,
                        'k_collab_support' => $request->k_collab_support,
                        'kd_duedate' => $request->kd_duedate_old[0],
                    ]
                );
                // EMAIL KE ATASAN - JIKA COOR TIDAK KOSONG MAKA KE COOR DAN JIKA COOR KOSONG MAKA KE LEAD DAN JIKA LEAD KOSONG KE MANAGER

                if ($email_coor != null) {
                    SendEmail::dispatch(
                        $email_coor,
                        'mail.coordinator.coor_notif',
                        'REVIEW: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_coor' => $name_coor,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'name_spec' => $name_spec,
                            'crement' => $crement,
                            'kd_duedate' => $request->kd_duedate_old[0],
                        ]
                    );
                }
                if ($email_coor == null && $email_lead != null) {
                    SendEmail::dispatch(
                        $email_lead,
                        'mail.lead.lead_notif_2',
                        'REVIEW: Performance Appraisal',
                        [
                            'pesan' => 'KPI INFORMATION',
                            'k_label' => $request->k_label,
                            'goal' => $request->k_goal,
                            'k_targetdate' => $request->k_targetdate,
                            'name_lead' => $name_lead,
                            'k_collab_assets' => $request->k_collab_assets,
                            'k_collab_helpdesk' => $request->k_collab_helpdesk,
                            'k_collab_support' => $request->k_collab_support,
                            'name_spec' => $name_spec,
                            'kd_duedate' => $request->kd_duedate_old[0],
                            'crement' => $crement,
                        ]
                    );
                }
            }
            if ($request->k_status_id == 2) {
                $check_status = 2;
            } else {
                if ($email_coor != null) {
                    $check_status = 10;
                } elseif ($email_coor == null && $email_lead != null) {
                    $check_status = 13;
                } elseif ($email_coor == null && $email_lead == null && $email_manager != null) {
                    $check_status = 16;
                }
            }
        }

        $data = DB::table('a_kpi')
            ->where('k_id', $request->hidden_id_header)
            ->update([
                'k_label' => $request->k_label,
                'k_goal' => $request->k_goal,
                'k_targetdate' => date('Y-m-d', strtotime($request->k_targetdate)),
                'k_status_id' => $check_status,
                'k_updated_at' => date('Y-m-d H:i'),
                'k_reject_coor' => $request->k_reject_coor,
                'k_approval_coor' => $request->k_approval_coor,
                'k_reject_lead' => $request->k_reject_lead,
                'k_collab_assets' => $request->k_collab_assets,
                'k_collab_helpdesk' => $request->k_collab_helpdesk,
                'k_collab_support' => $request->k_collab_support,
                'k_approval_lead' => $request->k_approval_lead, //Save ke draft
                'k_reject_manager' => $request->k_reject_manager,
                'k_approval_manager' => $request->k_approval_manager,
                'k_justification_coor' => $request->k_justification_coor,
                'k_justification_lead' => $request->k_justification_lead,
                'k_justification_manager' => $request->k_justification_manager,
            ]);

        // $log_1 = DB::table('d_log')->insert([
        //     'dl_name' => '"' . $status_log . '"',
        //     'dl_desc' => $request->k_label,
        //     'dl_ref_id' => $crement,
        //     'dl_menu' => 11,
        //     'dl_created_at' => date('Y-m-d H:i'),
        //     'dl_created_by' => auth()->user()->m_id,
        // ]);

        for ($i = 0; $i < count((array) $request->id_remove); $i++) {
            $data = DB::table('a_kpid')
                ->where('kd_id', '=', $request->id_remove[$i])
                ->delete();
        }

        for ($i = 0; $i < count((array) $request->id_old); $i++) {
            $data1 = DB::table('a_kpid')
                ->where('kd_id', '=', $request->id_old[$i])
                ->update([
                    'kd_tacticalstep' => $request->kd_tacticalstep_old[$i],
                    'kd_measure_id' => $request->kd_measure_id_old[$i],
                    'kd_duedate' => date('Y-m-d', strtotime($request->kd_duedate_old[$i])),
                    'kd_updated_at' => date('Y-m-d'),
                ]);
        }

        for ($i = 0; $i < count((array) $request->id_new); $i++) {
            $data1 = DB::table('a_kpid')->insert([
                'kd_tacticalstep' => $request->kd_tacticalstep_new[$i],
                'kd_measure_id' => $request->kd_measure_id_new[$i],
                'kd_duedate' => date('Y-m-d', strtotime($request->kd_duedate_new[$i])),
                'kd_created_at' => date('Y-m-d'),
                'kd_updated_at' => date('Y-m-d'),
                'kd_kpi_id' => $request->hidden_id_header,
            ]);
        }

        return response()->json(['status' => 'sukses']);
    }

    public function waiting($id)
    {
        $data_edit = DB::table('a_kpi')->where('k_id', $id)->first();
        $data = DB::table('a_kpid')->where('kd_kpi_id', $id)->get();

        $check_total_header_kra[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data_edit->k_id)
            ->where('kch_flag', 1)
            ->count();

        $check_total_header_goal[0] = DB::table('a_kpi_comment_header')
            ->where('kch_ref_id', $data_edit->k_id)
            ->where('kch_flag', 2)
            ->count();

        $check_data_total = DB::table('a_kpid')->where('kd_kpi_id', $id)->count();
        $check_data = DB::table('a_kpid')
            ->where('kd_kpi_id', $id)
            ->where('kd_status_id', 'Completed')
            ->count();

        $measure = DB::table('d_measure')->get();

        if ($data_edit->k_created_by == auth()->user()->m_id) {
            return view('assessment.my_kpi.waiting', compact('check_total_header_kra', 'check_total_header_goal', 'data', 'data_edit', 'measure'));
        } else {
            return view('page.privilege_not_access');
        }
    }

    function save_kpi_pdf(Request $req)
    {
        // dd($req->all());
        $check = $req->file('kpi_pdf');
        $dt = DB::table('a_kpi_pdf')->max('kpdf_id') + 1;
        $filename = 'file/' . 'Kpi_PDF_' . auth()->user()->m_name . '_' . $req->hidden_id_header . '_' . $dt . '.pdf';

        Storage::put($filename, file_get_contents($check));

        $data2 = DB::table('a_kpi_pdf')->insert([
            'kpdf_file' => $filename,
            'kpdf_created_at' => date('Y-m-d H:i'),
            'kpdf_created_by' => auth()->user()->m_id,
            'kpdf_site' => auth()->user()->m_site,
        ]);
    }
}
