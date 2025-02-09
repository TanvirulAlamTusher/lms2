@php
    $course = App\Models\Course::where('status', 1)->where('featured', 1)
    ->orderBy('id', 'ASC')->limit(4)->get();

@endphp
<section class="course-area pb-90px">
    <div class="course-wrapper">
        <div class="container">
            <div class="section-heading text-center">
                <h5 class="ribbon ribbon-lg mb-2">Learn on your schedule</h5>
                <h2 class="section__title">Students are viewing</h2>
                <span class="section-divider"></span>
            </div><!-- end section-heading -->


            <div class="course-carousel owl-action-styled owl--action-styled mt-30px">

                @foreach ($course as $course_item)
                <div class="card card-item card-preview" data-tooltip-content="#tooltip_content_1{{ $course_item->id }}">
                    <div class="card-image">
                        <a href="{{ url('course/details/' . $course_item->id . '/' . $course_item->course_name_slug) }}" class="d-block">
                            <img class="card-img-top" src="{{ asset($course_item->course_image) }}" alt="Card image cap">
                        </a>
                        @php

                        $amount = $course_item->selling_price - $course_item->discount_price;
                        $discount = ($amount / $course_item->selling_price) * 100;
                    @endphp




                        <div class="course-badge-labels">



                                            @if ($course_item->featured == 1)
                                                <div class="course-badge ">Featured</div>

                                            @endif


                                            @if ($course_item->discount_price == null)
                                                <div class="course-badge blue">New</div>
                                            @else
                                                <div class="course-badge blue">{{ round($discount) }}%OFF</div>
                                            @endif




                                        </div>
                    </div><!-- end card-image -->
                    @php
                    $reviewcount = App\Models\Review::where('course_id', $course_item->id)
                        ->where('status', '1')
                        ->latest()
                        ->get();
                    $avgRating = App\Models\Review::where('course_id', $course_item->id)
                        ->where('status', '1')
                        ->avg('rating');
                @endphp




<div class="card-body">
    <h6 class="ribbon ribbon-blue-bg fs-14 mb-3">{{ $course_item->label }}</h6>
    <h5 class="card-title"><a
            href="{{ url('course/details/' . $course_item->id . '/' . $course_item->course_name_slug) }}">{{ $course_item->course_name }}</a>
    </h5>
    <p class="card-text"><a
            href="{{ route('instructor.details', $course_item->instructor_id) }}">{{ $course_item['user']['name'] }}</a>
    </p>
    <div class="rating-wrap d-flex align-items-center py-2">
        <div class="review-stars">
            <span class="rating-number">{{ round($avgRating, 1) }}</span>

            @if ($avgRating == 0)
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
            @elseif ($avgRating == 1 || $avgRating < 2)
                <span class="la la-star"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
            @elseif ($avgRating == 2 || $avgRating < 3)
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
            @elseif ($avgRating == 3 || $avgRating < 4)
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star-o"></span>
                <span class="la la-star-o"></span>
            @elseif ($avgRating == 4 || $avgRating < 5)
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star-o"></span>
            @elseif ($avgRating == 5)
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
                <span class="la la-star"></span>
            @endif


        </div>
        <span class="rating-total pl-1">({{ count($reviewcount) }})</span>
    </div><!-- end rating-wrap -->
    <div class="d-flex justify-content-between align-items-center">
        @if ($course_item->discount_price == null)
            <p class="card-price text-black font-weight-bold">
                ${{ $course_item->selling_price }}
            </p>
        @else
            <p class="card-price text-black font-weight-bold">
                ${{ $course_item->discount_price }} <span
                    class="before-price font-weight-medium">${{ $course_item->selling_price }}
                </span></p>
        @endif

        <div class="icon-element icon-element-sm shadow-sm cursor-pointer"
            title="Add to Wishlist" id="{{ $course_item->id }}"
            onclick="addToWishlist(this.id)"><i class="la la-heart-o"></i></div>
    </div>
</div><!-- end card-body -->
                </div><!-- end card -->

                @endforeach

            </div><!-- end tab-content -->



        </div><!-- end container -->
    </div><!-- end course-wrapper -->
</section><!-- end courses-area-two -->
