<?php

namespace App\Http\Controllers\Backend;

use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{

    public function AdminAllCoupon(){
        $coupon = Coupon::latest()->get();
        return view('admin.backend.coupon.coupon_all', compact('coupon'));
    }//end mathod

    public function AdminAddCoupon(){
        return view('admin.backend.coupon.cuopon_add');
    }//end mathod

    public function AdminStoreCoupon(Request $request){
      Coupon::insert([
        'coupon_name' => strtoupper($request->coupon_name),
        'coupon_discount' => $request->coupon_discount,
        'coupon_validity' => $request->coupon_validity,
      ]);

      $notifaction = array('message' => 'Coupon Inserted successfully',
      'alert_type' => 'success');

  return redirect()->route('admin.all.coupon')->with($notifaction);
    }//end mathod

    public function AdminEditCoupon($id){
        $coupon =  Coupon::find($id);
        return view('admin.backend.coupon.coupon_edit',compact('coupon'));
    }//end mathod

    public function AdminUpdateCoupon(Request $request){
        $coupon_id = $request->id;

        Coupon::find($coupon_id)->update([
          'coupon_name' => strtoupper($request->coupon_name),
          'coupon_discount' => $request->coupon_discount,
          'coupon_validity' => $request->coupon_validity,
        ]);

        $notifaction = array('message' => 'Coupon Updated successfully',
        'alert_type' => 'success');

    return redirect()->route('admin.all.coupon')->with($notifaction);
      }//end mathod

      public function AdminDeleteCoupon($id){
        Coupon::find($id)->delete();

        $notifaction = array('message' => 'Coupon Delete successfully',
        'alert_type' => 'success');

    return redirect()->route('admin.all.coupon')->with($notifaction);
      }//end

      //////////////////////// Instructor All Coupon Methods //////////////////////////

      public function InstructorAllCoupon(){
        $id = Auth::user()->id;
        $coupon = Coupon::where('instructor_id', $id)->latest()->get();
        return view('instructor.coupon.coupon_all',compact('coupon'));
      }//End method

      public function InstructorAddCoupon(){
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id', $id)->latest()->get();
        return view('instructor.coupon.coupon_add',compact('courses'));
    }//end mathod

    public function InstructorStoreCoupon(Request $request){
        Coupon::insert([
          'coupon_name' => strtoupper($request->coupon_name),
          'coupon_discount' => $request->coupon_discount,
          'coupon_validity' => $request->coupon_validity,
          'instructor_id' =>  Auth::user()->id,
          'course_id' => $request->course_id,
        ]);

        $notifaction = array('message' => 'Coupon Inserted successfully',
        'alert_type' => 'success');

    return redirect()->route('instructor.all.coupon')->with($notifaction);
      }//end mathod

      public function InstructorEditCoupon($id){
        $instructor_id = Auth::user()->id;
        $coupon =  Coupon::find($id);
        $courses = Course::where('instructor_id', $instructor_id)->latest()->get();
        return view('instructor.coupon.coupon_edit',compact('coupon','courses'));
    }//end mathod

    public function InstructorUpdateCoupon(Request $request){
        $coupon_id = $request->coupon_id;

        Coupon::find($coupon_id)->update([
          'coupon_name' => strtoupper($request->coupon_name),
          'coupon_discount' => $request->coupon_discount,
          'coupon_validity' => $request->coupon_validity,
          'course_id' => $request->course_id,
        ]);

        $notifaction = array('message' => 'Coupon Updated successfully',
        'alert_type' => 'success');

    return redirect()->route('instructor.all.coupon')->with($notifaction);
      }//end mathod


      public function InstructorDeleteCoupon($id){
        Coupon::find($id)->delete();

        $notifaction = array('message' => 'Coupon Delete successfully',
        'alert_type' => 'success');

    return redirect()->route('instructor.all.coupon')->with($notifaction);
      }//end




}
