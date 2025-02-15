@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Order Details</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <h5>Payment Details</h5>
                <div class="row">
                    <div class="col-lg-6">

                        <div class="card">


                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong>{{ $payment->name }}</strong>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> {{ $payment->phone }}</strong>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> {{ $payment->address }}</strong>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Order Date:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> {{ $payment->order_date }}</strong>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="card">

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Payment Type:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> {{ $payment->payment_type }}</strong>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Invoice Number:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> {{ $payment->invoice_no }}</strong>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Amount:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <strong> ${{ $payment->total_amount }}</strong>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Payment Status:</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if ($payment->status == 'pending')
                                            <a href="{{  route('pending-confirm',$payment->id)}}" class="btn btn-block btn-success" id="confirm">Confirm Order</a>
                                        @elseif ($payment->status == 'confirm')
                                            <a href="" class="btn btn-block btn-success">Confirm Order</a>
                                        @endif

                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="main-body">
                <h5>Order Details</h5>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="flex-grow-1 ms-3">
                                        <div class="table-responsive">
                                            <table class="table" style="font-weight:600;">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-1">
                                                            <label>Image</label>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <label>Course Name</label>
                                                        </td>

                                                        <td class="col-md-2">
                                                            <label>Category</label>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <label>Instructor</label>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <label>Price</label>
                                                        </td>


                                                    </tr>
    @php
        $totalPrice = 0;
    @endphp
                                                    @foreach ($orderItem as $item)
                                                    <tr>
                                                        <td class="col-md-1">
                                                            <label><img src="{{ asset($item->course->course_image)}}" alt="course_image" style="width: 100px; hight: 100px;"></label>
                                                        </td>

                                                        <td class="col-md-2">
                                                            <label>{{$item->course_title}}</label>
                                                        </td>

                                                        <td class="col-md-2">
                                                            <label>{{$item->course->category->category_name}}</label>
                                                        </td>
                                                        instructor
                                                        <td class="col-md-2">
                                                            <label>{{$item->instructor->name}}</label>
                                                        </td>

                                                        <td class="col-md-2">
                                                            <label>${{$item->price}}</label>
                                                        </td>


                                                    </tr>

                                                    @php
                                                    $totalPrice += $item->price;
                                                  @endphp
                                                    @endforeach

                                                    @php
                                                        $discount_amount = round($totalPrice-$payment->total_amount) ;
                                                    @endphp



                                                  <tr>
                                                    <td colspan="4"></td>
                                                    <td class="col-md-3"> <strong>Total Price: ${{$totalPrice}}</strong></td>

                                                  </tr>
                                                  <tr>
                                                    <td colspan="4"></td>
                                                    <td class="col-md-3"> <strong>Discount: ${{ $discount_amount }}</strong></td>

                                                  </tr>
                                                  <tr>
                                                    <td colspan="4"></td>
                                                    <td class="col-md-3"> <strong>Payment Amount: ${{ $payment->total_amount }}</strong></td>

                                                  </tr>




                                                </tbody>

                                            </table>

                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>



                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
