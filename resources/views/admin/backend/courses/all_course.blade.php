@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .large-checkbox{
        transform: scale(1.5);
    }
</style>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Courses</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl no.</th>
                            <th>Course Image</th>
                            <th>Course Name</th>
                            <th>Instructor</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($course as $key=> $item)
                        <tr>

                            <td>{{ $key+1}}</td>
                            <td> <img src="{{ asset($item->course_image )}}" alt="Image" style="width: 70px; heigh: 40px"></td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item['user']['name'] }}</td>
                            <td>{{ $item['category']['category_name'] }}</td>

                            <td>{{ $item->selling_price }}</td>
                            <td>     <a href="{{ route('admin.course.details',$item->id) }}" class="btn btn-info px-5" id=""><i class="lni lni-eye" ></i></a></td>


                           <td>
                            <div class="form-check-success form-check form-switch">
                                <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-course-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}  >
                                <label class="form-check-label" for="flexSwitchCheckCheckedDanger"></label>
                            </div>
                           </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function(){
        $('.status-toggle').on('change', function(){
            var courseId = $(this).data('course-id');
            var isChecked = $(this).is(':checked');

            // sent an ajax request to update the status
           $.ajax({
             url: "{{ route('update.course.status') }}",
             method: "POST",
             data: {
                course_id: courseId,
                is_checked: isChecked ? 1 : 0,
                _token: "{{ csrf_token() }}",
             },
             success: function(respons){
                toastr.success(respons.message);
             },
             error: function(respons){
                toastr.success(respons.message);
             }
           });
        });
    });
</script>
@endsection
