@extends('admin.master')
@include('vendor.datatable.datatable_css')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">User</h4>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
{{--        section start here--}}
        <section class="content">
            <div class="container-fluid">

                @include('message.message')

                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="fa-pull-left">
                                    <h4 class="card-title" style="margin-bottom: 0">
                                        <i class="fas fa-list"></i> User Information
                                    </h4>
                                </div>
                                {{--                            @if(in_array(Auth::user()->user_type, ['101']))--}}
                                <div class="fa-pull-right">
                                    <a class="" href="{{ route('user_add') }}">
                                        <button class="btn btn-info" style="font-family: kalpurush"><i class="fa fa-plus"></i><b> Add User</b></button>
                                    </a>
                                </div>
                                {{--                            @endif--}}
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



{{--        section end here--}}
    </div>
@endsection
@section('script-resource')
   @include('vendor.datatable.datatable_js')
   @include('vendor.sweetalert2.sweetalert2_js')
   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
   <script>
       $(function () {
           $('#list').DataTable({
               processing: true,
               serverSide: true,
               iDisplayLength: 10,
               ajax: {
                   url: '{{url("user/get-user")}}',
                   method: 'post',
                   data: function (d) {
                       d._token = $('input[name="_token"]').val();
                   }
               },
               columns: [
                   {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                   {data: 'name', name: 'name'},
                   {data: 'username', name: 'username'},
                   {data: 'email', name: 'email'},
                   {data: 'phone', name: 'phone'},
                   {data: 'user_type', name: 'user_type'},
                   {data: 'status', name: 'status'},
                   {data: 'action', name: 'action', orderable: false, searchable: false},
               ],
               "aaSorting": []
           });
       });
       var APP_URL = {!! json_encode(url('/')) !!}
       function deleteoperator(id,e){
           e.preventDefault();
           Swal.fire({
               title: "Are you sure?",
               text: "You Want to Delete this User??",
               icon: "warning",
               showCloseButton: true,
               // showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `delete`,
               // dangerMode: true,
           }).then((result) =>
           {
               if (result.value == true) {
                   Swal.fire(
                       'Deleted!',
                       'User info has been deleted.',
                       'success'
                   )
                   $.ajax({
                       url: APP_URL + "/user/remove",
                       method: "POST",
                       dataType: "json",
                       data: {"_token": "{{ csrf_token() }}", id: id},
                       success: function (response) {
                           location.reload(true);
                       },
                   })
               }
               else {
                   swal.fire("Cancelled", "Your User is Safe :)", "error");
               }
           })
       }
   </script>
@endsection
