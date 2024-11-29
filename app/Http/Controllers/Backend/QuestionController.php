<?php

namespace App\Http\Controllers\Backend;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function UserQuestion(Request $request){
       $course_id = $request->course_id;
       $instructor_id = $request->instructor_id;

       Question::insert([
         'course_id' => $course_id,
         'user_id' =>Auth::user()->id,
         'instructor_id' => $instructor_id,
         'subject' => $request->subject,
         'question' => $request->question,

       ]);

       $notifaction = array('message' => 'Question submit Successfully',
       'alert_type' => 'success');

   return redirect()->back()->with($notifaction);

    }//End method
}
