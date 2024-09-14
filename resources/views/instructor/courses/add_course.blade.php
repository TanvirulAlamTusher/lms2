@extends('instructor.instructor_dashboard')
@section('instructor')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Course</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">

            <form action="{{ route('store.category')}}" method="post" id="myForm" class="row g-3" enctype="multipart/form-data" >
                @csrf
                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Name</label>
                    <input type="text" name="course_name" class="form-control"  placeholder="Course Name">
                </div>

                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Title</label>
                    <input type="text" name="course_title" class="form-control"  placeholder="Course Title">
                </div>




                        <div class="form-group col-md-6 text-secondary">
                            <label for="formFile" class="form-label">Course Image</label>
                            {{-- <input id="image" type="file" name="photo" class="form-control"/> --}}
                            <input oninput="showImage.src=window.URL.createObjectURL(this.files[0])"
                            name="course_image" type="file" class="form-control" id="image">
                        </div>

                 <div class="col-md-6">

                        <img id="showImage"
                            src="{{ url('upload/no_image.jpg') }}"
                            alt="Category img" class="rounded-circle p-1 bg-primary" width="100">

                </div>


                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Intro Video</label>
                    <input type="file" name="video" class="form-control" placeholder="Course Name"
                    accept="video/mp4, video/webm">
                </div>
                <div class="form-group col-md-6"></div>
                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Category</label>
                    <select name="category_id" class="form-select mb-3" aria-label="Default select example">
                        <option selected="" disabled>Selece Category</option>
                        @foreach ($category as $cat)

                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                        @endforeach


                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Sub Category</label>
                    <select name="subcategory_id" class="form-select mb-3" aria-label="Default select example">
                        <option selected="" disabled>Selece sub Category</option>



                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Certificate Available</label>
                    <select name="certificate" class="form-select mb-3" aria-label="Default select example">
                        <option selected=""disabled>Yes/No</option>
                         <option value="Yes">Yes</option>
                         <option value="No">No</option>


                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Course Price</label>
                    <input type="text" name="selling_price" class="form-control"  placeholder="Course Price">
                </div>


                <div class="form-group col-md-4">
                    <label for="input1" class="form-label">Discount Price</label>
                    <input type="text" name="discount_price" class="form-control"  placeholder="Discount Price">
                </div>

                <div class="form-group col-md-4">
                    <label for="input1" class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control"  placeholder="Duration">
                </div>

                <div class="form-group col-md-4">
                    <label for="input1" class="form-label">Resources</label>
                    <input type="text" name="resources" class="form-control"  placeholder="Resources">
                </div>

                <div class="form-group col-md-12">
                    <label for="input1" class="form-label">Course Prerequisites</label>
                    <textarea class="form-control" id="input11"  name="prerequisites" placeholder="Prerequisites ..." rows="3"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="input1" class="form-label">Course Description</label>
                    <textarea class="form-control" id="myeditorinstance"  name="description" placeholder="Description....." rows="3"></textarea>
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
                category_name: {
                    required : true,
                },
                image: {
                    required : true,
                },

            },
            messages :{
                category_name: {
                    required : 'Please Enter category Name',
                },
                image: {
                    required : 'Please Insert Image',
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
