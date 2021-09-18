@extends('admin.layouts._main')

@section('title', 'POS | Edit Business')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->

        <!-- Main content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Business</h3>
                                </div>
                                @if(count($errors) > 0 )
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="p-0 m-0" style="list-style: none;">
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{route("update-business", ["id" => $business->id])}}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="text" class="form-control" value="{{$business->name}}"
                                                   name="name" placeholder="Enter name">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <textarea type="text" class="form-control" value=""
                                                      name="address" placeholder="Enter address">{{$business->address}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phone</label>
                                            <input type="text" class="form-control" value="{{$business->phone}}"
                                                   name="phone" placeholder="Enter phone">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="text" class="form-control" value="{{$business->email}}"
                                                   name="email" placeholder="Enter email">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Website</label>
                                            <input type="text" class="form-control" value="{{$business->website}}"
                                                   name="website" placeholder="Enter website">
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->

                        </div>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
