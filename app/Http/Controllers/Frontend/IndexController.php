<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Course_goal;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function CourseDetails($id,$slug){
       $course = Course::find($id);
       $goals = Course_goal::where('course_id',$id)->orderBy('id','DESC')->get();
       $categoris = Category::latest()->get();

       $ins_id = $course->instructor_id;
       $instructorCourses = Course::where('instructor_id',$ins_id)->where('status',1)->orderBy('id','DESC')->get();

       $category_id = $course->category_id;
       $relatedCourses = Course::where('category_id',$category_id)->where('id', '!=', $id)
    ->where('status',1)->orderBy('id','DESC')->limit(3)->get();
       return view('frontend.course.course_details',compact('course','goals','instructorCourses','categoris','relatedCourses'));

    }
}
