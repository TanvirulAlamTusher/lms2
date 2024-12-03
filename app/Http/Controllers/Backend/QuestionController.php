<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function UserQuestion(Request $request)
    {
        $course_id = $request->course_id;
        $instructor_id = $request->instructor_id;

        Question::insert([
            'course_id' => $course_id,
            'user_id' => Auth::user()->id,
            'instructor_id' => $instructor_id,
            'subject' => $request->subject,
            'question' => $request->question,

        ]);

        $notifaction = array('message' => 'Question submit Successfully',
            'alert_type' => 'success');

        return redirect()->back()->with($notifaction);

    } //End method

    public function InstructorAllQuestion()
    {
        $id = Auth::user()->id;
        $questions = Question::where('instructor_id', $id)->where('parent_id', null)
            ->orderBy('id', 'desc')->get();

        return view('instructor.question.all_question', compact('questions'));
    } //End method

    public function QuestionDetails($id)
    {
        $question = Question::find($id);
        $reply = Question::where('parent_id', $id)->orderBy('id','asc')->get();
        return view('instructor.question.question_details', compact('question','reply'));
    } //End method

    public function InstructorReply(Request $request)
    {
        $que_id = $request->qid;
        $course_id = $request->course_id;
        $user_id = $request->user_id;
        $instructor_id = $request->instructor_id;

        Question::insert([
            'course_id' => $course_id,
            'user_id' => $user_id,
            'instructor_id' => $instructor_id,
            'parent_id' => $que_id,
            'question' => $request->question,
        ]);

        $notifaction = array('message' => 'Reply Sent Successfully',
            'alert_type' => 'success');

        return redirect()->route('instructor.all.question')->with($notifaction);

    } //End method
}
