$(document).ready(function() {
	
	$('.paid').click(function() {
		$('.paid_invoice').attr('data-invoice','');
		var invoice_id = $(this).attr('data-invoice');
                $('.paid_invoice').attr('data-invoice',invoice_id);
		$("#paid_invoice_respopnse").html('');
		$(".paid_invoice").show();
		$(".cancel_invoice").html('No, i was wrong');
	});
	
	$(".paid_invoice").click(function(){
                $("#paid_invoice_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".paid_invoice").hide();
		$(".cancel_invoice").hide();
		var paid_invoice = "/wp-content/themes/go/invoice-templates/ajax/paid_invoice.php";
		var invoice_id = $(this).attr('data-invoice');
   	 	jQuery.ajax({
      	  	url: paid_invoice,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'invoice_id' : invoice_id
			},
       	 	success: function(response) {
			        $("#paid_invoice_respopnse").html("");
       		 	        $("#paid_invoice_respopnse").html(response);
   		 	},
    		error: function(response) {
			        $(".paid_invoice").show();
			        $(".cancel_invoice").show();
    			        $("#paid_invoice_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
        
        
        
	$('.remind').click(function() {
		$('.remind_invoice').attr('data-invoice','');
		var invoice_id = $(this).attr('data-invoice');
                $('.remind_invoice').attr('data-invoice',invoice_id);
		$("#remind_invoice_respopnse").html('');
		$(".remind_invoice").show();
		$(".cancel_remind_invoice").html('No, i was wrong');
	});
	
	$(".remind_invoice").click(function(){
                $("#remind_invoice_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".remind_invoice").hide();
		$(".cancel_remind_invoice").hide();
		var remind_invoice = "/wp-content/themes/go/invoice-templates/ajax/remind_invoice.php";
		var invoice_id = $(this).attr('data-invoice');
   	 	jQuery.ajax({
      	  	url: remind_invoice,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'invoice_id' : invoice_id
			},
       	 	success: function(response) {
			        $("#remind_invoice_respopnse").html("");
       		 	        $("#remind_invoice_respopnse").html(response);
   		 	},
    		error: function(response) {
			        $(".remind_invoice").show();
			        $(".cancel_remind_invoice").show();
    			        $("#remind_invoice_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
	
	
});