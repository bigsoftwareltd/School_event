@extends('admin.master')

@section('header-resource')
    @include('vendor.datatable.datatable_css')
    @include('vendor.datepicker.datepicker_css')
    @include('Event::form_css')
@endsection
@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Gallery</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection


@section('content')
    <section class="content">
        <div class="container-fluid">

            @include('message.message')

            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h5 class="card-title">Add Event Gallery</h5>
                        </div>

                        <form method="POST" action="{{ route('save_gallery') }}" enctype="multipart/form-data">
                            @csrf

                            @include('Event::form')
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="fa-pull-left">
                                <h5 class="card-title">
                                    <i class="fas fa-list"></i> Gallery Info
                                </h5>
                            </div>
{{--                            @if(in_array(Auth::user()->user_type, ['101']))--}}

{{--                            @endif--}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="list" class="table dt-responsive table-bordered table-striped nowrap">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Image</th>
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
@endsection
@include('Event::form_js')
@section('script')

    @include('vendor.datatable.datatable_js')
    @include('vendor.datepicker.datepicker_js')

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <script>
        $(function () {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: '{{url("event/get-gallery")}}',
                    method: 'post',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'event_name', name: 'event_name'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection
