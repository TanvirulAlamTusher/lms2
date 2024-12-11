<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //
    public function StoreReview(Request $request){
       $user_id = Auth::user()->id;
    }//End method
}
