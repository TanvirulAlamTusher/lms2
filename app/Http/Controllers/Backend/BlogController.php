<?php

namespace App\Http\Controllers\Backend;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function AllBlogCategory(){
       $category = BlogCategory::latest()->get();
       return view('admin.backend.blogcategory.blog_category',compact('category'));
    }//End method

    public function StoreBlogCategory(Request $request){
      BlogCategory::insert([
           'category_name' => $request->category_name,
           'category_slug' => strtolower(str_replace(' ','-',$request->category_name))
      ]);
      $notifaction = array('message' => 'Blog Category Inserted successfully',
      'alert_type' => 'success');

  return redirect()->back()->with($notifaction);
    }//End method

    public function EditBlogCategory($id){
        $categories = BlogCategory::find($id);
        return response()->json($categories);
    }
}
