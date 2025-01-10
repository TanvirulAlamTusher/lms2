<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\QuestionController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishListController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth' ,'roles:user', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

    //user wishlist
    Route::controller(WishListController::class)->group(function () {
        Route::get('/user/wishlist', 'AllWishlist')->name('user.wishlist');
        Route::get('/get/wishlist/course/', 'GetWishlistCourse');
        Route::get('/wishlist/remove/{id}', 'RemoveWishlistCourse');

    }); // end user wishlist

     //Use My Course all route
     Route::controller(OrderController::class)->group(function () {
        Route::get('/my/course', 'MyCourse')->name('my.course');
        Route::get('/course/view/{course_id}', 'CourseView')->name('course.view');
        Route::post('/user/question', 'CourseView')->name('user.question');


    }); //End Use My Course all route

      //User Question all route
      Route::controller(QuestionController::class)->group(function () {
        Route::post('/user/question', 'UserQuestion')->name('user.question');


    }); //End User Question all route


});
// END AUTH MEDDLEWARE



require __DIR__ . '/auth.php';



// Admin group middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    //Category all routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

    });
    //End
    //Sub Category all routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');

    });
    //End
    //Instractor All Routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/instructor', 'AllInstructor')->name('all.instructor');
        Route::post('/update/user/status', 'UpdateUserStatus')->name('update.user.status');

    });//End

     //Admin Course All Routes
     Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/all/course', 'AdminAllCourse')->name('admin.all.course');
        Route::post('/update/course/status', 'UpdateCourseStatus')->name('update.course.status');
        Route::get('/admin/course/details/{id}', 'AdminCourseDetails')->name('admin.course.details');
        Route::get('/admin/all/coupon', 'AdminCourseDetails')->name('admin.all.coupon');


    });//End
      //Admin Coupon Routes
      Route::controller(CouponController::class)->group(function () {
        Route::get('/admin/all/coupon', 'AdminAllCoupon')->name('admin.all.coupon');
        Route::get('/admin/add/coupon', 'AdminAddCoupon')->name('admin.add.coupon');
        Route::post('/admin/store/coupon', 'AdminStoreCoupon')->name('admin.store.coupon');
        Route::get('/admin/edit/coupon/{id}', 'AdminEditCoupon')->name('admin.edit.coupon');
        Route::post('/admin/update/coupon', 'AdminUpdateCoupon')->name('admin.update.coupon');
        Route::get('/admin/delete/coupon/{id}', 'AdminDeleteCoupon')->name('admin.delete.coupon');


    });//End

       //Admin Setting Routes
       Route::controller(SettingController::class)->group(function () {
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp', 'UpdateSmtp')->name('update.smtp');
      });//End

       //Admin All Order Routes
       Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/pending/order', 'PendingOrder')->name('admin.pending.order');
        Route::get('/admin/confirm/order', 'ConfirmOrder')->name('admin.confirm.order');
        Route::get('/admin/order/details/{id}', 'OrderDetails')->name('admin.order.details');
        Route::get('/pending/confirm/{id}', 'PendingToConfirm')->name('pending-confirm');

      });//End

       //Admin Report Routes
       Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/report/view', 'ReportView')->name('report.view');
        Route::post('/admin/search/by/date', 'SearchByDate')->name('search.by.date');
        Route::post('/admin/search/by/month', 'SearchByMonth')->name('search.by.month');
        Route::post('/admin/search/by/year', 'SearchByYear')->name('search.by.year');


      });//End Admin Report Routes

      //Admin Review All Routes
      Route::controller(ReviewController::class)->group(function () {
        Route::get('/admin/pending/review', 'AdminPendingReview')->name('admin.pending.review');

      });
      //End Admin Review All Routes

});//End Admin group middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
//End

Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])->name('become.instructor');
Route::post('/instructor/register', [AdminController::class, 'InstructorRegister'])->name('instructor.register');
//End


