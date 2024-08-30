<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
     public function InstructorDashboard()
     {
        return view('instructor.index');
     }
     //End Method
     public function InstructorLogin(Request $request)
     {
         return view('instructor.instructor_login');
     }
     //End Method
     public function InstructorLogout(Request $request)
     {
         Auth::guard('web')->logout();

         $request->session()->invalidate();

         $request->session()->regenerateToken();

         return redirect('/instructor/login');
     }
     //End Method

     public function InstructorProfile()
     {
         $id = Auth::user()->id;
         $profileData = User::find($id);
         return view('instructor.instructor_profile_view', compact('profileData'));
     } //End Method

     public function InstructorProfileStore(Request $request)
     {
         $id = Auth::user()->id;
         $data = User::find($id);

         $data->name = $request->name;
         $data->username = $request->username;
         $data->email = $request->email;
         $data->phone = $request->phone;
         $data->address = $request->address;

         if ($request->file('photo')) {
             $file = $request->file('photo');
             @unlink(public_path('upload/instructor_images/' . $data->photo));
             $filename = date('YmdHi') . $file->getClientOriginalName();
             $file->move(public_path('upload/instructor_images'), $filename);
             $data['photo'] = $filename;
         }
         $data->save();

         $notifaction = array('message' => 'Instructor Profile updated Successfully',
             'alert_type' => 'success');

         return redirect()->back()->with($notifaction);
     } //End Method
     public function InstructorChangePassword()
     {
         $id = Auth::user()->id;
         $profileData = User::find($id);
         return view('instructor.instructor_change_password_view', compact('profileData'));

     } //end Method
     public function InstructorPasswordUpdate(Request $request)
     { //validation
         $request->validate([
             'old_password' => 'required',
             'new_password' => 'required|confirmed',

         ]);
         if (!Hash::check($request->old_password, auth::user()->password)) {
             $notifaction = array('message' => 'Old password does not match',
                 'alert_type' => 'error');

             return back()->with($notifaction);
         }
         //update the new password
         User::whereId(auth::user()->id)->update([
             'password' => Hash::make($request->new_password),
         ]);
         $notifaction = array('message' => 'Password change successfully',
             'alert_type' => 'success');

         return back()->with($notifaction);

     } //end Method

}
