<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function SmtpSetting(){

        $smtp = SmtpSetting::find(1);

        return view('admin.backend.setting.smtp_setting', compact('smtp'));

    }//End Method

    public function UpdateSmtp(Request $request){
       $smtp_id = $request->id;

       SmtpSetting::find( $smtp_id)->update([
          'mailer' => $request->mailer,
          'host' => $request->host,
          'port' => $request->port,
          'username' => $request->username,
          'password' => $request->password,
          'encryption' => $request->encryption,
          'from_address' => $request->from_address,
       ]);
       $notifaction = array('message' => 'Smtp Updated',
            'alert_type' => 'success');

        return redirect()->back()->with($notifaction);


    }//End Method
}
