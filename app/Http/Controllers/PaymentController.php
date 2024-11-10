<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends Controller
{
    public function Payment(Request $request){

        if(Session::has('coupon')) {
            $total_amount = Session::get('coupon')['total_amount'];

        }else{
            $total_amount = round(Cart::total()) ;
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
        $date->invoice_no = 'EOS'.mt_rand(100000000,99999999);
        $date->order_date =Carbon::now()->format('d F Y');
        $date->order_month =Carbon::now()->format('F');
        $date->order_year =Carbon::now()->format('Y');
        $date->status ='pending';
        $date->save();

    }
}
