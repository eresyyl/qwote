function UploadImage(location) {
    var $input = $("#" + location);
    var fd = new FormData;

    fd.append('img', $input.prop('files')[0]);
	fd.append('location', location);

    $.ajax({
        url: '/wp-content/themes/go/quote-edit-templates/ajax/image_upload.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
           $("#" + location).show().val('');
           $(".photos_upload_" + location + " .uploading").hide();
           $('.' + location).append(data);
        }
    });
}