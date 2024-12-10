 {{-- start Wishlist add option --}}

 <script type="text/javascript">
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     })

     function addToWishlist(course_id) {
         $.ajax({
             type: "POST",
             dataType: 'json',
             url: "/add-to-wishlist/" + course_id,

             success: function(data) {

                 // Start Message

                 const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 6000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message
             }
         })

     }
 </script>

 {{-- start load Wishlist data --}}

 <script type="text/javascript">
     function wishlist() {
         $.ajax({
             type: "GET",
             dataType: 'json',
             url: "/get/wishlist/course/",

             success: function(response) {
                 $('#wishlistCount').text(response.wishlist_count)
                 let rows = ""
                 $.each(response.wishlist, function(key, value) {
                     rows += `
                  <div class="col-lg-4 responsive-column-half">
            <div class="card card-item">
                <div class="card-image">
                    <a href="/course/details/${value.course.id}/${value.course.course_name_slug}" class="d-block">
                        <img class="card-img-top" src="/${value.course.course_image}" alt="Card image cap">
                    </a>

                </div><!-- end card-image -->
                <div class="card-body">
                    <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">${value.course.label}</h6>
                    <h5 class="card-title"><a href="/course/details/${value.course.id}/${value.course.course_name_slug}">${value.course.course_name}</a></h5>


                    <div class="d-flex justify-content-between align-items-center">
                        ${value.course.discount_price == null
                        ? ` <p class="card-price text-black font-weight-bold">$ ${value.course.selling_price}</p>`
                    :`
                          <p class="card-price text-black font-weight-bold">$ ${value.course.discount_price}<span class="before-price font-weight-medium">$ ${value.course.selling_price}</span></p>`
                    }

                        <div class="icon-element icon-element-sm shadow-sm cursor-pointer" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist" id ="${value.id}" onclick = "wishlistRemove(this.id)"  ><i class="la la-heart"></i></div>
                    </div>
                </div>
            </div>
        </div> `

                 });
                 $('#wishlist').html(rows);


             }
         })
     }


     wishlist()
     /// end load Wishlist data ///

     // start remove wishlist //

     function wishlistRemove(id) {
         $.ajax({
             type: "GET",
             dataType: 'json',
             url: "/wishlist/remove/" + id,

             success: function(data) {
                 wishlist()
                 // Start Message

                 const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message

             }
         })
     }

     // end remove wishlist //
 </script>

 {{-- start Add to cart --}}
 <script type="text/javascript">
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     })

     function addToCart(course_id, course_name, instructor_id, slug) {
         $.ajax({
             type: "POST",
             dataType: 'json',
             data: {
                 _token: '{{ csrf_token() }}',
                 course_name: course_name,
                 course_name_slug: slug,
                 instructor: instructor_id

             },
             url: "/cart/data/store/" + course_id,

             success: function(data) {
                 // Start Message
                 miniCart();
                 const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message

             }
         })

     }
 </script>
 {{-- end Add to cart --}}
 {{-- START Mini cart --}}
 <script type="text/javascript">
     function miniCart() {
         $.ajax({
             type: 'GET',
             url: '/course/mini/cart/',
             dataType: 'json',

             success: function(response) {
                 var miniCart = "";

                 $.each(response.cart, function(key, value) {
                     miniCart += `
                        <li class="media media-card">
                            <a href="/course/details/${value.id}/${value.options.slug}" class="media-img">
                                <img src="/${value.options.image}" alt="Cart image">
                            </a>
                            <div class="media-body">
                                <h5><a href="/course/details/${value.id}/${value.options.slug}">${value.name}</a></h5>
                                <span class="d-block fs-14">$${value.price}</span>
                                <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="la la-times"></i></a>
                            </div>
                        </li>
                    `;
                 });

                 $('#minicart').html(miniCart);
                 $('.product-count').text(response.Qty); // Update the cart quantity
                 $('#total_amount').text(response.total);
             }
         });
     }
     miniCart();

     function miniCartRemove(rowId) {
         $.ajax({
             type: 'GET',
             url: '/minicart/remove/' + rowId,
             dataType: 'json',
             success: function(data) {
                 // Start Message
                 miniCart();
                 cart();
                 couponCalculation();

                 const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message


             }

         });
     }
     //End
     //Remove course from minicart
 </script>
 {{-- END Mini cart --}}


 {{-- Start MyCart --}}
 <script type="text/javascript">
     function cart() {
         $.ajax({
             type: 'GET',
             url: '/get-cart-courses',
             dataType: 'json',
             success: function(response) {

                 $('span[id="cartSubTotal"]').text(response.total)
                 var rows = ""

                 $.each(response.cart, function(key, value) {
                     rows += `
                <tr>
                    <th scope="row">
                        <div class="media media-card">
                            <a href="/course/details/${value.id}/${value.options.slug}" class="media-img mr-0">
                                <img src="/${value.options.image}" alt="Cart image">
                            </a>
                        </div>
                    </th>
                    <td>
                        <a href="/course/details/${value.id}/${value.options.slug}"
                         class="text-black font-weight-semi-bold">${value.name}</a>

                    </td>
                    <td>
                        <ul class="generic-list-item font-weight-semi-bold">

                            <li class="text-black lh-18">$${value.price}</li>

                        </ul>
                    </td>

                    <td>
                        <button type="button"  id="${value.rowId}" onclick="miniCartRemove(this.id)" class="icon-element icon-element-xs shadow-sm border-0" data-toggle="tooltip" data-placement="top" title="Remove">
                            <i class="la la-times"></i>
                        </button>
                    </td>
                </tr>
               `
                 });
                 $('#cartPage').html(rows);

             }
         })
     }
     cart();
 </script>
 {{-- END MyCart --}}


 {{-- Apply Coupon Start --}}

 <script type="text/javascript">
     function applyCoupon() {
         var coupon_name = $('#coupon_code').val();

         $.ajax({
             type: "POST",
             dataType: "JSON",
             data: {
                 coupon_name: coupon_name
             },
             url: "/coupon-apply",

             success: function(data) {
                 if (data.validity === true) {
                     $('#couponField').hide();
                 }
                 couponCalculation();
                 // Start Message
                 const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message

             }
         })
     }



     /// Start Coupon Calculation Method
     function couponCalculation() {
         $.ajax({
             type: 'GET',
             url: "/coupon-calculation",
             dataType: 'json',

             success: function(data) {

                 if (data.total) {
                     $('#couponCalField').html(
                         `
                  <h3 class="fs-18 font-weight-bold pb-3">Cart Totals</h3>
                    <div class="divider"><span></span></div>
                    <ul class="generic-list-item pb-4">
                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Subtotal: $</span>
                            <span>${data.total}</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Total: $</span>
                             <span>${data.total}</span>
                        </li>
                    </ul>
                        `
                     )
                 }else{
                    $('#couponCalField').html(
                         `
                  <h3 class="fs-18 font-weight-bold pb-3">Cart Totals</h3>
                    <div class="divider"><span></span></div>
                    <ul class="generic-list-item pb-4">
                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Subtotal:</span>
                            <span>${data.subtotal}$</span>
                        </li>
                         <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Coupon Name: </span>
                            <span>${data.coupon_name} <button type="button"  onclick="couponRemove()" class="icon-element icon-element-xs shadow-sm border-0" data-toggle="tooltip" data-placement="top" >
                            <i class="la la-times"></i>
                        </button> </span>
                        </li>
                         <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Discount Amount:</span>
                            <span>${data.discount_amount}$</span>

                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                            <span class="text-black">Grand Total:</span>
                             <span>${data.total_amount}$</span>
                        </li>
                    </ul>
                        `
                     )

                 }

             }
         })
     } /// End Coupon Calculation Method
     couponCalculation();
 </script>
 {{-- Apply Coupon End --}}

  {{-- Apply Instructor Coupon Start --}}

  <script type="text/javascript">
    function applyInstructorCoupon() {
        var coupon_name = $('#coupon_code').val();
        var course_id = $('#course_id').val();
        var instructor_id = $('#instructor_id').val();

        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: {
                coupon_name: coupon_name,
                course_id: course_id,
                instructor_id: instructor_id,
            },
            url: "/instructor-coupon-apply",

            success: function(data) {
                if (data.validity === true) {
                    $('#couponField').hide();
                }
                couponCalculation();
                // Start Message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    })

                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }

                // End Message

            }
        })
    }



    /// Start Coupon Calculation Method
    function couponCalculation() {
        $.ajax({
            type: 'GET',
            url: "/coupon-calculation",
            dataType: 'json',

            success: function(data) {

                if (data.total) {
                    $('#couponCalField').html(
                        `
                 <h3 class="fs-18 font-weight-bold pb-3">Cart Totals</h3>
                   <div class="divider"><span></span></div>
                   <ul class="generic-list-item pb-4">
                       <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Subtotal: $</span>
                           <span>${data.total}</span>
                       </li>
                       <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Total: $</span>
                            <span>${data.total}</span>
                       </li>
                   </ul>
                       `
                    )
                }else{
                   $('#couponCalField').html(
                        `
                 <h3 class="fs-18 font-weight-bold pb-3">Cart Totals</h3>
                   <div class="divider"><span></span></div>
                   <ul class="generic-list-item pb-4">
                       <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Subtotal:</span>
                           <span>${data.subtotal}$</span>
                       </li>
                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Coupon Name: </span>
                           <span>${data.coupon_name} <button type="button"  onclick="couponRemove()" class="icon-element icon-element-xs shadow-sm border-0" data-toggle="tooltip" data-placement="top" >
                           <i class="la la-times"></i>
                       </button> </span>
                       </li>
                        <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Discount Amount:</span>
                           <span>${data.discount_amount}$</span>

                       <li class="d-flex align-items-center justify-content-between font-weight-semi-bold">
                           <span class="text-black">Grand Total:</span>
                            <span>${data.total_amount}$</span>
                       </li>
                   </ul>
                       `
                    )

                }

            }
        })
    } /// End Coupon Calculation Method
    couponCalculation();
