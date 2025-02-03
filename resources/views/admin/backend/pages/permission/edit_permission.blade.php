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
                    <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('update.permission')}}" method="post" id="myForm" class="row g-3" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" value="{{ $permission->id }}" name="id">
                <div class="row">

                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Edit Permission Name</label>
                            <input type="text" name="name" class="form-control" id="input2" value="{{ $permission->name }}">
                        </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Edit Group Name</label>
                        <select name="group_name" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>select menu</option>

                            <option value="Category" {{ $permission->group_name == 'Category' ? 'selected' : ''}} >Category</option>
                            <option value="Instructor"{{ $permission->group_name == 'Instructor' ? 'selected' : ''}} >Instructor</option>
                            <option value="Coupon"{{ $permission->group_name == 'Coupon' ? 'selected' : ''}}>Coupon</option>
                            <option value="Setting"{{ $permission->group_name == 'Coupon' ? 'selected' : ''}}>Setting</option>
                            <option value="Orders"{{ $permission->group_name == 'Orders' ? 'selected' : ''}}>Orders</option>
                            <option value="Report"{{ $permission->group_name == 'Report' ? 'selected' : ''}}>Report</option>
                            <option value="Review"{{ $permission->group_name == 'Review' ? 'selected' : ''}}>Review</option>
                            <option value="All User"{{ $permission->group_name == 'All User' ? 'selected' : ''}}>All User</option>
                            <option value="Blog"{{ $permission->group_name == 'Blog' ? 'selected' : ''}}>Blog</option>
                            <option value="Role and Permission"{{ $permission->group_name == 'Role and Permission' ? 'selected' : ''}}>Role and Permission</option>

                        </select>
                    </div>
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                group_name: {
                    required : true,
                },



            },
            messages :{
                name: {
                    required : 'Name Required!!',
                },
                group_name: {
                    required : 'Group name Required!!',
                },




            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>



@endsection
