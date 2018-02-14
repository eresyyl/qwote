(function(window, document, $) {
	'use strict';
	const searchString = "Title";

	$('[data-event="add-layout"]').remove();
	$('[data-event="remove-layout"]').remove();
	$('[data-name="total_slug"]')[0].remove();
	
	$(`div.acf-fields > [data-name="${searchString.toLowerCase()}"]  label:contains("${searchString}")`).each( (index, label) => {
		if( label.innerHTML != searchString || !label.attributes.for) return;
		
		$(`#${label.attributes.for.value}`).prop('readonly', true);
	});
})(window, document, jQuery);