</script>
{{-- Apply Instructor Coupon End --}}



  {{-- Remove Coupon Start --}}
 <script type="text/javascript">
   function couponRemove(){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '/coupon-remove',

        success: function(data){


            $('#couponField').show();

            couponCalculation();
              // Start Message
              const Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     icon: 'success',
                     showConfirmButton: false,
                     timer: 1000
                 })
                 if ($.isEmptyObject(data.error)) {

                     Toast.fire({
                         type: 'success',
                         icon: 'success',
                         title: data.success,
                     })

                 } else {

                     Toast.fire({
                         type: 'error',
                         icon: 'error',
                         title: data.error,
                     })
                 }

                 // End Message

        }
    })

   }

 </script>
  {{-- Remove Coupon End --}}

{{-- Start Buy Now --}}
 <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function buyCourse(course_id, course_name, instructor_id, slug) {
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                course_name: course_name,
                course_name_slug: slug,
                instructor: instructor_id

            },
            url: "/buy/data/store/" + course_id,

            success: function(data) {
                // Start Message
                miniCart();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                })
                if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                        type: 'success',
                        icon: 'success',
                        title: data.success,
                    });
                    //Rediract to the checkout page
                    window.location.href = '/checkout';

                } else {

                    Toast.fire({
                        type: 'error',
                        icon: 'error',
                        title: data.error,
                    })
                }

                // End Message

            }
        })

    }
</script>
{{-- end Buy Now --}}

