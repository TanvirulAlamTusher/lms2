@extends('instructor.instructor_dashboard')
@section('instructor')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Question</li>
                    </ol>
                </nav>
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
                                <th>User Name</th>
                                <th>Course Name</th>
                                <th>Subject</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($questions as $key => $item)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['user']['name'] }}</td>
                                    <td>{{ $item['course']['course_name'] }}</td>
                                    <td>{{ $item->subject }}</td>

                                    <td>
                                        <a href="{{ route('instructor.order.details', $item->id) }}"
                                            class="btn btn-info" title="edit"><i class="lni lni-eye"></i></a>
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
