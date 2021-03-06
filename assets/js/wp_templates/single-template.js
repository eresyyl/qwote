(function(window, document, $) {
	'use strict';
	const readonlyField = "Title",
		removingFields = ["slug", "type_of_fields", "type_of_price"];

	$(window).load( () => {
		$('[data-event="add-layout"]').remove();
		$('[data-event="remove-layout"]').remove();
		$('[data-name="total_slug"]')[0].remove();
		
		$(`div.acf-fields > [data-name="${readonlyField.toLowerCase()}"]  label:contains("${readonlyField}")`).each( (index, label) => {
			if( label.innerHTML != readonlyField || !label.attributes.for) return;
			
			let title = $(`#${label.attributes.for.value}`);
			let block_title = $(label.closest('.layout')).find('.acf-fc-layout-handle');
			let block_number = block_title.find('.acf-fc-layout-order');
			if(block_number[0]) block_title.html(`${block_number.outerHTML()} ${title.val()}`);
			
			title.prop('readonly', true);
		});
		
		for(let i in removingFields){
			$(`div.acf-fields > .acf-field[data-name="${removingFields[i]}"]`).remove();
		}
	});
})(window, document, jQuery);
