<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Adldap\Laravel\Facades\Adldap;
use App\Models\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $exceptionUsers = ['admin', 'user1', 'user2', 'ksoleh', 'THadiwidjaja'];

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            // 'password' => 'required|string',
        ]);
    }

    public function login(Request $req)
    {
        // return 'a';
        // dd($req->all());
        $response = false;
        $user = Member::where('m_username',$req->username)->first();
        // // Connect Active Directory
        // // Starting
        if ($user && !in_array($req->username, $this->exceptionUsers)) {
            try {
                $response = Adldap::auth()->attempt($req->username, $req->password);
            } catch (\Exception $e) {
                //invalid credential or server time out
            }
        }
        else if ($user && $user->m_password == sha1(md5('لا إله إلاّ الله') . $req->password)) { 
            $response = true;
        }
        

        if ($response) {
            // return 'a';
            $usernm = $req->username;
            Auth::login($user);

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

            // return json_encode($ses);
            Session::put('id',$ses[0]->m_id);
            Session::put('username',$req->username);
            Session::put('name',$ses[0]->nama);
            Session::put('unit',$ses[0]->unit);
            Session::put('unit_id',$ses[0]->unit_id);
            Session::put('unit_role',$ses[0]->unit_role);
            Session::put('unit_flag',$ses[0]->unit_flag);
            Session::put('email',$ses[0]->email);
            Session::put('role',$ses[0]->role);
            Session::put('coor',$ses[0]->coor);
            Session::put('lead',$ses[0]->lead);
            Session::put('spec',$ses[0]->spec);
            Session::put('spec_id',$ses[0]->m_specialist);
            Session::put('coor_id',$ses[0]->m_coordinator);
            Session::put('lead_id',$ses[0]->m_lead);
            Session::put('manager_id',$ses[0]->m_manager);
            Session::put('manager',$ses[0]->manager);
            Session::put('site',$ses[0]->site_id);
            Session::put('site_name',$ses[0]->site_name);

            $data = DB::table('d_mem')->where('m_username',$req->username)->update(['m_lastlogin'=>date('Y-m-d h:i:s')]);
             $log_detail = DB::table('d_log_login')->insert([
                            'dl_name'=>'Login dengan username '.session::get('username'),
                            'dl_menu'=> "login",
                            'dl_created_at'=>date('Y-m-d H:i:s'),
                            'dl_created_by'=>Auth::user()->m_username,
                            'dl_ip_address'=>\Request::getClientIp(true),
                            'dl_hostname'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                        ]);

            return redirect(url('/home'));
        }else{
            return Redirect::back()->withErrors(['Wrong Username / Password !']);
        }
    }

    use AuthenticatesUsers;

    public function logout(Request $request)
    {
        // $this->guard()->logout();
        Auth::logout();

        $data = DB::table('d_mem')->where('m_username',Session::get('username'))->update(['m_lastlogout'=>date('Y-m-d h:i:s')]);
        $log_detail = DB::table('d_log_logout')->insert([
                            'dl_name'=>'Logout dengan username '.session::get('username'),
                            'dl_menu'=> "logout",
                            'dl_created_at'=>date('Y-m-d H:i:s'),
                            'dl_created_by'=>Session::get('username'),
                            'dl_ip_address'=>\Request::getClientIp(true),
                            'dl_hostname'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                        ]);

        $request->session()->regenerate();
        // return redirect('/login')->with('Info','You have been logged out.');
       return redirect('/login')->with('info', 'You have successfully logged out');
    }
}
