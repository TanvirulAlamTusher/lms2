@extends('instructor.instructor_dashboard')
@section('instructor')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Instructor Edit Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">

                <form action="{{ route('instructor.update.coupon') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="coupon_id" value="{{ $coupon->id }}" id="">
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Name</label>
                        <input type="text" name="coupon_name" value="{{ $coupon->coupon_name }}" class="form-control" id="input1"
                            placeholder="Coupon Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Discount(%)</label>
                        <input type="number" name="coupon_discount" value="{{ $coupon->coupon_discount }}" class="form-control" id="input1"
                            placeholder="Coupon Discount">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Select Course</label>
                       <select class="form-select mb-3" aria-label="Select Your Course" name="course_id" id="">
                        <option  value="" selected="">--- Select Course ---</option>
                        @foreach ($courses as $course)
                        <option value="{{ $course->id}}" {{ $course->id == $coupon->course_id ? 'selected' : '' }} >{{ $course->course_name }}</option>


                        @endforeach

                       </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Validity</label>
                        <input type="date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $coupon->coupon_validity }}" name="coupon_validity" class="form-control" id="input1"
                            placeholder="Coupon Validity">
                    </div>


                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    coupon_name: {
                        required: true,
                    },
                    coupon_discount: {
                        required: true,
                    },
                    coupon_validity: {
                        required: true,
                    },

                },
                messages: {
                    coupon_name: {
                        required: 'Coupon Name!!',
                    },
                    coupon_discount: {
                        required: 'Discount required!!',
                    },
                    coupon_validity: {
                        required: 'Validity required!!',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
