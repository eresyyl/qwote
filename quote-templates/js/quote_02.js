$(document).ready(function() {
	
	$(".goto_2_step").click(function(){
		$(".goto_2_step").html("<i class='fa fa-refresh fa-spin'></i>");
		var step2_load = "/wp-content/themes/go/quote-templates/ajax/load_quote_templates.php";
   	 	jQuery.ajax({
      	  	url: step2_load,
       	 	type: "POST",
      	  	dataType: "html",
			data: jQuery("#quote_form_1").serialize(),
       	 	success: function(response) {
				$("#step1_response").html("");
       		 	$("#step1_response").html(response);
   		 	},
    		error: function(response) {
				$(".goto_2_step").html("Next Step");
    			$("#step1_response").html("<div class=\'text-center\'>Something went wrong!</div>");
    		}
  	  	});
	});
	
});

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

function MakeQuote(checking){	
		$('#goto_quotesave_step').html('<i class=\'fa fa-refresh fa-spin\'></i>');
		$('.last_prev').hide();
		
		var first_name = $('input[name=first_name]').val();
		var last_name = $('input[name=last_name]').val();
		var email = $('input[name=email]').val();
		var phone = $('input[name=phone]').val();
		if(first_name.length === 0 && checking === 1) {
			$('input[name=first_name]').addClass('error');
			$('#goto_quotesave_step').html('Finish Quote');
			$('.last_prev').show();
			return;
		}
		else {
			$('input[name=first_name]').removeClass('error');
		}
		if(last_name.length === 0 && checking === 1) {
			$('input[name=last_name]').addClass('error');
			$('#goto_quotesave_step').html('Finish Quote');
			$('.last_prev').show();
			return;
		}
		else {
			$('input[name=last_name]').removeClass('error');
		}
		
		if(email.length === 0 && checking === 1) {
			$('input[name=email]').addClass('error');
			$('#goto_quotesave_step').html('Finish Quote');
			$('.last_prev').show();
			return;
		}
		else if( !validateEmail(email) && checking === 1 ) {
			$('input[name=email]').addClass('error');
			$('#goto_quotesave_step').html('Finish Quote');
			$('.last_prev').show();
			return;
		}
		else {
			$('input[name=email]').removeClass('error');
		}
		if(phone.length === 0 && checking === 1) {
			$('input[name=phone]').addClass('error');
			$('#goto_quotesave_step').html('Finish Quote');
			$('.last_prev').show();
			return;
		}
		else {
			$('input[name=phone]').removeClass('error');
		}
							
		var quote = '/wp-content/themes/go/quote-templates/ajax/quote_proceed.php';
   	 	jQuery.ajax({
      	  	url: quote,
       	 	type: 'POST',
      	  	dataType: 'html',
			data: jQuery('#quote_form').serialize(),
       	 	success: function(response) {
				$('#quote_proceed_response').html('');
       		 	$('#quote_proceed_response').html(response);
	 		    $('#quote_proceed_response').find('script').each(function(i) {
					eval($(this).text());
				});
   		 	},
    		error: function(response) {
				$('#goto_quotesave_step').html('Finish Quote');
				$('.last_prev').show();
    			$('#quote_proceed_response').html('<div class=\'text-center\'>Something went wrong!</div>');
    		}
  	  	});
}

function UploadImage(location) {
    var $input = $("#" + location);
    var fd = new FormData;

    fd.append('img', $input.prop('files')[0]);
	fd.append('location', location);

    $.ajax({
        url: '/wp-content/themes/go/quote-templates/ajax/image_upload.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
           $("#" + location).show();
           $(".photos_upload_" + location + " .uploading").hide();
           $('.' + location).append(data);
        }
    });
}