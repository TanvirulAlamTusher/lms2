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
                        <li class="breadcrumb-item active" aria-current="page">Smtp Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Smtp Setting</h5>

                <form action="{{ route('update.smtp') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $smtp->id }}" name="id">

                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Mailer</label>
                        <input type="text" value="{{ $smtp->mailer }}" name="mailer"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Host</label>
                        <input type="text" value="{{ $smtp->host }}" name="host"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Port</label>
                        <input type="text" value="{{ $smtp->port }}" name="port"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Username</label>
                        <input type="text" value="{{ $smtp->username }}" name="username"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Password</label>
                        <input type="text" value="{{ $smtp->password }}" name="password"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">Encryption</label>
                        <input type="text" value="{{ $smtp->encryption }}" name="encryption"
                            class="form-control" id="input1" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="input1" class="form-label">From address</label>
                        <input type="text" value="{{ $smtp->from_address }}" name="from_address"
                            class="form-control" id="input1" >
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
                    mailer: {
                        required: true,
                    },
                    host: {
                        required: true,
                    },
                    port: {
                        required: true,
                    },
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    encryption: {
                        required: true,
                    },
                    from_address: {
                        required: true,
                    },


                },
                messages: {
                    mailer: {
                        required: 'mailer required',
                    },
                    host: {
                        required: 'host required',
                    },

                    port: {
                        required: 'port required',
                    },

                    username: {
                        required: 'username required',
                    },

                    password: {
                        required: 'password required',
                    },

                    encryption: {
                        required: 'encryption required',
                    },

                    from_address: {
                        required: 'From Address required',
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
