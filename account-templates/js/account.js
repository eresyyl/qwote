$(document).ready(function() {


  // copy token link to clipboard
  var clipboard = new Clipboard('.copyTokenLink');
  clipboard.on('success', function(e) {
      console.log(e);
  });
  clipboard.on('error', function(e) {
      console.log(e);
  });

        $('#photo').change(function(){ UploadAvatar('photo'); });
        $('#logo').change(function(){ UploadAvatar('logo'); });

	$("#save_account").click(function(){
                $("#save_account").html("<i class='fa fa-refresh fa-spin'></i>");
		var save_account = "/wp-content/themes/go/account-templates/ajax/save_account.php";
   	 	jQuery.ajax({
      	  	url: save_account,
       	 	type: "POST",
		dataType: "html",
		data: jQuery("#account").serialize(),
       	 	success: function(response) {
			        $("#account_response").html("");
       		 	        $("#account_response").html(response);
   		 	},
    		error: function(response) {
			        $("#save_account").html("Save");
    			        $("#account_response").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});

	$("#save_invoice").click(function(){
                $("#save_invoice").html("<i class='fa fa-refresh fa-spin'></i>");
		var save_invoice = "/wp-content/themes/go/account-templates/ajax/save_invoice.php";
   	 	jQuery.ajax({
      	  	url: save_invoice,
       	 	type: "POST",
		dataType: "html",
		data: jQuery("#invoice_form").serialize(),
       	 	success: function(response) {
			        $("#invoice_response").html("");
       		 	        $("#invoice_response").html(response);
   		 	},
    		error: function(response) {
			        $("#save_invoice").html("Save");
    			        $("#invoice_response").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});

	$("#save_security").click(function(){
                $("#save_security").html("<i class='fa fa-refresh fa-spin'></i>");
		var save_security = "/wp-content/themes/go/account-templates/ajax/save_security.php";
   	 	jQuery.ajax({
      	  	url: save_security,
       	 	type: "POST",
		dataType: "html",
		data: jQuery("#security_form").serialize(),
       	 	success: function(response) {
			        $("#security_response").html("");
       		 	        $("#security_response").html(response);
   		 	},
    		error: function(response) {
			        $("#save_security").html("Save");
    			        $("#security_response").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});

    $('.populateLabour').click(function(){
        var rows = $('.selectionLabourContainer').attr('data-rows');
        var newRow = rows+1;
        $clone = $('.selectionLabourRow').clone().removeClass('selectionLabourRow').addClass(newRow);
        $clone.find('.deleteteLabour').css('display', 'inline-block');
        $('.selectionLabourContainer').append($clone);
        $('.selectionLabourContainer').attr('data-rows',newRow);
        $('.' + newRow).find('input:text').val('');
        $('.' + newRow).find('input[type="number"]').val('0.00');
    });
    $('.selectionLabourContainer').on('click','.deleteteLabour',function(){
        $(this).closest('.row').remove();
    });

    $('.populateMaterial').click(function(){
        var rows = $('.selectionMaterialContainer').attr('data-rows');
        var newRow = rows+1;
        $clone = $('.selectionMaterialRow').clone().removeClass('selectionMaterialRow').addClass(newRow);
        $clone.find('.deleteteMaterial').css('display', 'inline-block');
        $('.selectionMaterialContainer').append($clone);
        $('.selectionMaterialContainer').attr('data-rows',newRow);
        $('.' + newRow).find('input:text').val('');
        $('.' + newRow).find('input[type="number"]').val('0.00');
    });
    $('.selectionMaterialContainer').on('click','.deleteteMaterial',function(){
        $(this).closest('.row').remove();
    });

    // uploading functions
    $('.addSelectionPhotos').click(function(){
            //$( "#attach" ).val('');
            $( "#attach" ).trigger( "click" );
    });
    $('.selectionPhotos').on('click','.uploaded_image_section i',function(){
            $(this).closest('.uploaded_image_section').remove();
    });
    $('#attach').change(function(){
            $('.addSelectionPhotos i').removeClass('icon').removeClass('wb-upload').addClass('fa').addClass('fa-spin').addClass('fa-refresh');
            //$('.attach').html('<i style="margin-top:20px" class="fa fa-spin fa-refresh"></i>&nbsp;&nbsp;uploading...');
            var $input = $("#attach");
            var fd = new FormData;

            fd.append('img', $input.prop('files')[0]);
            fd.append('location', location);

            $.ajax({
                url: '/wp-content/themes/go/account-templates/ajax/selectionAttachment.php',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                   $('.addSelectionPhotos i').removeClass('fa').removeClass('fa-spin').removeClass('fa-refresh').addClass('icon').addClass('wb-upload');
                       $('#attach').val('');
                       $('.selectionPhotos').append(data);
                }
            });
    });

    $('.addSelection').click(function(){
        addSelection();
    });

});
function showLoader() {
	$('.quoteOverlay').fadeIn();
}
function removeLoader() {
	$('.quoteOverlay').fadeOut();
}
function addSelection() {
	$('#addSelectionResponse').html('');
	var url = "/wp-content/themes/go/account-templates/ajax/addSelection.php",
        sTitle = $('input[name=selectionTitle]').val(),
        sPrice = $('input[name=selectionPrice]').val(),
        sCat = $('select[name=selectionCategory]').val(),
        sLevel = $('select[name=selectionLevel]').val(),
        sBrand = $('select[name=selectionBrand]').val(),
        sSupplier = $('select[name=selectionSupplier').val();

        var sCat = [];
        $('#selectionCat :selected').each(function(i, selected){
          sCat[i] = $(selected).val();
        });

        console.log(sCat);

	      var sLevel = [];
        $('#selectionLevel :selected').each(function(i, selected){
          sLevel[i] = $(selected).val();
        });

        console.log(sLevel);

	      var sSupplier = [];
        $('#selectionSupplier :selected').each(function(i, selected){
          sSupplier[i] = $(selected).val();
        });

        console.log(sSupplier);

        if(sTitle.length < 1) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to enter Selection Title!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }
        if(sPrice.length < 1) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to enter Selection Price!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }
        if (typeof sCat !== 'undefined' && sCat.length > 0) {
            $('#addSelectionResponse').html('');
        }
        else {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Selection Category!</div>");
            return false;
        }
        /*
        if(sCat == null) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Selection Category!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }
        */
        if(sLevel == null) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Selection Level!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }
        if(sBrand == null) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Selection Brand!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }

        var sTtitleLabourValidation = true;
        $( "input.selectionLabourTitle" ).each(function() {
            var sTitleLabour = $(this).val();
            if(sTitleLabour.length < 1) {
                sTtitleLabourValidation = false;
            }
        });
        if(sTtitleLabourValidation == false) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All Labour titles need to be set!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }

        var sPriceLabourValidation = true;
        $( "input.selectionLabourPrice" ).each(function() {
            var sPriceLabour = $(this).val();
            if(sPriceLabour.length < 1) {
                sPriceLabourValidation = false;
            }
        });
        if(sPriceLabourValidation == false) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All Labour prices need to be set!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }

        var sTtitleMaterialValidation = true;
        $( "input.selectionMaterialTitle" ).each(function() {
            var sTitleMaterial = $(this).val();
            if(sTitleMaterial.length < 1) {
                sTtitleMaterialValidation = false;
            }
        });
        if(sTtitleMaterialValidation == false) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All Material titles need to be set!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }

        var sPriceMaterialValidation = true;
        $( "input.selectionMaterialPrice" ).each(function() {
            var sPriceMaterial = $(this).val();
            if(sPriceMaterial.length < 1) {
                sPriceMaterialValidation = false;
            }
        });
        if(sPriceMaterialValidation == false) {
            $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All Material prices need to be set!</div>");
            return false;
        }
        else {
            $('#addSelectionResponse').html('');
        }

        showLoader();
	 	jQuery.ajax({
  	  	url: url,
   	 	type: "POST",
		dataType: 'json',
		cache: false,
        //dataType: 'html',
		data: $('#addSelections').serialize(),
   	 	success: function(response) {
                if(response.status == 'fail') {
		        	$('#addSelectionResponse').html(response.message);
                    removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }
		 	},
		error: function(response) {
		        $('#addSelectionResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
	  		}
	  	});
}

function UploadAvatar(location) {
    var $input = $("#" + location);
    var fd = new FormData;

    fd.append('img', $input.prop('files')[0]);
	fd.append('location', location);

    $.ajax({
        url: '/wp-content/themes/go/account-templates/ajax/image_upload.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
		   $("#" + location).hide();
           $('.' + location).html(data);
        }
    });
}
