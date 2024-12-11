<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //
    public function StoreReview(Request $request){
       $user_id = Auth::user()->id;
       $course_id = $request->course_id;
       $instructor_id = $request->instructor_id;

       $request->validate([
          'comment' => 'required',
       ]);

       Review::insert([
          'course_id' => $course_id,
          'instructor_id' => $instructor_id,
          'user_id' => $user_id,
          'comment' => $request->comment,
          'rating' => $request->rate,
       ]);

       $notifaction = array('message' => 'Review Will Approve By Admin Soon',
        'alert_type' => 'success');


        return redirect()->back()->with($notifaction );
    }//End method
}
