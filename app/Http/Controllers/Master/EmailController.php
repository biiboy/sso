<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\SmtpConnectionTester;
use App\Models\MailSetting;

class EmailController extends Controller
{
    public function index()
    {
        $mailSettings = MailSetting::get()->mapWithKeys(function ($item) {
            return [$item->key => $item->value];
        })->toArray();
        $menu = DB::table('d_menu')->get();
        $data = DB::table('d_role_menu')->select('role_id', 'u_name')->join('d_unit', 'd_unit.u_id', '=', 'd_role_menu.role_id')->groupBy('role_id', 'u_name')->get();
        $data_menu = DB::table('d_role_menu')->join('d_menu', 'd_menu.menu_id', '=', 'd_role_menu.menu_id')->get();

        return view('master.email.index', compact('mailSettings', 'data', 'menu', 'data_menu'));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'host' => 'required|string',
            'port' => 'required|numeric',
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $requestData = $request->all();
        $requestData['encryption'] = empty($request->input('encryption')) ? '' : 'tls';

        if ($this->testConnection($request, $requestData)) {
            foreach ($requestData as $key => $value) {
                MailSetting::where('key', $key)->update(['value' => $value]);
            }
            session()->flash('message', 'Connection test passed!');
        } else {
            session()->flash('message', 'Connection test failed!');
        }

        return redirect()->route('master_email');
    }

    protected function testConnection(Request $request, $requestData)
    {
        $success = false;

        try {
            $tester = new SmtpConnectionTester($requestData);
            $responses = $tester->testAuth();

            if (count($responses) == 3 && substr($responses[2], 0, 1) == '5') {
                session()->flash('error_message', $responses[2]);
            } elseif (count($responses) == 3 && substr($responses[2], 0, 1) == '2') {
                $success = true;
            } else {
                session()->flash('error_message', empty($responses) ? 'unknown response' : implode(',', $responses));
            }
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage(), [$exception]);
            session()->flash('error_message', 'Error connecting: ' . $exception->getMessage());
        }

        return $success;
    }
}
