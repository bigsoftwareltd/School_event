$(function (){
    jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
            else if (regexp.global)
                regexp.lastIndex = 0;
            return this.optional(element) || regexp.test(value);
        },
    );
    $("#phone").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            alert("Phone number allows digit only");
            return false;
        }
    });
})
function contentsubmit(){
    // $('.alert').setTimeout(function() {
    // }, 1000);

    $("#frmCheckout").validate({
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            edito1: {
                required: true,
            },
            image:{
                required:true,
            },
        },
        onfocusout: function(element) {
            this.element(element); // triggers validation
        },
        onkeyup: function(element, event) {
            this.element(element); // triggers validation
        },
        messages: {
            title: {
                required: "Title Cannot be Empty",
                minlength: "Title requires at least 3 characters"
            },
            editor1: {
                required: "Description Cannot be Empty",
            },
            image: {
                required: "Please upload image",
            },

        },
        submitHandler: function (form) {
            // var data = $("#frmCheckout").serialize();
            var APP_URL = $('meta[name="_base_url"]').attr('content');
            var formData= new FormData($("#frmCheckout")[0]);
            var imgFile = $("#image")[0]; // change your delector here
            formData.append("image", imgFile.files[0]);
            // var title = $("#title").val();
            // var description = $("#description").val();
            // var image = $("#image").val();
            // var content_id = $("#content_id").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: APP_URL + '/content/save-content',
                method: "post",
                // dataType: "json",
                // data: {title:title,description:description,image:image,content_id:content_id},
                data: formData,
                success: function (data) {
                    if(data){
                        // $("#list").append(data);
                        $output = "";
                        var length = data.length;
                        for (var i = 0; i < length; i++) {
                            $output += '<tr>';
                            $output += '<td class="text-center">' + i + '</td>';
                            $output += '<td class="text-center">' + data[i].title + '</td>';
                            // console.log(response[i].date);
                            $output += '<td class="text-center">' + data[i].description + '</td>';
                            $output += '<td class="text-center">' + data[i].image + '</td>';
                            $output += '<td class="text-center"> <a class="btn btn-primary btn-xs" id="'+data[i].id+'" onclick="editcontent(this.id)"> <i class="fa fa-edit"></i> Edit </a> <a class="btn btn-danger btn-xs" name="'+data[i].id+'" onclick="deleteclient(this.name,event)" style="color: #ffffff"> <i class="fas fa-remove"></i> Delete </a></td>';
                            $output += '</tr>';
                        }
                        $("#frmCheckout").trigger("reset");
                        $("#content_list_data").empty();
                        $("#content_list_data").append($output);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            })
        }

    });
}
function imageUpload(input) {

    var img_preview_id = input.id + '_preview';
    if (input.files && input.files[0]) {
        //image type validation
        var mime_type = input.files[0].type;
        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Invalid image format! Only JPEG or JPG or PNG image types are allowed.',
                icon: 'warning'
            })
            return false;
        }
        //image size validation
        var max_size = .3;
        var file_size = parseFloat(input.files[0].size / (1024 * 1024)).toFixed(1); // MB calculation
        if (file_size > max_size) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Max file size ' + max_size + ' MB. You have uploaded ' + file_size + ' MB.',
                icon: 'warning'
            })
            return false;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + "show_photo").attr('src', e.target.result);
            $('#' + img_preview_id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
