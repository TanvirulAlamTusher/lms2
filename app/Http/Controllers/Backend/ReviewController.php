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

    public function AdminPendingReview(){
        $review = Review::where('status',0)->orderBy('id','DESC')->get();
        return view('admin.backend.review.pending_review',compact('review'));
    }//End method
    public function AdminActiveReview(){
        $review = Review::where('status',1)->orderBy('id','DESC')->get();
        return view('admin.backend.review.active_review',compact('review'));
    }//End method


    public function UpdateReviewStatus(Request $request)
    {
        $reviewId = $request->input('review_id');
        $isChecked = $request->input('is_checked', 0);

        $review = Review::find( $reviewId);

        if ($review) {
            $review->status = $isChecked;
            $review->save();
        }
        return response()->json(['message' => 'Review Status Updated Successfully']);

    } //end method

}
