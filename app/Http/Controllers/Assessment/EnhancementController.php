<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EnhancementController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->m_username == 'bhandoko' || auth()->user()->m_username == 'febrids' || auth()->user()->m_username == 'THadiwidjaja' || auth()->user()->m_username == 'firdauss') {
            $data = DB::table('a_kpi_enhancement')->get();
        } else {
            $data = DB::table('a_kpi_enhancement')->where('k_enhancement_status_id', 31)->get();
        }

        $total = count($data);
        $year = DB::table('d_periode')->get();
        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman ORAL Enhancement ',
            'dl_desc' => '-',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return view('assessment.enhancement.index', compact('data', 'total', 'year'));
    }

    public function create(Request $req)
    {
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.enhancement.create', compact('measure', 'year', 'unit'));
    }

    public function save(Request $req)
    {
        $check = $req->file('file');
        $crement = DB::table('a_kpi_enhancement')->max('k_enhancement_id') + 1;
        if ($req->unit == '1') {
            $unit = 'IT HELPDESK';
        } elseif ($req->unit == '2') {
            $unit = 'IT SUPPORT';
        } elseif ($req->unit == '3') {
            $unit = 'IT ASSETS';
        } elseif ($req->unit == '31') {
            $unit = 'ALL IT';
        }

        if ($check == null || $check == '') {
            $filename = '';
        } else {
            $filename = 'public/file/' . 'Enhancement_' . $req->year . '_' . auth()->user()->m_name . '_' . $req->k_title . '_' . $check->getClientOriginalExtension();
            Storage::put($filename, file_get_contents($check));
        }

        if ($req->k_status_id == 'publish') {
            $status = '31';
        } else {
            $status = '32';
        }

        $data2 = DB::table('a_kpi_enhancement')->insert([
            'k_enhancement_file' => $filename,
            'k_enhancement_created_at' => date('Y-m-d H:i:s'),
            'k_enhancement_revision_date' => date('Y-m-d H:i:s', strtotime($req->k_enhancement_revision_date)),
            'k_enhancement_created_by' => auth()->user()->m_id,
            'k_enhancement_site' => auth()->user()->m_site,
            'k_enhancement_status_id' => $status,
            'k_enhancement_dec' => $req->k_goal,
            'k_enhancement_type' => $req->k_enhancement_type,
            'k_enhancement_title' => $req->k_title,
            'k_enhancement_period' => $req->year,
            'k_enhancement_unit' => $req->unit,
        ]);

        $log = DB::table('d_log')->insert([
            'dl_name' => '"Add KPI Enhancement"',
            'dl_desc' => $req->k_title,
            'dl_filename' => $filename,
            'dl_ref_id' => $crement,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }

    public function publish(Request $req)
    {
        $data = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->first();
        $crement = DB::table('a_kpi_enhancement')->max('k_enhancement_id') + 1;
        if ($req->unit == '1') {
            $unit = 'IT HELPDESK';
        } elseif ($req->unit == '2') {
            $unit = 'IT SUPPORT';
        } elseif ($req->unit == '3') {
            $unit = 'IT ASSETS';
        } elseif ($req->unit == '31') {
            $unit = 'ALL IT';
        }
        $check = $req->file('file');
        if ($check != null || $check != '') {
            $filename = 'public/file/' . 'Enhancement_' . $req->year . '_' . auth()->user()->m_name . '.' . $check->getClientOriginalExtension();
            Storage::put($filename, file_get_contents($check));
        } else {
            $filename = $data->k_enhancement_file;
        }

        if ($req->k_status_id == 'publish') {
            $status = '31';
        } else {
            $status = '32';
        }

        $data2 = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->update([
            'k_enhancement_file' => $filename,
            'k_enhancement_publish_date' => date('Y-m-d H:i:s'),
            'k_enhancement_created_by' => auth()->user()->m_id,
            'k_enhancement_status_id' => $status,
            'k_enhancement_dec' => $req->k_goal,
            'k_enhancement_period' => $req->year,
            'k_enhancement_unit' => $req->unit,
        ]);

        $log = DB::table('d_log')->insert([
            'dl_name' => '"Update KPI Enhancement"',
            'dl_desc' => $req->k_goal,
            'dl_ref_id' => $crement,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }

    public function show(Request $req)
    {
        $data = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->first();
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.enhancement.show', compact('measure', 'year', 'unit', 'data'));
    }

    public function edit(Request $req)
    {
        $data = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->first();
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.enhancement.edit', compact('measure', 'year', 'unit', 'data'));
    }

    public function update(Request $req)
    {
        $data = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->first();
        $crement = DB::table('a_kpi_enhancement')->max('k_enhancement_id') + 1;
        if ($req->unit == '1') {
            $unit = 'IT HELPDESK';
        } elseif ($req->unit == '2') {
            $unit = 'IT SUPPORT';
        } elseif ($req->unit == '3') {
            $unit = 'IT ASSETS';
        } elseif ($req->unit == '31') {
            $unit = 'ALL IT';
        }
        $check = $req->file('file');
        if ($check != null || $check != '') {
            $filename = 'public/file/' . 'Enhancement_' . $req->year . '_' . auth()->user()->m_name . '.' . $check->getClientOriginalExtension();
            Storage::put($filename, file_get_contents($check));
        } else {
            $filename = $data->k_enhancement_file;
        }

        if ($req->k_status_id == 'publish') {
            $status = '31';
        } else {
            $status = '32';
        }

        $data2 = DB::table('a_kpi_enhancement')->where('k_enhancement_id', $req->id)->update([
            'k_enhancement_file' => $filename,
            'k_enhancement_updated_at' => date('Y-m-d H:i:s'),
            'k_enhancement_created_by' => auth()->user()->m_id,
            'k_enhancement_status_id' => $status,
            'k_enhancement_dec' => $req->k_goal,
            'k_enhancement_period' => $req->year,
            'k_enhancement_unit' => $req->unit,
        ]);

        $log = DB::table('d_log')->insert([
            'dl_name' => '"Update KPI Enhancement"',
            'dl_desc' => $req->k_goal,
            'dl_ref_id' => $crement,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }
}
