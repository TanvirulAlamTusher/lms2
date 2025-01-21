<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function AllBlogCategory()
    {
        $category = BlogCategory::latest()->get();
        return view('admin.backend.blogcategory.blog_category', compact('category'));
    } //End method

    public function StoreBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);
        $notifaction = ['message' => 'Blog Category Inserted successfully',
            'alert_type'              => 'success'];

        return redirect()->back()->with($notifaction);
    } //End method

    public function EditBlogCategory($id)
    {
        $categories = BlogCategory::find($id);
        return response()->json($categories);
    } //ENd method

    public function UpdateBlogCategory(Request $request)
    {
        $cat_id = $request->category_id;
        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);
        $notifaction = ['message' => 'Blog Category Updated successfully',
            'alert_type'              => 'success'];

        return redirect()->back()->with($notifaction);
    } //End method

    public function DeleteBlogCategory($id)
    {
        BlogCategory::find($id)->delete();

        $notifaction = ['message' => 'Blog Category Delete successfully',
            'alert_type'              => 'success'];

        return redirect()->back()->with($notifaction);

    } //end method

    //************************************************************************************************
    //   BlogPostMethod

    public function BlogPost()
    {
        $post = BlogPost::latest()->get();
        return view('admin.backend.post.all_post', compact('post'));

    } //end method

    public function AddBlogPost()
    {
        $blogcat = BlogCategory::latest()->get();
        return view('admin.backend.post.add_post', compact('blogcat'));

    } //end method

    public function StoreBlogPost(Request $request)
    {

        $image    = $request->file('post_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 247)->save('upload/post/' . $name_gen);
        $save_url = 'upload/post/' . $name_gen;

        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'post_title' => $request->post_title,
            'post_slug'  => strtolower(str_replace(' ', '-', $request->post_title)),
            'post_image' => $save_url,
            'long_descp' => $request->long_descp,
            'post_tags'  => $request->post_tags,

        ]);

        $notifaction = ['message' => 'Blog Post Inserted successfully',
            'alert_type'              => 'success'];

        return redirect()->route('blog.post')->with($notifaction);
    } //end function

    public function EditBlogPost($id)
    {

        $post    = BlogPost::find($id);
        $blogcat = BlogCategory::latest()->get();
        return view('admin.backend.post.edit_post', compact('post', 'blogcat'));
    } //End function

    public function UpdateBlogPost(Request $request)
    {
        $post_id = $request->id;

        if ($request->file('post_image')) {
            //update with image
            $image    = $request->file('post_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(370, 247)->save('upload/post/' . $name_gen);
            $save_url = 'upload/post/' . $name_gen;

            BlogPost::find($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'post_title' => $request->post_title,
                'post_slug'  => strtolower(str_replace(' ', '-', $request->post_title)),
                'post_image' => $save_url,
                'long_descp' => $request->long_descp,
                'post_tags'  => $request->post_tags,

            ]);

            $notifaction = ['message' => 'Blog Post Inserted successfully',
                'alert_type'              => 'success'];

            return redirect()->route('blog.post')->with($notifaction);
        } else {
            //update with out image
            BlogPost::find($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'post_title' => $request->post_title,
                'post_slug'  => strtolower(str_replace(' ', '-', $request->post_title)),
                'long_descp' => $request->long_descp,
                'post_tags'  => $request->post_tags,
            ]);

            $notifaction = ['message' => 'Blog Updated without image successfully',
                'alert_type'              => 'success'];

            return redirect()->route('blog.post')->with($notifaction);

        } //end else

    } //End function

    public function DeleteBlogPost($id){
        $post = BlogPost::find($id);
        $img = $post->post_image;

        unlink($img);

        BlogPost::find($id)->delete();

        $notifaction = array('message' => 'Post Delete successfully',
            'alert_type' => 'success');

        return redirect()->back()->with($notifaction);
    }//End function

    public function BlogDetails($slug){
        $blog = BlogPost::where('post_slug',$slug)->first();
        $tags = $blog->post_tags;
        $tags_all = explode(',',$tags);
        $bcategory = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_details',compact('blog','tags_all','bcategory','post'));
    }//End function

    public function BlogCatList($id){
      $blog = BlogPost::where('blogcat_id',$id)->get();
      $blog_cat_name = BlogCategory::where('id',$id)->first();
      $bcategory = BlogCategory::latest()->get();
      $post = BlogPost::latest()->limit(3)->get();

      return view('frontend.blog.blog_cat_list',compact('blog','blog_cat_name','bcategory','post'));
    }//End function
}
