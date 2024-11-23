<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
 public function PendingOrder(){
    $payment = Payment::where('status','pending')->orderBy('id','DESC')->get();
    return view('admin.backend.order.pending_order',compact('payment'));
 }//End function

 public function ConfirmOrder(){
    $payment = Payment::where('status','confirm')->orderBy('id','DESC')->get();
    return view('admin.backend.order.confirm_order',compact('payment'));
 }//End function

 public function OrderDetails($payment_id){
    $payment = Payment::where('id', $payment_id)->first();
    $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

    return view('admin.backend.order.order_details',compact('payment','orderItem'));

 }//End Methods

 public function PendingToConfirm($payment_id){
     $payment = Payment::find($payment_id)->update(['status' =>'confirm']);

     $notifaction = array('message' => 'Oeder Confirm Successfully',
     'alert_type' => 'success');

 return redirect()->route('admin.confirm.order')->with($notifaction);
 }//End Methods

   public function InstructorAllOrder(){
        $id = Auth::user()->id;

        $latestOrderItem = Order::where('instructor_id',$id)->select('payment_id', \DB::raw('MAX(id) as max_id'))->groupBy('payment_id');


        $orderItem = Order::joinSub( $latestOrderItem,'latest_order', function($join){
            $join->on('orders.id', '=','latest_order.max_id');
        })->orderBy('latest_order.max_id','DESC')->get();


        return view('instructor.order.all_order', compact('orderItem'));

   }//End Methods

   public function InstructorOrderDetails($payment_id){
    $payment = Payment::where('id', $payment_id)->first();
    $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

    return view('instructor.order.order_details',compact('payment','orderItem'));

 }//End Methods

   public function InstructorOrderInvoice($payment_id){
    $payment = Payment::where('id', $payment_id)->first();
    $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

   $pdf = Pdf::loadView('instructor.order.order_pdf', compact('payment','orderItem'))
   ->setPaper('a4')
   ->setOption([
       'tempDir' => public_path(),
       'chroot' => public_path(),
   ]);

   return $pdf->download('invoice.pdf');

 }//End Methods

}
