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
}
