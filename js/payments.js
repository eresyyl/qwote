$(document).ready(function() {
	
	$('.mark_as_done').click(function() {
		$('.mark_as_done_confirm').attr('data-quote','').attr('data-milestone','');
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
                $('.mark_as_done_confirm').attr('data-quote',quote_id).attr('data-milestone',quote_milestone);
		$("#mark_as_done_respopnse").html('');
		$(".mark_as_done_confirm").show();
                $(".mark_as_done_close").html('No, i was wrong').show();
	});
	
	$(".mark_as_done_confirm").click(function(){
                $("#mark_as_done_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".mark_as_done_confirm").hide();
		$(".mark_as_done_close").hide();
		var mark_as_done = "/wp-content/themes/go/project-templates/ajax/mark_as_done.php";
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
   	 	jQuery.ajax({
      	  	url: mark_as_done,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
                                'quote_milestone' : quote_milestone
			},
       	 	success: function(response) {
			        $("#mark_as_done_respopnse").html("");
       		 	        $("#mark_as_done_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".mark_as_done_confirm").show();
        		        $(".mark_as_done_close").show();
    			        $("#mark_as_done_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
	
        
	$('.mark_as_paid').click(function() {
		$('.mark_as_paid_confirm').attr('data-quote','').attr('data-milestone','');
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
                $('.mark_as_paid_confirm').attr('data-quote',quote_id).attr('data-milestone',quote_milestone);
		$("#mark_as_paid_respopnse").html('');
		$(".mark_as_paid_confirm").show();
                $(".mark_as_paid_close").html('No, i was wrong').show();
	});
        
	$(".mark_as_paid_confirm").click(function(){
                $("#mark_as_paid_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".mark_as_paid_confirm").hide();
		$(".mark_as_paid_close").hide();
		var mark_as_paid = "/wp-content/themes/go/project-templates/ajax/mark_as_paid.php";
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
   	 	jQuery.ajax({
      	  	url: mark_as_paid,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
                                'quote_milestone' : quote_milestone
			},
       	 	success: function(response) {
			        $("#mark_as_paid_respopnse").html("");
       		 	        $("#mark_as_paid_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".mark_as_paid_confirm").show();
        		        $(".mark_as_paid_close").show();
    			        $("#mark_as_paid_respopnse").html("<div class='text-center margin-bottom-20'>Something goes wrong!</div>");
    		        }
  	  	});
	});
});