<?php

namespace App\Http\Controllers;

use App\Mail\Orderconfirm;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stripe;

class PaymentController extends Controller
{
    public function Payment(Request $request)
    {

        if (Session::has('coupon')) {
            $total_amount = Session::get('coupon')['total_amount'];

        } else {
            $total_amount = round(Cart::total());
        }
        $data = array();
             $data['name']  = $request->name;
             $data['email']  = $request->email;
             $data['phone'] = $request->phone;
             $data['address']  = $request->address;
             $data['course_title']  = $request->course_title;



        $cartTotal = Cart::total();
        $carts = Cart::content();


        if ($request->cash_delivery == 'stripe') {
            return view('frontend.payment.stripe',compact('data','cartTotal','carts'));

        } else if ($request->cash_delivery == 'handcash') {

            // Create a new payment record
            $data = new Payment();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->cash_delivery = $request->cash_delivery;
            $data->total_amount = $total_amount;
            $data->payment_type = 'Direct Payment';
            $data->invoice_no = 'EOS' . mt_rand(10000000, 99999999);
            $data->order_date = Carbon::now()->format('d F Y');
            $data->order_month = Carbon::now()->format('F');
            $data->order_year = Carbon::now()->format('Y');
            $data->status = 'pending';
            $data->save();

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

                $order->payment_id = $data->id;
                $order->user_id = Auth::user()->id;
                $order->course_id = $request->course_id[$key];
                $order->instructor_id = $request->instructor_id[$key];
                $order->course_title = $course_title;
                $order->price = $request->price[$key];
                $order->save();

            } // end for each
            /// remove cart data from Cart
            $request->session()->forget('cart');

            $paymentId = $data->id;

            /// Start Send email to student ///
            $sendmail = Payment::find($paymentId);
            $data = [
                'invoice_no' => $sendmail->invoice_no,
                'amount' => $total_amount,
                'name' => $sendmail->name,
                'email' => $sendmail->email,
            ];

            Mail::to($request->email)->send(new Orderconfirm($data));
            /// End Send email to student ///

            $notifaction = array('message' => 'Cash Payment submit successfully',
                'alert_type' => 'success');

            return redirect()->route('index')->with($notifaction);

        } // end else if

    }//End method
    public function StripeOrder(Request $request){

        if (Session::has('coupon')) {
            $total_amount = Session::get('coupon')['total_amount'];

        } else {
            $total_amount = round(Cart::total());
        }

        \Stripe\Stripe::setApiKey('sk_test_51QStwYJufiqonGzKbn5qHfXEDmuCl6HWsZCUr6lAKFni12xytfXUoAFeQ2JNAlJ67mVIxbdxk2rIidmqae6QPJPB007cEvdjcE');
        $token = $_POST['stripeToken'];

        $charge =  \Stripe\Charge::create([
            'amount' =>  $total_amount*100,
            'currency' => 'usd',
            'description' =>'Lms',
            'source' => $token,
            'metadata' => ['order_id' => '3434'],
        ]);
        $order_id = Payment::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'cash_delivery' => $request->cash_delivery,
            'total_amount' => $total_amount,
            'payment_type' =>'Stripe Payment',
            'invoice_no' =>'EOS' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'pending',
        ]);


        $carts = Cart::content();
        foreach ($carts as $cart) {
           Order::insert([
               'payment_id' => $order_id,
               'user_id' => Auth::user()->id,
               'course_id' => $cart->id,
               'instructor_id' => $cart->options->instructor,
               'course_title' => $cart->options->name,
               'price' => $cart->price,
           ]);
        }// end foreach

        if (Session::has('coupon')) {
           Session::forget('coupon');
        }
        Cart::destroy();

        $notification = array(
           'message' => 'Stripe Payment Submit Successfully',
           'alert-type' => 'success'
       );
       return redirect()->route('index')->with($notification);

   }// End Method
}


