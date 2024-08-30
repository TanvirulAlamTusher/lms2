<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }
    //End Method
    public function AdminLogin(Request $request)
    {
        return view('admin.admin_login');
    }
    //End Method

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    //End Method
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    } //End Method

    public function AdminProfileStore(Request $request)
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
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notifaction = array('message' => 'Profile updated Successfully',
            'alert_type' => 'success');

        return redirect()->back()->with($notifaction);
    } //End Method

    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password_view', compact('profileData'));

    } //end Method

    public function AdminPasswordUpdate(Request $request)
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

    public function BecomeInstructor(){
       return view('frontend.instructor.reg_instructor');
    }//end mathod

    public function InstructorRegister(Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','unique:users'],
            'password' => ['required','string','max:255'],
        ]);

        User::insert([
             'name' => $request->name,
             'username' => $request->username,
             'email' => $request->email,
             'password' => Hash::make($request->password),
             'phone' => $request->phone,
             'address' => $request->address,
             'role' => 'instructor',
             'status' => '0',

        ]);

        $notifaction = array(
        'message' => 'Instructor Registed successfully',
        'alert_type' => 'success');

    return redirect()->route('instructor.login')->with($notifaction);

    }//end mathod

    public function AllInstructor(){
        $allinstructors = User::where('role','instructor')->latest()->get();
        return view('admin.backend.instructor.all_instructor',compact('allinstructors'));
        
    }//end mathod
}
