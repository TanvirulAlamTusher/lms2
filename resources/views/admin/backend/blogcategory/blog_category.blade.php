@extends('admin.admin_dashboard')
@section('admin')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Blog Category</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Blog Category</button>


                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl no.</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>


                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($category as $key => $item)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->category_slug }}</td>

                                    <td>

                                        <button type="button" class="btn btn-info px-5" data-bs-toggle="modal" data-bs-target="#categoryEdit" id="{{ $item->id }}" onclick="categoryEdit(this.id)">
                                            Edit</button>

                                        <a href="{{ route('delete.blog.category', $item->id) }}" class="btn btn-danger px-5"
                                            id="delete">Delete</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="" action="{{ route('blog.category.store') }}" method="POST" id="myForm">
                        @csrf
                        <div class="form-group">
                            <label for="input1" class="form-label">Blog Category Name</label>
                            <input type="text" name="category_name" class="form-control" id="input1"
                                placeholder="Category Name">
                        </div>

                </div>
                <div class="modal-footer">

                    <button id="submit" type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

      <!--Edit Modal -->
      <div class="modal fade" id="categoryEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="" action="{{ route('blog.category.update') }}" method="POST" id="Form">
                        @csrf
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="form-group">
                            <label for="input1" class="form-label">Blog Category Name</label>
                            <input type="text" id="category_name" name="category_name" class="form-control"
                                placeholder="Category Name">
                        </div>

                </div>
                <div class="modal-footer">

                    <button  type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function categoryEdit(id){
            $.ajax({
                type: 'GET',
                url: '/edit/blog/category/'+id,
                dataType: 'json',

                success: function(data){
                    // console.log(data);
                    $('#category_name').val(data.category_name);
                    $('#category_id').val(data.id);

                }
            })
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Disable the submit button initially
            $('#submit').prop('disabled', true);

            // Enable/disable the submit button dynamically based on input
            $('#input1').on('input', function () {
                const isValid = $(this).val().trim() !== '';
                $( $('#submit')).prop('disabled', !isValid);
            });

            // Apply jQuery Validation rules
            $('#myForm').validate({
                rules: {
                    category_name: {
                        required: true,
                    },
                },
                messages: {
                    category_name: {
                        required: 'Please enter a category name.',
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                // Prevent default submission behavior if validation fails
                submitHandler: function (form) {
                    form.submit();
                }
            });

            // Prevent submission manually as a final safeguard
            $('#myForm').on('submit', function (e) {
                const categoryName = $('#input1').val().trim();
                if (categoryName === '') {
                    e.preventDefault(); // Stop the form from submitting
                    alert('Category Name cannot be empty!');
                }
            });
        });
    </script>


@endsection
