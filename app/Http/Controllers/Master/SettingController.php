<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all();
        return view('master.setting.index', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Menu::where('menu_id', $id)->first();
        return view('master.setting.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Menu::where('menu_id', $request->menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);

            if ($data == true) {
                return response()->json(['status' => 'sukses']);
            } else {
                return response()->json(['status' => 'gagal']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'gagal']);
        }
    }
}
