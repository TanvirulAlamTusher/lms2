<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

  public function AllCourse(){
    $id = Auth::user()->id;
    $course = Course::where('instructor_id',$id)->orderBy('id','desc')->get();

    return view('instructor.courses.all_course',compact('course'));

  }//End method
  public function AddCourse(){
    $category = Category::latest()->get();
    return view('instructor.courses.add_course',compact('category'));

  }//End method

}
