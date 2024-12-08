<?php

namespace App\Http\Controllers\Backend;

use DateTime;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    //
    public function ReportView(){
        return view('admin.backend.report.report_view');
    }//End Method

    public function SearchByDate(Request $request){
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        // $payment = Payment::where('order_date', $formatDate)->latest();
        $payment = Payment::where('order_date', $formatDate)->latest()->get();

        return view('admin.backend.report.report_by_date',compact('payment','formatDate'));

    }//End Method
}
