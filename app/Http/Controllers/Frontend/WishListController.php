<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function AddToWishlist(Request $request, $course_id){

        if(Auth::check()){
            $exitsts = WishList::where('user_id', Auth::id())
            ->where('course_id', $course_id)->first();

            if(!$exitsts){

                WishList::insert([
                    'user_id' => Auth::id(),
                    'course_id' => $course_id

                ]);
                return response()->json(['success' => 'Wishlist added successfully']);

            } else {
                return response()->json(['error' => 'This Course has already been added']);
            }

        } else{
            return response()->json(['error' => 'Login Your Account']);
        }

    }//END FUNCTION

    public function AllWishlist(){
       return view('frontend.wishlist.all_wishlist');
    }//END FUNCTION

    public function GetWishlistCourse(){
        $wishlist = WishList::with('course')->where('user_id', Auth::id())->latest()->get();
        $wishlist_count = $wishlist->count();
        return response()->json(['wishlist' => $wishlist,'wishlist_count' => $wishlist_count]);
    }//END FUNCTION

    public function RemoveWishlistCourse($id){
      WishList::where('user_id', Auth::id())->where('id', $id)->delete();

      return response()->json(['success' => 'Remove Successfully']);
    }//END FUNCTION
}
