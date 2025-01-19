<?php

namespace App\Http\Controllers\Backend;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;

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
    }//ENd method

    public function UpdateBlogCategory(Request $request){
        $cat_id = $request->category_id;
        BlogCategory::find($cat_id)->update([
             'category_name' => $request->category_name,
             'category_slug' => strtolower(str_replace(' ','-',$request->category_name))
        ]);
        $notifaction = array('message' => 'Blog Category Updated successfully',
        'alert_type' => 'success');

    return redirect()->back()->with($notifaction);
      }//End method

      public function DeleteBlogCategory($id){
        BlogCategory::find($id)->delete();

        $notifaction = array('message' => 'Blog Category Delete successfully',
        'alert_type' => 'success');

    return redirect()->back()->with($notifaction);

      }//end method

      //************************************************************************************************
    //   BlogPostMethod

    public function BlogPost(){
       $post = BlogPost::latest()->get();
       return view('admin.backend.post.all_post',compact('post'));

    }//end method

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();
        return view('admin.backend.post.add_post',compact('blogcat'));

    }//end method
}
