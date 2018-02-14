$(document).ready(function() {
        
	$(".save_proposal").click(function(){
                tinyMCE.triggerSave();
                var proposal = $('.wp-editor-area').val();
                var quote_id = $('.proposal_quote_id').val();
                $(".proposal_response").html('<div class="text-center"><i class="fa fa-refresh fa-spin"</i></div>');
                
		var newProposal = '/wp-content/themes/go/project-templates/ajax/save_proposal.php';
   	 	jQuery.ajax({
      	  	url: newProposal,
       	 	type: "POST",
                        //dataType: "html",
			dataType: "json",
                        cache: false,
			data: {
			        'proposal' : proposal,
                                'quote_id' : quote_id
			},
       	 	success: function(response) {
                                $(".proposal_response").html(response.message);
   		 	},
    		error: function(response) {
	 	                $(".proposal_response").html("<div class='text-center red-800'>Something went wrong! Try again later.</div>");
    		        }
  	  	});
	});
});