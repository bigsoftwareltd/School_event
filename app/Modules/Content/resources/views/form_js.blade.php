@section('script-resource')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script src="{{asset('admin/js/content_form.js')}}"></script>
@include('vendor.sweetalert2.sweetalert2_js')
@include('vendor.datatable.datatable_js')
@include('vendor.datepicker.datepicker_js')
@endsection

