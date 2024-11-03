<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {

        $course = Course::find($id);

        // Check if the course is already in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });

        if ($cartItem->isNotEmpty()) {
            return response()->json(['error' => 'Course is already in your cart']);
        }

        // Check if the course has any discounts
        if ($course->discount_price == null) {
            Cart::add([
                'id' => $id,
                'name' => $request->course_name,
                'qty' => 1,
                'price' => $course->selling_price,
                'weight' => 1,
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                    'size' => 'large']]);

        } else {
            Cart::add([
                'id' => $id,
                'name' => $request->course_name,
                'qty' => 1,
                'price' => $course->discount_price,
                'weight' => 1,
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                    'size' => 'large']]);

        }

        return response()->json(['success' => 'Successfully Added on Your Cart']);

    } // End Method

    public function CartData(){
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
        'total' => $cartsTotal,
        'Qty' => $cartsQty]);

    }//end Method
    public function  AddMiniCart(){
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
        'total' => $cartsTotal,
        'Qty' => $cartsQty]);

    }//end Method
    public function RemoveMiniCart($id){
      Cart::remove($id);

      return response()->json(['success' => 'Course remove from cart']);

    }//end Method

    public function MyCart(){
       return view('frontend.mycart.view_mycart');
    }//end Method

    public function  GetCartCourse(){
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
        'total' => $cartsTotal,
        'Qty' => $cartsQty]);

    }//end Method

    public function CouponApply(Request $request){
        
    }


}
