<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Course_goal;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function CourseDetails($id, $slug)
    {
        $course = Course::find($id);
        $goals = Course_goal::where('course_id', $id)->orderBy('id', 'DESC')->get();
        $categoris = Category::latest()->get();

        $ins_id = $course->instructor_id;
        $instructorCourses = Course::where('instructor_id', $ins_id)->where('status', 1)->orderBy('id', 'DESC')->get();

        $category_id = $course->category_id;
        $relatedCourses = Course::where('category_id', $category_id)->where('id', '!=', $id)
            ->where('status', 1)->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.course.course_details', compact('course', 'goals', 'instructorCourses', 'categoris', 'relatedCourses'));

    }

    public function CategoryCourse($id, $slug)
    {
        $courses = Course::where('category_id', $id)
            ->where('status', 1)->get();
        $category = Category::where('id', $id)->first();
        $categoris = Category::latest()->get();
        return view('frontend.category.category_all', compact('courses', 'category', 'categoris'));
    }

    public function SubCategoryCourse($id, $slug)
    {
        $courses = Course::where('subcategory_id', $id)
            ->where('status', 1)->get();
        $subcategory = SubCategory::where('id', $id)->first();
        $categoris = Category::latest()->get();
        return view('frontend.category.sub_category_all', compact('courses', 'subcategory', 'categoris'));
    }

    public function InstructorDetails($id){
        $instructor = User::find($id);

        $courses = Course::where('instructor_id', $id)->where('status',1)->get();

        return view('frontend.instructor.instructor_details', compact('instructor','courses'));

    }
}
