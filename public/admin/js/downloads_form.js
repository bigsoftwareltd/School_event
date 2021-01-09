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
function clientsubmit(){


    // $('.alert').setTimeout(function() {
    // }, 1000);

    $("#frmCheckout").validate({
        rules: {
            document_name: {
                required: true,
                minlength: 2
            },
            file:{
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
            document_name: {
                required: "Please enter your Name",
                minlength: "Document Name requires at least 2 characters"
            },
            file: {
                required: "File/documents cannot be empty",
            },

        },
    });
}

function editdownloads(id)
{
    var APP_URL = $('meta[name="_base_url"]').attr('content');
    $.ajax({
        url: APP_URL + '/event/edit-downloads',
        method: "get",
        dataType: "json",
        data: {id:id},
        success: function (data) {
            $("#document_name").val(data.document_name);
            $("#date").val(data.date);
            $("#document_id").val(data.id);
            $(".mb-1.first").empty();
            var str = data.file.split('/').pop();
            // var fileNameIndex = str.lastIndexOf("/") + 1;
            // var filename = str.substr(fileNameIndex);
            $(".mb-1.first").append("<i class='fa fa-file-archive-o fa-4x'></i>"+str);

        }
    })
}
function fileUpload(input) {

    // var img_preview_id = input.id + '_preview';
    // console.log(img_preview_id);
    if (input.files && input.files[0]) {
        var file = input.files[0];
        //image type validation
        var mime_type = input.files[0].type;
        if (!(mime_type == 'application/pdf' || mime_type == 'application/vnd.ms-excel' || mime_type == 'application/msword' || mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || mime_type == 'application/vnd.ms-powerpoint' || mime_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || mime_type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Invalid file format! Only document types are allowed.',
                icon: 'warning'
            })
            return false;
        }
        //image size validation
        var max_size = .5;
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

        // var reader = new FileReader();
        // reader.fileName = file.name;
        // reader.onload = function (e) {
        //     // $('#' + "show_photo").attr('src', e.target.result);
        //     // $('#' + img_preview_id).attr('src', e.target.result);
           $(".mb-1.first").empty();
            $(".mb-1.first").append("<i class='fa fa-file-archive-o fa-4x'></i>"+file.name);
            // console.log(e.target.fileName);
        // }
        //
        // reader.readAsText(file.name); // convert to base64 string
    }
}
function deletedownloads(id)
{
    var APP_URL = $('meta[name="_base_url"]').attr('content');
    var message = confirm("Are you sure you want to Delete this Downloads??");
    if(message == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: APP_URL + '/event/delete-downloads',
            method: "post",
            dataType: "json",
            data: {id: id},
            success: function (data) {
                console.log(data);
                location.reload(true);

            }
        })
    }
}
