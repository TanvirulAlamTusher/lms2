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
                        <li class="breadcrumb-item active" aria-current="page">Edit Lecture</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5>Edit Lecture</h5>
                <form action="{{ route('update.course.lecture') }}" method="post" id="myForm" class="row g-3"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $lecture->id }}">
                    <input type="hidden" name="course_id" value="{{ $lecture->course_id  }}">

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Lecture Title</label>
                        <input type="text" name="lecture_title" class="form-control" value="{{ $lecture->lecture_title }}" >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Video Url</label>
                        <input type="text" name="url" class="form-control"  value="{{ $lecture->url }}"  placeholder="Course Title">
                    </div>

                    <div class="form-group col-md-12">
                        <h7>Edit Content</h7>
                        <textarea class="form-control mt-2" name="lecture_content" placeholder="Enter Lecture Content">{{ $lecture->content }}</textarea>

                    </div>

                    <div class="form-group col-md-6"> </div>




                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-success px-4">Update Changes</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection
