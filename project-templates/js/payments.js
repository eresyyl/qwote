$(document).ready(function() {
	
        // Marking miletone as Done
        
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
    			        $("#mark_as_done_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
	
        // Marking miletone as Paid
        
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
    			        $("#mark_as_paid_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
        
        // Marking variation as Done
        
	$('.mark_as_done_variation').click(function() {
		$('.mark_as_done_variation_confirm').attr('data-quote','').attr('data-milestone','');
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
                $('.mark_as_done_variation_confirm').attr('data-quote',quote_id).attr('data-milestone',quote_milestone);
		$("#mark_as_done_variation_respopnse").html('');
		$(".mark_as_done_variation_confirm").show();
                $(".mark_as_done_variation_close").html('No, i was wrong').show();
	});
	
	$(".mark_as_done_variation_confirm").click(function(){
                $("#mark_as_done_variation_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".mark_as_done_variation_confirm").hide();
		$(".mark_as_done_variation_close").hide();
		var mark_as_done_variation = "/wp-content/themes/go/project-templates/ajax/mark_as_done_variation.php";
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
   	 	jQuery.ajax({
      	  	url: mark_as_done_variation,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
                                'quote_milestone' : quote_milestone
			},
       	 	success: function(response) {
			        $("#mark_as_done_variation_respopnse").html("");
       		 	        $("#mark_as_done_variation_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".mark_as_done_variation_confirm").show();
        		        $(".mark_as_done_variation_close").show();
    			        $("#mark_as_done_variation_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
	
        // Marking variation as Paid
        
	$('.mark_as_paid_variation').click(function() {
		$('.mark_as_paid_variation_confirm').attr('data-quote','').attr('data-milestone','');
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
                $('.mark_as_paid_variation_confirm').attr('data-quote',quote_id).attr('data-milestone',quote_milestone);
		$("#mark_as_paid_variation_respopnse").html('');
		$(".mark_as_paid_variation_confirm").show();
                $(".mark_as_paid_variation_close").html('No, i was wrong').show();
	});
        
	$(".mark_as_paid_variation_confirm").click(function(){
                $("#mark_as_paid__variationrespopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".mark_as_paid_variation_confirm").hide();
		$(".mark_as_paid_variation_close").hide();
		var mark_as_paid_variation = "/wp-content/themes/go/project-templates/ajax/mark_as_paid_variation.php";
		var quote_id = $(this).attr('data-quote');
                var quote_milestone = $(this).attr('data-milestone');
   	 	jQuery.ajax({
      	  	url: mark_as_paid_variation,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
                                'quote_milestone' : quote_milestone
			},
       	 	success: function(response) {
			        $("#mark_as_paid_variation_respopnse").html("");
       		 	        $("#mark_as_paid_variation_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".mark_as_paid_variation_confirm").show();
        		        $(".mark_as_paid_variation_close").show();
    			        $("#mark_as_paid_variation_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
        
        // Approving project
        
	$('.approve').click(function() {
		$('.approve_confirm').attr('data-quote','');
		var quote_id = $(this).attr('data-quote');
                $('.approve_confirm').attr('data-quote',quote_id);
		$("#approve_respopnse").html('');
		$(".approve_confirm").show();
                $(".approve_cancel").html('No, i was wrong').show();
	});
        
	$(".approve_confirm").click(function(){
                $("#approve_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".approve_confirm").hide();
		$(".approve_cancel").hide();
		var approve = "/wp-content/themes/go/project-templates/ajax/approve_project.php";
		var quote_id = $(this).attr('data-quote');
   	 	jQuery.ajax({
      	  	url: approve,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
			},
       	 	success: function(response) {
			        $("#approve_respopnse").html("");
       		 	        $("#approve_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".approve_confirm").show();
        		        $(".approve_cancel").show();
    			        $("#approve_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
        
        // Cancelling project
        
	$('.cancel').click(function() {
		$('.cancel_confirm').attr('data-quote','');
		var quote_id = $(this).attr('data-quote');
                $('.cancel_confirm').attr('data-quote',quote_id);
		$("#cancel_respopnse").html('');
		$(".cancel_confirm").show();
                $(".cancel_cancel").html('No, i was wrong').show();
	});
        
	$(".cancel_confirm").click(function(){
                $("#cancel_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".cancel_confirm").hide();
		$(".cancel_cancel").hide();
		var cancel = "/wp-content/themes/go/project-templates/ajax/cancel_project.php";
		var quote_id = $(this).attr('data-quote');
   	 	jQuery.ajax({
      	  	url: cancel,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
			},
       	 	success: function(response) {
			        $("#cancel_respopnse").html("");
       		 	        $("#cancel_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".cancel_confirm").show();
        		        $(".cancel_cancel").show();
    			        $("#cancel_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
        
        // Completing project
        
	$('.complete').click(function() {
		$('.completed_confirm').attr('data-quote','');
		var quote_id = $(this).attr('data-quote');
                $('.completed_confirm').attr('data-quote',quote_id);
		$("#completed_respopnse").html('');
		$(".completed_confirm").show();
                $(".completed_cancel").html('No').show();
	});
        
	$(".completed_confirm").click(function(){
                $("#completed_respopnse").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
		$(".completed_confirm").hide();
		$(".completed_cancel").hide();
		var completed = "/wp-content/themes/go/project-templates/ajax/completed_project.php";
		var quote_id = $(this).attr('data-quote');
   	 	jQuery.ajax({
      	  	url: completed,
       	 	type: "POST",
			dataType: "html",
			data: { 
				'quote_id' : quote_id,
			},
       	 	success: function(response) {
			        $("#completed_respopnse").html("");
       		 	        $("#completed_respopnse").html(response);
   		 	},
    		error: function(response) {
        		        $(".completed_confirm").show();
        		        $(".completed_cancel").show();
    			        $("#completed_respopnse").html("<div class='text-center margin-bottom-20'>Something went wrong!</div>");
    		        }
  	  	});
	});
        
        
});