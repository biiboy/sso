<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public static function login($username)
    {
        auth()->logout();
        session()->flush();
        session()->save();

        $user = Member::where('m_username', $username)->first();
        auth()->login($user);
        $usernm = $user->m_username;

        $ses = DB::select("SELECT d.m_id,
                                    d.m_name as nama,
                                    d.m_manager,
                                    d.m_lead,
                                    d.m_coordinator,
                                    d.m_specialist,
                                    d.m_email as email,
                                    (SELECT dm.m_name from d_mem dm where  dm.m_id=d.m_manager LIMIT 1) as manager ,
                                    u2.m_name as lead,
                                    u3.m_name as coor,
                                    u7.m_name as spec,
                                    u4.u_name as role,
                                    u5.u_name as unit,
                                    u5.u_id   as unit_id,
                                    u5.u_role as unit_role,
                                    u5.u_flag as unit_flag,
                                    u6.s_id   as site_id,
                                    u6.s_name as site_name
                from d_mem d
                LEFT JOIN d_mem u2 ON u2.m_id=d.m_lead
                LEFT JOIN d_mem u3 ON u3.m_id=d.m_coordinator
                LEFT JOIN d_mem u7 ON u7.m_id=d.m_specialist
                LEFT JOIN d_unit u4 ON u4.u_id=d.m_access
                LEFT JOIN d_unit u5 ON u5.u_id=d.m_unit
                LEFT JOIN d_site u6 ON u6.s_id=d.m_site
                where d.m_username = '$usernm'
                ");

        session()->put('id', $ses[0]->m_id);
        session()->put('username', $usernm);
        session()->put('name', $ses[0]->nama);
        session()->put('unit', $ses[0]->unit);
        session()->put('unit_id', $ses[0]->unit_id);
        session()->put('unit_role', $ses[0]->unit_role);
        session()->put('unit_flag', $ses[0]->unit_flag);
        session()->put('email', $ses[0]->email);
        session()->put('role', $ses[0]->role);
        session()->put('coor', $ses[0]->coor);
        session()->put('lead', $ses[0]->lead);
        session()->put('spec', $ses[0]->spec);
        session()->put('spec_id', $ses[0]->m_specialist);
        session()->put('coor_id', $ses[0]->m_coordinator);
        session()->put('lead_id', $ses[0]->m_lead);
        session()->put('manager_id', $ses[0]->m_manager);
        session()->put('manager', $ses[0]->manager);
        session()->put('site', $ses[0]->site_id);
        session()->put('site_name', $ses[0]->site_name);
    }
}
