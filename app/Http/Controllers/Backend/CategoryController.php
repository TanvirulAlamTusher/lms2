<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{

    public function AllCategory(){
      $category = Category::latest()->get();
      return view('admin.backend.category.all_category', compact('category'));
    }
    // End Method

    public function AddCategory(){
        return view('admin.backend.category.add_category');

    }// End Method

    public function StoreCategory(Request $request){

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370, 246)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'image' => $save_url
        ]);

        $notifaction = array('message' => 'Category Inserted successfully',
        'alert_type' => 'success');

    return redirect()->route('all.category')->with($notifaction);

    }// End Method

    public function EditCategory($id){
         $category = Category::find($id);
         return view('admin.backend.category.edit_category',compact('category'));

    }// End Method
    public function UpdateCategory(Request $request){

        $cat_id = $request->id;

        if($request->file('image')) {
            //update with image
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(370, 246)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
                'image' => $save_url
            ]);

            $notifaction = array('message' => 'Category Updated with image successfully',
            'alert_type' => 'success');

        return redirect()->route('all.category')->with($notifaction);
        } else {
             //update with out image
             Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),

            ]);

            $notifaction = array('message' => 'Category Updated without image successfully',
            'alert_type' => 'success');

        return redirect()->route('all.category')->with($notifaction);

        }//end else
 }// End Method

   public function DeleteCategory($id){
        $item = Category::find($id);
        $img = $item->image;

        unlink($img);

        Category::find($id)->delete();

        $notifaction = array('message' => 'Category Delete successfully',
        'alert_type' => 'success');

    return redirect()->back()->with($notifaction);
   }

   ///////// All SubCategory Methods  ////////////

   public function AllSubCategory(){
    $subcategory = SubCategory::latest()->get();
    return view('admin.backend.subcategory.all_subcategory', compact('subcategory'));
   }// End Method

   public function AddSubCategory(){
    $category = Category::latest()->get();
    return view('admin.backend.subcategory.add_subcategory', compact('category'));

}// End Method

public function StoreSubCategory(Request $request){


    SubCategory::insert([
        'category_id' => $request->category_id,
        'subcategory_name' => $request->subcategory_name,
        'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),

    ]);

    $notifaction = array('message' => 'Sub Category Inserted successfully',
    'alert_type' => 'success');

return redirect()->route('all.subcategory')->with($notifaction);

}// End Method

public function EditSubCategory($id){
    $subcategory = SubCategory::find($id);
    $category = Category::latest()->get();
    return view('admin.backend.subcategory.edit_subcategory',compact('subcategory','category'));
}
public function UpdateSubCategory(Request $request){
     $subCat_id = $request->id;
    SubCategory::find( $subCat_id)->update([
        'category_id' => $request->category_id,
        'subcategory_name' => $request->subcategory_name,
        'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),

    ]);

    $notifaction = array('message' => 'Sub Category Updated',
    'alert_type' => 'success');

return redirect()->route('all.subcategory')->with($notifaction);


}

public function DeleteSubCategory($id){

    SubCategory::find($id)->delete();

    $notifaction = array('message' => 'Sub Category Delete successfully',
    'alert_type' => 'success');

return redirect()->back()->with($notifaction);
}

}
