<?php

namespace App\Http\Controllers\Assessment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ConfigUpdater;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    use ConfigUpdater;
    
    public function index(Request $request)
    {
        $audit = DB::table('d_log')
            ->join('d_mem','d_mem.m_id','=','dl_created_by')
            ->select(
                [
                    'd_mem.m_name',
                    'dl_name',
                    'dl_desc',
                    'dl_menu',
                    'dl_ref_id',
                    'dl_ref_id_detail',
                    'dl_created_at',
                    'dl_created_by',
                    'dl_filename'
                ]
            )
            ->get();

        // return $audit;
        $menu = DB::table('d_menu')->get();
        $d_mem = DB::table('d_mem')->get();
        return view('assessment.audit.index',compact('audit','menu','d_mem'));
    }

    public function reminder(Request $request)
    {
        // return 'ini index';
        $reminder = DB::table('d_log_reminder')
        ->orderBy('dlr_created_at', 'DESC')
        ->get();
        $menu = DB::table('d_menu')->get();
        $d_mem = DB::table('d_mem')->get();
        return view('assessment.audit.reminder',compact('reminder','menu','d_mem'));
    }
}
