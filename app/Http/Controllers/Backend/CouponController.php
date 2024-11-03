<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

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

}
