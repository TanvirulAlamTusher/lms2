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
                        <li class="breadcrumb-item active" aria-current="page">Report</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4">
                        <form action="{{ route('search.by.date') }}" method="post" id="myForm" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Search by Date</label>
                                <input type="date" name="date" class="form-control" id="input1" placeholder="Date">
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('search.by.month') }}" method="post" id="myForm" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Search by Month</label>
                                <select name="month" class="form-select " aria-label="Default select example">
                                    <option selected="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Search by Year</label>
                                <select name="year_name" class="form-select " aria-label="Default select example">
                                    <option selected="">Select Year</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>

                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('search.by.year') }}" method="post" id="myForm" class="row g-3"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Search by Year</label>
                                <select name="year_name" class="form-select " aria-label="Default select example">
                                    <option selected="">Select Year</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>

                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>

                                </div>
                            </div>
                        </form>




                    </div>

                </div>
                <!--end row-->



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
