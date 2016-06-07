jQuery(document).ready(function($) {
	$('section#banner_meta').on('click', '.addImage', function(e){
		 e.preventDefault();
		 var i, imageCount;
		 imageCount = $(this).closest("section#banner_meta").find("input[name^=imageCount]");
		 i = parseInt(imageCount.val());
		 i++;
		 imageCount.val(i);
		 html = '<input type="text" name="cf_banner_image' + i +'" value="">';
		 $(this).closest("div").before(html);
	});
});