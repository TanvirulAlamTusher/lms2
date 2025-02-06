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
                    <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('store.admin')}}" method="post" id="myForm" class="row g-3" >
                @csrf
                <div class="row">


                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin User Name</label>
                            <input type="text" name="username" class="form-control" id="input2" placeholder="Admin User Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin Name*</label>
                            <input type="text" name="name" class="form-control" id="input2" placeholder="Admin Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin Email*</label>
                            <input type="text" name="email" class="form-control" id="input2" placeholder="Admin User Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin Phone*</label>
                            <input type="text" name="phone" class="form-control" id="input2" placeholder="Admin User Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin Address</label>
                            <input type="text" name="address" class="form-control" id="input2" placeholder="Admin User Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input2" class="form-label">Admin Password*</label>
                            <input type="password" name="password" class="form-control" id="input2" placeholder="Admin User Name">
                        </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Role Name*</label>
                        <select name="roles" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>select menu</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>

                            @endforeach




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
                email: {
                    required : true,
                },
                phone: {
                    required : true,
                },
                password: {
                    required : true,
                },
                roles: {
                    required : true,
                },




            },
            messages :{
                name: {
                    required : 'Name Required!!',
                },
                email: {
                    required : 'Email Required!!',
                },
                phone: {
                    required : 'Phone Required!!',
                },
                password: {
                    required : 'Email Required!!',
                },
                roles: {
                    required : 'Roles Required!!',
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
