$(document).ready(() => {
	const ratingSelector = '#projectRating';
	$(ratingSelector).barrating({
		theme: 'fontawesome-stars',
		showSelectedRating: true,
		onSelect: (value, text, event) => {
			if (typeof(event) !== 'undefined') {
			  // rating was selected by a user
				$(ratingSelector).val(value);
			} 
		}
	});
});
