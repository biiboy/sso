<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TargetController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->m_flag == 1) {
            $data = DB::table('a_kpi_pdf')->get();
        } else {
            $data = DB::table('a_kpi_pdf')->where('kpdf_status_id', 21)->get();
        }
        $total = count($data);
        $year = DB::table('d_periode')->get();

        $log = DB::table('d_log')->insert([
            // 'dl_name'=>'"Berada di Halaman My KPI"',
            'dl_name' => '' . session('name') . ' akses halaman KPI Target ',
            'dl_desc' => '-',
            'dl_filename' => '-',
            'dl_ref_id' => '0',
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);

        return view('assessment.target.index', compact('data', 'total', 'year'));
    }

    public function create(Request $req)
    {
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.target.create', compact('measure', 'year', 'unit'));
    }

    public function save(Request $req)
    {
        $check = $req->file('file');
        $crement = DB::table('a_kpi_pdf')->max('kpdf_id') + 1;
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
            $filename = 'public/file/' . 'KPI_TARGET_PERIODE_' . $req->year . '_' . auth()->user()->m_name . '.' . $check->getClientOriginalExtension();
            Storage::put($filename, file_get_contents($check));
        }

        if ($req->k_status_id == 'publish') {
            $status = '21';
        } else {
            $status = '22';
        }

        $data2 = DB::table('a_kpi_pdf')->insert([
            'kpdf_file' => $filename,
            'kpdf_created_at' => date('Y-m-d H:i:s'),
            'kpdf_updated_at' => date('Y-m-d H:i:s'),
            'kpdf_created_by' => auth()->user()->m_id,
            'kpdf_site' => auth()->user()->m_site,
            'kpdf_status_id' => $status,
            'kpdf_dec' => $req->k_goal,
            'kpdf_title' => $req->k_title,
            'kpdf_period' => $req->year,
            'kpdf_unit' => $req->unit,
        ]);

        $log = DB::table('d_log')->insert([
            'dl_name' => '"Insert KPI Target"',
            'dl_desc' => $req->k_label,
            'dl_ref_id' => $crement,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }

    public function show(Request $req)
    {
        $data = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->first();
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.target.show', compact('measure', 'year', 'unit', 'data'));
    }

    public function edit(Request $req)
    {
        $data = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->first();
        $measure = DB::table('d_measure')->get();
        $year = DB::table('d_periode')->get();
        $unit = DB::table('d_unit')->select('u_name_header', 'u_flag')->groupBy('u_name_header', 'u_flag')->get();
        return view('assessment.target.edit', compact('measure', 'year', 'unit', 'data'));
    }

    public function update(Request $req)
    {
        $data = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->first();
        $crement = DB::table('a_kpi_pdf')->max('kpdf_id') + 1;
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
            $filename = 'public/file/' . 'KPI_TARGET_PERIODE_' . $req->year . '_' . auth()->user()->m_name . '.' . $check->getClientOriginalExtension();
            Storage::put($filename, file_get_contents($check));
        } else {
            $filename = $data->kpdf_file;
        }

        if ($req->k_status_id == 'publish') {
            $status = '21';
        } else {
            $status = '22';
        }

        $data2 = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->update([
            'kpdf_file' => $filename,
            'kpdf_created_at' => date('Y-m-d H:i:s'),
            'kpdf_updated_at' => date('Y-m-d H:i:s'),
            'kpdf_created_by' => auth()->user()->m_id,
            'kpdf_status_id' => $status,
            'kpdf_dec' => $req->k_goal,
            'kpdf_period' => $req->year,
            'kpdf_unit' => $req->unit,
        ]);

        $log = DB::table('d_log')->insert([
            'dl_name' => '"Update KPI Target"',
            'dl_desc' => $req->k_goal,
            'dl_ref_id' => $crement,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }

    public function deletes(Request $req)
    {
        $data2 = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->first();
        $del = DB::table('a_kpi_pdf')->where('kpdf_id', $req->id)->delete();
        Storage::delete($data2->kpdf_file);
        $log = DB::table('d_log')->insert([
            'dl_name' => '"Delete KPI Target"',
            'dl_desc' => '',
            'dl_ref_id' => $data2->kpdf_id,
            'dl_menu' => 11,
            'dl_created_at' => date('Y-m-d H:i:s'),
            'dl_created_by' => auth()->user()->m_id,
        ]);
        return response()->json(['status' => 'sukses']);
    }
}
