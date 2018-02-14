$(document).ready(function() {
	
	$('.cancel').click(function() {
		$('.cancel_quote').attr('data-quote','');
		var quote_id = $(this).attr('data-quote');
                $('.cancel_quote').attr('data-quote',quote_id);
		$("#cancel_quote_respopnse").html('');
		$(".cancel_quote").show();
		$(".cancel_quote_close").html('No, i was wrong');
	});
	
	$(".cancel_quote").click(function(){
                $("#cancel_quote_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".cancel_quote").hide();
		$(".cancel_quote_close").hide();
		var cancel_quote = "/wp-content/themes/go/projects-templates/ajax/cancel_quote.php";
		var quote_id = $(this).attr('data-quote');
   	 	jQuery.ajax({
      	  	url: cancel_quote,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id
			},
       	 	success: function(response) {
			        $("#cancel_quote_respopnse").html("");
       		 	        $("#cancel_quote_respopnse").html(response);
   		 	},
    		error: function(response) {
			        $(".cancel_quote").show();
			        $(".cancel_quote_close").show();
    			        $("#cancel_quote_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
	
	$('.approve').click(function() {
		$('.approve_quote').attr('data-quote','');
		var quote_id = $(this).attr('data-quote');
                $('.approve_quote').attr('data-quote',quote_id);
		$("#approve_quote_respopnse").html('');
		$(".approve_quote").show();
		$(".approve_quote_close").html('No, i was wrong');
	});
	
	$(".approve_quote").click(function(){
                $("#approve_quote_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".approve_quote").hide();
		$(".approve_quote_close").hide();
		var approve_quote = "/wp-content/themes/go/projects-templates/ajax/approve_quote.php";
		var quote_id = $(this).attr('data-quote');
   	 	jQuery.ajax({
      	  	url: approve_quote,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id
			},
       	 	success: function(response) {
			        $("#approve_quote_respopnse").html("");
       		 	        $("#approve_quote_respopnse").html(response);
   		 	},
    		error: function(response) {
			        $(".approve_quote").show();
			        $(".approve_quote_close").show();
    			        $("#approve_quote_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
        
        $(".selections .add_selection").click(function(){
                $( this ).closest('selections').clone();
        });
	
});

function UploadSelection(location) {
    var $input = $("#" + location);
    var fd = new FormData;

    fd.append('img', $input.prop('files')[0]);
	fd.append('location', location);

    $.ajax({
        url: '/wp-content/themes/go/projects-templates/ajax/image_upload.php',
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