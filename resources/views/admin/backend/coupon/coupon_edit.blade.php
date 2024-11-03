@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Vertical Form</h5>
                <form action="{{ route('admin.update.coupon') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $coupon->id }}">
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Name</label>
                        <input type="text" name="coupon_name" class="form-control" id="input1" value="{{ $coupon->coupon_name }}"
                            placeholder="Category Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Discount</label>
                        <input type="number" name="coupon_discount" class="form-control" id="input1"  value="{{ $coupon->coupon_discount }}"
                            placeholder="Category Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Validity</label>
                        <input type="date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"  name="coupon_validity" class="form-control" id="input1" value="{{ $coupon->coupon_validity }}"
                            placeholder="Category Name">
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
