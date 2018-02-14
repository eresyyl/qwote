$(document).ready(function() {
        $(".default_selections").on("click",".select_selection", function(){
                $(this).html('<i class="fa fa-refresh fa-spin"</i>');
                var selectionId = $(this).attr('data-selection');
                var quoteId = $(this).attr('data-quote');
                
		var selectSelection = '/wp-content/themes/go/project-templates/ajax/select_selection.php';
   	 	jQuery.ajax({
      	  	url: selectSelection,
       	 	type: "POST",
			dataType: "json",
                        cache: false,
			data: {
			        'selection_id' : selectionId,
                                'quote_id' : quoteId,
                                'action' : 'add'
			},
       	 	success: function(response) {
                                var stat = response.status;
                                var action = response.action;
                                var selectionId = response.selection;
                                if(stat == true && action == 'add') {
                                        $('.default_selections').find('.selection_' + selectionId + ' .select_selection').html('Add');
                                        $('.default_selections').find('.selection_' + selectionId + ' .overlay').show();
                                        $('.default_selections').find('.selection_' + selectionId).clone().appendTo('.selected_selections');
                                        $('.selected_selections').find('.selection_' + selectionId + ' .overlay').hide();
                                        $('.selected_selections').find('.selection_' + selectionId + ' .select_selection').removeClass('btn-success').addClass('btn-danger').html('Remove');
                                        $('.total').html(response.selection_price);
                                        $('.summ').html(response.selection_summ);
                                }
                                else {
                                        alert('Something went wrong! Try again later.');
                                }
   		 	},
    		error: function(response) {
                                alert('Something went wrong! Try again later.');
    		        }
  	  	});
        });
        
        $(".selected_selections").on("click",".select_selection", function(){
                $(this).html('<i class="fa fa-refresh fa-spin"</i>');
                var selectionId = $(this).attr('data-selection');
                var quoteId = $(this).attr('data-quote');
                
		var selectSelection = '/wp-content/themes/go/project-templates/ajax/select_selection.php';
   	 	jQuery.ajax({
      	  	url: selectSelection,
       	 	type: "POST",
			dataType: "json",
                        cache: false,
			data: {
			        'selection_id' : selectionId,
                                'quote_id' : quoteId,
                                'action' : 'remove'
			},
       	 	success: function(response) {
                                var stat = response.status;
                                var action = response.action;
                                var selectionId = response.selection;
                                if(stat == true && action == 'remove') {
                                        $('.selected_selections').find('.selection_' + selectionId).remove();
                                        $('.default_selections').find('.selection_' + selectionId + ' .overlay').hide();
                                        $('.total').html(response.selection_price);
                                        $('.summ').html(response.selection_summ);
                                }
                                else {
                                        alert('Something went wrong! Try again later.');
                                }
   		 	},
    		error: function(response) {
                                alert('Something went wrong! Try again later.');
    		        }
  	  	});
        });
});