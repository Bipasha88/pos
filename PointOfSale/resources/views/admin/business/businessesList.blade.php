@extends('admin.layouts._main')

@section('title', 'POS | Businesses List')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Businesses List</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="businesses" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <th>Owner</th>
                                            <th>Archive</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure, you want to delete?</p>
                        <form id="deleteForm" action="" method="post" asp-antiforgery="true">
                            @csrf
                            <input type="hidden" id="deleteId" value="" name="id" />
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="deleteButton" class="btn btn-danger">Yes, Delete!</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->

@endsection

@section('styles')
    <link rel="stylesheet" href="/adminTheme/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endsection

@section('scripts')
    <script src="/adminTheme/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/adminTheme/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var business_id = button.data('businessid')
            var modal = $(this)
            modal.find('.modal-body #business_id').val(business_id);
        })

        function archive(id){
            let url = "{{route('archive-business',':id')}}";
            url = url.replace(':id', id);
            document.location.href=url;
        }

        function unarchive(id){
            console.log(id);
            let url = "{{route('unarchive-business',':id')}}";
            url = url.replace(':id', id);
            document.location.href=url;
        }

        $(function () {
            $('#businesses').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/admin/getBusinessData",
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": 6,
                        "render": function (data, type, row) {
                            var value = data.split(" ");
                            if(value[0] == "archived")
                                return `<input type="checkbox" class="btn btn-warning btn-sm" onclick="unarchive(${value[1]})"  checked>`;
                            else
                                return `<input type="checkbox" class="btn btn-warning btn-sm" onclick="archive(${value[1]})">`;
                        }
                    },
                    {
                        "orderable": false,
                        "targets": 7,
                        "render": function (data, type, row) {
                            return `<button type="submit" class="btn btn-info btn-sm" onclick="window.location.href='/admin/editbusiness/${data}'" value='${data}'>
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </button>
                                    <button type="submit" class="btn btn-danger btn-sm show-bs-modal" href="#" data-id='${data}' value='${data}'>
                                        <i class="fas fa-trash">
                                        </i>
                                    </button>`;
                        }
                    }
                ]
            });

            $('#businesses').on('click', '.show-bs-modal', function (event) {
                var id = $(this).data("id");
                var modal = $("#modal-default");
                modal.find('.modal-body p').text('Are you sure you want to delete this record?')
                $("#deleteId").val(id);
                $("#deleteForm").attr("action", "{{route('delete-business')}}")
                modal.modal('show');
            });

            $("#deleteButton").click(function () {
                $("#deleteForm").submit();
            });
        });
    </script>
@endsection
