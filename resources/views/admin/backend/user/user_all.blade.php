@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All User</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl no.</th>

                            <th>User Image</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>User Phone</th>
                            <th>User Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user as $key=> $item)
                        <tr>

                            <td>{{ $key+1}}</td>

                           <td> <img src="{{
                            !empty($item->photo)
                            ? ($item->role == 'instructor'
                                ? url('upload/instructor_images/' . $item->photo)
                                : url('upload/user_images/' . $item->photo))
                            : url('upload/no_image.jpg')
                        }}" alt="Img" style="width: 70px; height:40px;"></td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->name }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection
