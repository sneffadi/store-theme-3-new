jQuery(document).ready(function($) {

	$('#reference_meta').on('click','a.add-reference',function(e){
		numItems = document.querySelectorAll('#reference_meta .reference').length;
		e.preventDefault();
		$(this).closest('.section').prev('.section').find(numItems).val() || 1; 
		var $i = numItems + 1;
		
		var html = '<div class="section reference"><p><label>Reference #' + $i + '</label><input type="text" name="reference-' + $i + '" value="" /></p><input type="hidden" name="ref-counter" value="'+ $i + '"><p><a href="#" class="remove-reference-' + $i + '">Remove Reference</a></p></div>';
		console.log(numItems);
		$(this).closest('.section').before(html);
		return false;
		
	});
	$('#reference_meta').on('click','[class^=remove-reference-]',function(e){
		e.preventDefault();
		var sectionLabel = $(this).closest('.section').find('label').text();
		var sectionNum = sectionLabel.match(/\d+/)[0];
		var numItems = $('#reference_meta .reference').length-1;
		$(this).closest('.section').fadeOut(function(){
			$(this).nextAll('.section').each(function(){
				var newIndex = $(this).find('label').html().match(/\d+/)[0] - 1;
				console.log(newIndex);
				$(this).find('label').html('Reference #' + newIndex);
				$(this).find('input').attr('name', 'reference-' + newIndex);
			})

		});

	});
});