//Instructor group middleware
Route::middleware(['auth', 'roles:instructor'])->group(function () {

    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
    Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');
    Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
    Route::post('/instructor/profile/store', [InstructorController::class, 'InstructorProfileStore'])->name('instructor.profile.store');
    Route::get('/instructor/change/password', [InstructorController::class, 'InstructorChangePassword'])->name('instructor.change.password');
    Route::post('/instructor/password/update', [InstructorController::class, 'InstructorPasswordUpdate'])->name('instructor.password.update');

    Route::controller(CourseController::class)->group(function () {
        Route::get('/all/course', 'AllCourse')->name('all.course');
        Route::get('/add/course', 'AddCourse')->name('add.course');
        Route::post('/store/course', 'StoreCourse')->name('store.course');
        Route::get('/edit/course/{id}', 'EditCourse')->name('edit.course');
        Route::post('/update/course', 'UpdateCourse')->name('update.course');
        Route::post('/update/course/image', 'UpdateCourseImage')->name('update.course.image');
        Route::post('/update/course/video', 'UpdateCourseVedio')->name('update.course.video');
        Route::post('/update/course/goal', 'UpdateCourseGoal')->name('update.course.goal');

        Route::get('/delete/course/{id}', 'DeleteCourse')->name('delete.course');

        Route::get('/subcategory/ajax/{category_id}', 'GetSubcategory');

    });
    //End

    //Course lecture and Course section All routes
    Route::controller(CourseController::class)->group(function () {
        Route::get('/add/course/lecture/{id}', 'AllCourseLecture')->name('add.course.lecture');
        Route::post('/add/course/section/', 'AdCourseSection')->name('add.course.section');
        Route::post('/delete/section/{id}', 'DeleteSection')->name('delete.section');
        Route::post('/save-lecture', 'SaveLecture')->name('save-lecture');

        Route::get('/edit/lecture/{id}', 'EditLecture')->name('edit.lecture');
        Route::post('/update/course/lecture', 'UpdateCourseLecture')->name('update.course.lecture');
        Route::get('/delete/lecture/{id}', 'DeleteLecture')->name('delete.lecture');

    });
    //End

    // Instructor Order All route
    Route::controller(OrderController::class)->group(function () {
        Route::get('/instructor/all/order', 'InstructorAllOrder')->name('instructor.all.order');
        Route::get('/instructor/order/details/{payment_id}', 'InstructorOrderDetails')->name('instructor.order.details');
        Route::get('/instructor/order/invoice/{payment_id}', 'InstructorOrderInvoice')->name('instructor.order.invoice');


    });
    //End
     // Instructor Order All route
     Route::controller(QuestionController::class)->group(function () {
        Route::get('/instructor/all/question', 'InstructorAllQuestion')->name('instructor.all.question');
        Route::get('/question/details/{id}', 'QuestionDetails')->name('question.details');
        Route::post('/instructor/reply', 'InstructorReply')->name('instructor.reply');
    });
    //End
     //Instructor Coupon Routes
     Route::controller(CouponController::class)->group(function () {
        Route::get('/instructor/all/coupon', 'InstructorAllCoupon')->name('instructor.all.coupon');
        Route::get('/instructor/add/coupon', 'InstructorAddCoupon')->name('instructor.add.coupon');
        Route::post('/instructor/store/coupon', 'InstructorStoreCoupon')->name('instructor.store.coupon');
        Route::get('/instructor/edit/coupon/{id}', 'InstructorEditCoupon')->name('instructor.edit.coupon');
        Route::post('/instructor/update/coupon', 'InstructorUpdateCoupon')->name('instructor.update.coupon');
        Route::get('/instructor/delete/coupon/{id}', 'InstructorDeleteCoupon')->name('instructor.delete.coupon');


    });//End Instructor Coupon Routes


});
//End Instructor group middleware

Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login')->middleware(RedirectIfAuthenticated::class);
//End

//// Route Accessable for All

Route::get('/course/details/{id}/{slug}', [IndexController::class, 'CourseDetails']);
Route::get('/category/{id}/{slug}', [IndexController::class, 'CategoryCourse']);
Route::get('/subcategory/{id}/{slug}', [IndexController::class, 'SubCategoryCourse']);
Route::get('/instructor/details/{id}', [IndexController::class, 'InstructorDetails'])->name('instructor.details');
Route::post('/add-to-wishlist/{course_id}', [WishListController::class, 'AddToWishlist']);
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
Route::post('/buy/data/store/{id}', [CartController::class, 'BuyToCart']);
Route::get('/cart/data/', [CartController::class, 'CartData']);

//get data from mini cart
Route::get('/course/mini/cart/', [CartController::class, 'AddMiniCart']);
//remove data from mini cart
Route::get('/minicart/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

//Cart all route
Route::controller(CartController::class)->group(function () {
    Route::get('/mycart', 'MyCart')->name('mycart');
    Route::get('/get-cart-courses', 'GetCartCourse');

});

Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::post('/instructor-coupon-apply', [CartController::class, 'InstructorCouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);
//checkout page route
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');
Route::post('/payment', [PaymentController::class, 'Payment'])->name('payment');
Route::post('/stripe_order', [PaymentController::class, 'StripeOrder'])->name('stripe_order');
//Review route

Route::post('/store/review', [ReviewController::class, 'StoreReview'])->name('store.review');


//// End Route Accessable for All
