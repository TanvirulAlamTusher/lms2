@extends('instructor.instructor_dashboard')
@section('instructor')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Course Details</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset($course->course_image) }}" class="p-1 border" width="105" height="70"
                                alt="...">
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mt-0">{{ $course->course_name }}</h5>
                                <p class="mb-0">{{ $course->course_title }}</p>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Add Section</button>
                        </div>
                    </div>
                </div>

                <!--Add Section and Lecture  -->
                @foreach ($section as $key => $item)
                    <div class="container">
                        <div class="main-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body p-4 d-flex justify-content-between">
                                            <h6>{{ $item->section_title }}</h6>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-danger px-2 ms-auto">Delete
                                                    Section</button> &nbsp;
                                                <a onclick="addLectureDiv({{ $course->id }},{{ $item->id }}, 'lectureContainer{{ $key }}')"
                                                    id="addLectureBtn($key)" class="btn btn-warning">Add Lecture</a>
                                            </div>
                                        </div>

                                        <div class="courseHide" id="lectureContainer{{ $key }}">
                                            <div class="container">
                                                @foreach ($item->lectures as $lectures )


                                                <div
                                                    class="lectureDiv mb-3 d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <strong>{{ $loop->iteration }}. {{ $lectures->lecture_title }}</strong>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="{{ route('edit.lecture',['id' => $lectures->id]) }}" class="btn btn-sm btn-primary"><i class="lni lni-eraser"></i></a> &nbsp;
                                                        <a href="" class="btn btn-sm btn-danger "><i class="lni lni-trash"></i></a>
                                                    </div>


                                                </div>
                                              <hr>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>
                @endforeach
                <!--End Section and Lecture  -->

            </div>
        </div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.course.section') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $course->id }}">

                        <div class="form-group mb-3">
                            <label for="input1" class="form-label">Course Section</label>
                            <input type="text" name="section_title" class="form-control" placeholder="Section Title">
                        </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <script>
     function addLectureDiv(courseId, sectionId, containerId) {
    const lectureContainer = document.getElementById(containerId);

    // Clear existing content before adding a new lecture div
    lectureContainer.innerHTML = '';

    const newLectureDiv = document.createElement('div');
    newLectureDiv.classList.add('lectureDiv', 'mb-3');

    newLectureDiv.innerHTML = `
        <div class="container">
            <h6>Lecture Title</h6>
            <input type="text" class="form-control" placeholder="Enter Lecture Title" >
            <textarea class="form-control mt-2" placeholder="Enter Lecture Content"></textarea>
            <h6 class="mt-3">Add Video Url</h6>
            <input type="text" class="form-control" placeholder="Add url" name="url">

            <button class="btn btn-primary mt-3" onclick="saveLecture('${courseId}','${sectionId}','${containerId}')">Save Lecture</button>
            <button class="btn btn-secondary mt-3" onclick="hideLectureContainer('${containerId}')">Cancel</button>
        </div>
    `;

    lectureContainer.appendChild(newLectureDiv);
    lectureContainer.style.display = 'block';  // Ensure it's visible when adding
}



function hideLectureContainer(containerId) {
    const lectureContainer = document.getElementById(containerId);
    lectureContainer.style.display = 'none';
    location.reload();

}

    </script>

    <script>
        function saveLecture(courseId, sectionId, containerId){
             const lectureContainer = document.getElementById(containerId);
             const lectureTitle = lectureContainer.querySelector('input[type=text]').value;
             const lectureContent = lectureContainer.querySelector('textarea').value;
             const lectureUrl = lectureContainer.querySelector('input[name=url]').value

             fetch('/save-lecture', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    course_id: courseId,
                    section_id: sectionId,
                    lecture_title: lectureTitle,
                    lecture_url: lectureUrl,
                    lecture_content: lectureContent,
                })
             })

             .then(response => response.json())
             .then(data => {
               console.log(data);

               hideLectureContainer(containerId);


                    // Start Message

            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success',
                  showConfirmButton: false,
                  timer: 6000
            })
            if ($.isEmptyObject(data.error)) {

                    Toast.fire({
                    type: 'success',
                    title: data.success,
                    })

            }else{

           Toast.fire({
                    type: 'error',
                    title: data.error,
                    })
                }

              // End Message

             })
             .catch(error => {
                console.error(error);
             })

       }

    </script>
@endsection
