<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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

        $notifaction = array('message' => 'Logout successfully',
        'alert_type' => 'success');


        return redirect('/admin/login')->with($notifaction );
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

    public function BecomeInstructor()
    {
        return view('frontend.instructor.reg_instructor');
    } //end mathod

    public function InstructorRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        User::create([
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

    } //end mathod

    public function AllInstructor()
    {
        $allinstructors = User::where('role', 'instructor')->latest()->get();
        return view('admin.backend.instructor.all_instructor', compact('allinstructors'));

    } //end mathod
    public function UpdateUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $isChecked = $request->input('is_checked', 0);

        $user = User::find($userId);

        if ($user) {
            $user->status = $isChecked;
            $user->save();
        }
        return response()->json(['message' => 'User Status Updated Successfully']);

    } //end method

    public function AdminAllCourse()
    {
        $course = Course::latest()->get();
        return view('admin.backend.courses.all_course', compact('course'));
    } //end method

    public function UpdateCourseStatus(Request $request)
    {
        $courseId = $request->input('course_id');
        $ischecked = $request->input('is_checked', 0);

        $course = Course::find($courseId);

        if ($course) {
            $course->status = $ischecked;
            $course->save();
        }
        return response()->json(['message' => 'Course Status Updated Successfully']);

    }//end method
    public function AdminCourseDetails($id){

        $course = Course::find($id);
        return view('admin.backend.courses.course_details', compact('course'));

    }//end method
    ///////////////////////////////////Admin User All Route/////////////////////////////////////
    public function AllAdmin(){
        $alladmin = User::where('role', 'admin')->get();
        return view('admin.backend.pages.admin.all_admin', compact('alladmin'));

    }//end function
    public function AddAdmin(){
        $roles = Role::all();
        return view('admin.backend.pages.admin.add_admin', compact('roles'));
    }//end function

    public function StoreAdmin(Request $request){
       $user = new User();
       $user->username = $request->username;
       $user->name = $request->name;
       $user->email = $request->email;
       $user->phone = $request->phone;
       $user->address = $request->address;
       $user->password =Hash::make($request->password);
       $user->role = 'admin';
       $user->status = '1';
       $user->save();

       if ($request->roles) {
        $role = Role::find($request->roles); // Fetch role by ID

        if ($role) {
            $user->assignRole($role->name); // Assign by role name
        }
    }


       $notifaction = array('message' => 'New Admin inserted successfully',
       'alert_type' => 'success');


       return redirect()->route('all.admin')->with($notifaction );
    }//end function

     ///////////////////////////////////End Admin User All Route/////////////////////////////////////

}
