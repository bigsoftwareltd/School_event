//preview image before upload
function imageUpload(input) {

    var img_preview_id = input.id + '_preview';
    console.log(img_preview_id);
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
function addphotorow()
{
    var result = $(".mb-1.first").html();
    var upload = '<div class="row">';
    upload += '<div class="col-md-6">';
    upload += '<div class="form-group">';
    upload += '<label for="photo" class="form-label">Photo</label>';
    upload += '<div class="input-group mb-1" >';
     upload += '<div class="custom-file">'+
       '<input type="file" value="" name="photo[]" class="form-control-file" accept="image/jpeg, image/png" onChange="imageUpload(this, "show_photo")>'+
       '<label class="custom-file-label" for="photo">Choose file</label>' +
       '</div>';
     upload += '</div>';
     upload += '</div>';
    upload += '</div>';
    upload += '</div>';
     upload += '<div class="col-md-6">';
     upload += '<div class="mb-1">';
     upload += result;
     upload += '</div>';
     upload += '</div>';
     upload += '</div>';
        $("#photo_section").append(upload)
}
