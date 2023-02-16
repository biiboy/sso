<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('d_role_menu')->select('role_id', 'u_name')->join('d_unit', 'd_unit.u_id', '=', 'd_role_menu.role_id')->groupBy('role_id', 'u_name')->get();
        $data_menu = DB::table('d_role_menu')->join('d_menu', 'd_menu.menu_id', '=', 'd_role_menu.menu_id')->get();

        return view('master.access.index', compact('data', 'data_menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.access.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job_role = Unit::all();
        $menu = DB::table('d_menu')->get();
        $data = DB::table('d_unit')->leftjoin('d_role_menu', 'd_unit.u_id', '=', 'd_role_menu.role_id')->where('u_id', $id)->get();
        return view('master.access.edit', compact('data', 'menu', 'job_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = DB::table('d_role_menu')->where('role_id', $request->job_role)->delete();
        for ($i = 0; $i < count($request->menu); $i++) {

            $datas[$i] = DB::table('d_role_menu')->insert([
                'role_id' => $request->job_role,
                'role_status' => $request->m_status,
                'menu_id' => $request->menu[$i],
            ]);
        }
        //return response 
        if ($datas == true) {
            return response()->json(['status' => 'sukses']);
        } else {
            return response()->json(['status' => 'gagal']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
