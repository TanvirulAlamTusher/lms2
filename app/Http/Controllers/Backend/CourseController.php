<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course_goal;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use PHPUnit\Framework\Constraint\Count;

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

  public function GetSubcategory($category_id){
   $subcat = SubCategory::where('category_id',$category_id)
   ->orderBy('subcategory_name','ASC')->get();

   return json_encode($subcat);

  }//end method

  public function StoreCourse(Request $request){
     $request->validate([
        'video' => 'required|mimes:mp4|max:10000',//10 mb

     ]);
      //upload image
      $image = $request->file('course_image');
      $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
      Image::make($image)->resize(370,246)->save('upload/course/thambnail/'.$name_gen);
      $save_url = 'upload/course/thambnail/'.$name_gen;

       //upload video
      $video = $request->file('video');
      $videoName = time().'.'. $video->getClientOriginalExtension();
      $video->move(public_path('upload/course/video/'),$videoName);
      $save_video ='upload/course/video/'.$videoName;

      $course_id = Course::insertGetId([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'instructor_id' => Auth::user()->id,

        'course_image' => $save_url,

        'course_title' => $request->course_title,
        'course_name' => $request->course_name,

        'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),

        'description' => $request->description,
        'video' =>$save_video,

        'label' => $request->label,
        'duration' => $request->duration,
        'resources' => $request->resources,
        'certificate' => $request->certificate,
        'selling_price' => $request->selling_price,
        'discount_price' => $request->discount_price,
        'prerequisites' => $request->prerequisites,

        'bestseller' => $request->bestseller,
        'featured' => $request->featured,
        'highestrated' => $request->highestrated,
        'status' => 1,
        'created_at' => Carbon::now(),
      ]);
    // Course Goal Add Form
      $goles = Count($request->course_goals);

      if($goles != NULL){
         for ($i = 0; $i < $goles ; $i++){
            $goleCount = new Course_goal();
            $goleCount->course_id =  $course_id;
            $goleCount->goal_name = $request->course_goals[$i];
            $goleCount->save();

         }
      }
      //End course goal
      $notifaction = array('message' => 'Course Inserted successfully',
      'alert_type' => 'success');

  return redirect()->route('all.course')->with($notifaction);

  }//End method

  public function EditCourse($id){

    $course = Course::find($id);
    $categories = Category::latest()->get();
    $subcategories = SubCategory::latest()->get();
    $goals = Course_goal::where('course_id',$id)->get();

    return view('instructor.courses.edit_course',compact('course',
    'categories','subcategories','goals'));

  }//End method

  public function UpdateCourse(Request $request){

     $course_id =  $request->course_id;


      Course::find($course_id)->update([
       'category_id' => $request->category_id,
       'subcategory_id' => $request->subcategory_id,

       'course_title' => $request->course_title,
       'course_name' => $request->course_name,
       'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
       'description' => $request->description,
       'label' => $request->label,
       'duration' => $request->duration,
       'resources' => $request->resources,
       'certificate' => $request->certificate,
       'selling_price' => $request->selling_price,
       'discount_price' => $request->discount_price,
       'prerequisites' => $request->prerequisites,

       'bestseller' => $request->bestseller,
       'featured' => $request->featured,
       'highestrated' => $request->highestrated,
       'updated_at' => Carbon::now(),
     ]);

     $notifaction = array('message' => 'Course Updated successfully',
     'alert_type' => 'success');

   return redirect()->route('all.course')->with($notifaction);

   }//End method

   public function UpdateCourseImage(Request $request){

    $course_id = $request->id;
    $oldImage = $request->old_img;

     //upload image
     $image = $request->file('course_image');
     $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
     Image::make($image)->resize(370,246)->save('upload/course/thambnail/'.$name_gen);
     $save_url = 'upload/course/thambnail/'.$name_gen;

     if(file_exists($oldImage)){
        unlink($oldImage);

     }

     Course::find($course_id)->update([
          'course_image' => $save_url,
          'updated_at' => Carbon::now(),
     ]);

     $notifaction = array('message' => 'Course Image Update successfully',
     'alert_type' => 'success');

   return redirect()->route('all.course')->with($notifaction);

  }//end function

  public function UpdateCourseVedio(Request $request){

    $course_id = $request->vid;
    $oldVideo = $request->old_video;

      //upload video
      $video = $request->file('video');
      $videoName = time().'.'. $video->getClientOriginalExtension();
      $video->move(public_path('upload/course/video/'),$videoName);
      $save_video ='upload/course/video/'.$videoName;

      if(file_exists( $oldVideo)){
        unlink( $oldVideo);

     }


     Course::find($course_id)->update([
          'video' =>  $save_video,
          'updated_at' => Carbon::now(),
     ]);

     $notifaction = array('message' => 'Course video Update successfully',
     'alert_type' => 'success');

   return redirect()->route('all.course')->with($notifaction);

  }//end function


  public function UpdateCourseGoal(Request $request){
    $course_id = $request->id;

    if($request->course_goals == NULL){
        return redirect()->back();
    } else{

        Course_goal::where('course_id',$course_id)->delete();

         // Course Goal Add Form
      $goles = Count($request->course_goals);


         for ($i = 0; $i < $goles ; $i++){
            $goleCount = new Course_goal();
            $goleCount->course_id =  $course_id;
            $goleCount->goal_name = $request->course_goals[$i];
            $goleCount->save();

         }//end for loop

      //End course goal


    }//end else
    $notifaction = array('message' => 'Course Goals Updated successfully',
    'alert_type' => 'success');

  return redirect()->route('all.course')->with($notifaction);

  }



}
