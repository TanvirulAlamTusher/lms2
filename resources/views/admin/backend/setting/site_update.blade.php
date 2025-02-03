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
                        <li class="breadcrumb-item active" aria-current="page">Site Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Site Setting</h5>

                <form action="{{ route('update.site') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $site->id }}" name="id">

                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Phone</label>
                        <input type="number" value="{{ $site->phone }}" name="phone"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Email</label>
                        <input type="email" value="{{ $site->email }}" name="email"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Address</label>
                        <input type="text" value="{{ $site->address }}" name="address"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Facebook Id</label>
                        <input type="text" value="{{ $site->facebook }}" name="facebook"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Twitter Id</label>
                        <input type="text" value="{{ $site->twitter }}" name="twitter"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Copyright</label>
                        <input type="text" value="{{ $site->copyright }}" name="copyright"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-6 text-secondary">
                        <label for="formFile" class="form-label">Logo</label>
                        {{-- <input id="image" type="file" name="photo" class="form-control"/> --}}
                        <input oninput="showImage.src=window.URL.createObjectURL(this.files[0])"
                      value="{{ $site->logo }}"  name="logo" type="file" class="form-control" id="logo">
                    </div>

             <div class="col-md-6">

                    <img id="showImage"
                        src="{{ asset($site->logo) }}"
                        alt="logo" class=" p-1 bg-primary" width="140">


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
                    phone: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    facebook: {
                        required: true,
                    },
                    twitter: {
                        required: true,
                    },



                },
                messages: {
                    phone: {
                        required: 'phone required',
                    },
                    email: {
                        required: 'email required',
                    },

                    address: {
                        required: 'address required',
                    },

                    facebook: {
                        required: 'facebook ID required',
                    },

                    twitter: {
                        required: 'twitter ID required',
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
