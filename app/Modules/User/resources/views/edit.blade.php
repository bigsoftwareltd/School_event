@extends('admin.master')
@include('User::form_css')
@section('breadcumb')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h4 class="m-0 text-dark">User</h4>
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
                                    <h5 class="card-title">Edit User</h5>
                                </div>

                                <form method="POST" action="{{route('user_update')}}"  id="frmCheckout" enctype="multipart/form-data" role="form">
                                    @csrf
                                    <input type="hidden" value="{{ \App\Libraries\Encryption::encodeId($user->id) }}" name="user_id">
                                    @include('User::form')
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <div class="clearfix" style="margin-bottom: 20px">
            </div>
@endsection
@include('User::form_js')
