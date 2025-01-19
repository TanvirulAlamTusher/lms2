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
                    <li class="breadcrumb-item active" aria-current="page">Edit Blog Post</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body p-4">

            <form action="{{ route('update.blog.post')}}" method="post" id="myForm" class="row g-3" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="id" value="{{ $post->id }}">
                <div class="form-group col-md-6">

                    <label for="input1" class="form-label">Edit Blog Category</label>

                  <select name="blogcat_id" class="form-select mb-3" aria-label="Default select example">
                    <option selected="" value="">Open this select menu</option>

                    @foreach ($blogcat as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $post->blogcat_id ? 'selected' : '' }} > {{ $cat->category_name }}</option>
                    @endforeach

                  </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="input1" class="form-label">Edit Post Title</label>
                    <input type="text" name="post_title" class="form-control" id="input1" value="{{ $post->post_title }}">
                </div>

                <div class="form-group col-md-12">
                    <label for="input1" class="form-label">Edit Post</label>
                    <textarea class="form-control" id="myeditorinstance" name="long_descp" value=" "
                        rows="5">{!! $post->long_descp !!}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label for="input1" class="form-label">Edit Post Tag</label>
                    <input type="text" name="post_tags" class="form-control" data-role="tagsinput" value="{{ $post->post_tags }}">

                </div>



                        <div class="form-group col-md-6 text-secondary">
                            <label for="formFile" class="form-label">Change Post Image</label>
                            {{-- <input id="image" type="file" name="photo" class="form-control"/> --}}
                            <input oninput="showImage.src=window.URL.createObjectURL(this.files[0])"
                            name="post_image" type="file" class="form-control" id="image">
                        </div>

                 <div class="col-md-6">

                        <img id="showImage"
                            src="{{ asset($post->post_image) }}"
                            alt="post_image" class=" p-1 bg-primary" width="100">


                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Post Blog</button>

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
                blogcat_id: {
                    required : true,
                },
                post_title: {
                    required : true,
                },
                long_descp: {
                    required : true,
                },


            },
            messages :{
                blogcat_id: {
                    required : 'Category Required!!',
                },
                post_title: {
                    required : 'Title Required!!',
                },
                long_descp: {
                    required : 'Post Required!!',
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
