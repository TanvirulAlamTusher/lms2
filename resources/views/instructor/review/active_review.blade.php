@extends('instructor.instructor_dashboard')
@section('instructor')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .large-checkbox {
            transform: scale(1.5);
        }
    </style>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Active Review</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

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
                                <th>Course Name</th>
                                <th>User Name</th>
                                <th>Comment</th>
                                <th>Rating</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($review as $key => $item)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['course']['course_name'] }}</td>
                                    <td>{{ $item['user']['name'] }}</td>

                                    <td>{{ $item->comment }}</td>
                                    <td>
                                        @if ($item->rating == null)
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                        @elseif ($item->rating == 1)
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                        @elseif ($item->rating == 2)
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                        @elseif ($item->rating == 3)
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                        @elseif ($item->rating == 4)
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-secondary"></i>
                                        @elseif ($item->rating == 5)
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                            <i class="bx bxs-star text-warning"></i>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
   
@endsection
