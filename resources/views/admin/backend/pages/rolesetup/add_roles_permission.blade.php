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
                        <li class="breadcrumb-item active" aria-current="page">Add Role In Permission</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('store.permission') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">


                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Roles Name</label>
                            <select name="group_name" class="form-select mb-3" aria-label="Default select example">
                                <option selected="" disabled>select roles</option>

                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach



                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Permission All</label>
                        </div>
                        <hr>

                    </div>

                    @foreach ($permission_groups as $group)
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">{{ $group->group_name }}</label>
                                </div>

                            </div>
                            <div class="col-9">
                                @php
                                    $permissions = App\Models\User::getpermissionByGroupsName($group->group_name);
                                @endphp
                                @foreach ($permissions as $permission)

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                        value="{{ $permission->id }}" id="CheckDefault{{ $permission->id }}">
                                    <label class="form-check-label"
                                        for="CheckDefault{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                                <br>

                            </div>

                        </div>
                        {{-- end row --}}
                    @endforeach






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
                    name: {
                        required: true,
                    },
                    group_name: {
                        required: true,
                    },



                },
                messages: {
                    name: {
                        required: 'Name Required!!',
                    },
                    group_name: {
                        required: 'Group name Required!!',
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
