<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {

        $course = Course::find($id);
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
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

    public function CartData()
    {
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
            'total' => $cartsTotal,
            'Qty' => $cartsQty]);

    } //end Method
    public function AddMiniCart()
    {
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
            'total' => $cartsTotal,
            'Qty' => $cartsQty]);

    } //end Method
    public function RemoveMiniCart($id)
    {
        Cart::remove($id);
        if (Session::has('coupon')) {
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name', $coupon_name)->first();

            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount / 100),
            ]);

        }

        return response()->json(['success' => 'Course remove from cart']);

    } //end Method

    public function MyCart()
    {
        return view('frontend.mycart.view_mycart');
    } //end Method

    public function GetCartCourse()
    {
        $carts = Cart::content();
        $cartsTotal = Cart::total();
        $cartsQty = Cart::count();

        return response()->json(['cart' => $carts,
            'total' => $cartsTotal,
            'Qty' => $cartsQty]);

    } //end Method

    public function CouponApply(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)
            ->where('coupon_validity', '>=', Carbon::now()->format('Y-m-d'))->first();

        if ($coupon) {
            Session::put('coupon', [
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount / 100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount / 100),
            ]);
            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully',
            ));
        } else {
            return response()->json(['error' => 'Invaild Coupon']);
        }
    } //End Method

    public function CouponCalculation()
    {
        if (Session::has('coupon')) {
            return response()->json(array(
                'subtotal' => Cart::total(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        } else {
            return response()->json(array(
                'total' => Cart::total(),
            ));
        }

    } //End Method

    public function CouponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon remove successfully']);
    } //End Method

    public function CheckoutCreate()
    {
        // check if the user has already login.
        if (Auth::check()) {
            //check if the user has any course in the cart.
            if (Cart::total() > 0) {
                $carts = Cart::content();
                $cartsTotal = Cart::total();
                $cartsQty = Cart::count();
                return view('frontend.checkout.checkout_view', compact('carts', 'cartsTotal', 'cartsQty'));
            } else {
                $notifaction = array('message' => 'Add At list one course',
                    'alert_type' => 'error');

                return redirect()->to('/')->with($notifaction);
            }//end inner if

        } else {
            $notifaction = array('message' => 'Login First',
            'alert_type' => 'error');

        return redirect()->route('login')->with($notifaction);

        }
        return view('');
    } //End Method

}
