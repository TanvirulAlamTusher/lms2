<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
   public function AddToCart(Request $request, $id){

     $course = Course::find($id);

     // Check if the course is already in the cart
     $cartItem = Cart::search( function ($cartItem, $rowId) use($id){
           return $cartItem->id === $id;
     });

     if($cartItem -> isNotEmpty()) {
        return response()->json(['error' => 'Course is already in your cart']);
     }

   }// End Method
}
