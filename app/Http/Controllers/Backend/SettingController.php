<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

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

    public function SiteSetting(){

        $site = SiteSetting::find(1);

        return view('admin.backend.setting.site_update', compact('site'));

    }//End Method

    public function UpdateSite(Request $request)
    {

        $site_setting = $request->id;
        $site_logo = SiteSetting::find( $request->id);
        if ($request->file('logo')) {
              // Delete the existing logo if it exists
        if (!empty($site_logo->logo) && File::exists(public_path($site_logo->logo))) {
            File::delete(public_path($site_logo->logo));
        }
            //update with image
            $image = $request->file('logo');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(140, 41)->save('upload/logo/' . $name_gen);
            $save_url = 'upload/logo/' . $name_gen;


            SiteSetting::find( $site_setting)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);

            $notifaction = array('message' => 'Site Setting Updated with image successfully',
                'alert_type' => 'success');

            return redirect()->back()->with($notifaction);
        } else {
            //update with out image
            SiteSetting::find( $site_setting)->update([
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,

            ]);

            $notifaction = array('message' => 'Site Setting without image successfully',
                'alert_type' => 'success');

                return redirect()->back()->with($notifaction);
        } //end else
    } // End Method
}
