<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function Payment(Request $request)
    {

        if (Session::has('coupon')) {
            $total_amount = Session::get('coupon')['total_amount'];

        } else {
            $total_amount = round(Cart::total());
        }

        // Create a new payment record
        $date = new Payment();
        $date->name = $request->name;
        $date->email = $request->email;
        $date->phone = $request->phone;
        $date->address = $request->address;
        $date->cash_delivery = $request->cash_delivery;
        $date->total_amount = $total_amount;
        $date->payment_type = 'Direct Payment';
        $date->invoice_no = 'EOS' . mt_rand(10000000, 99999999);
        $date->order_date = Carbon::now()->format('d F Y');
        $date->order_month = Carbon::now()->format('F');
        $date->order_year = Carbon::now()->format('Y');
        $date->status = 'pending';
        $date->save();

        // check if same course purchase again
        // we have  to ristract it, same course can not purchace second time
        foreach ($request->course_title as $key => $course_title) {
            $existingOrdr = Order::where('user_id', Auth::user()->id)
                ->where('course_id', $request->course_id[$key])->first();

            if ($existingOrdr) {
                $notifaction = array('message' => 'You have already enroll this course',
                    'alert_type' => 'error');

                return redirect()->back()->with($notifaction);
            } //end if

            $order = new Order();

            $order->payment_id = $date->id;
            $order->user_id = Auth::user()->id;
            $order->course_id = $request->course_id[$key];
            $order->instructor_id = $request->instructor_id[$key];
            $order->course_title = $course_title;
            $order->price = $request->price[$key];
            $order->save();



        }// end for each
        $request->session()->forget('cart');
        ///start sent mail to student ///
       $paymentId = $date->id;

     ///END sent mail to student ///
        if($request->cash_delivery == 'stripe'){
            echo "stripe";
            // return view('');
        }else{
            $notifaction = array('message' => 'Cash Payment submit successfully',
            'alert_type' => 'success');

        return redirect()->route('index')->with($notifaction);
        }
        //end if
    }
}

