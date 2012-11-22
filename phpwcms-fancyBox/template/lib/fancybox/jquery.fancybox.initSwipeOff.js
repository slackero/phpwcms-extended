/**
 * fancyBox without Swipe support for phpwcms
 * November 11, 2012, <oliver@phpwcms.de>
 **/

// initialize fancyBox with Swipe enabled
$(function() {
	
	// select all items based on lightbox selector
	var fancyBoxImages		= $("a[rel^='lightbox']");
	var fancyBoxImagesCount	= fancyBoxImages.length;
	
	if(fancyBoxImagesCount) {
		
		// for all options visit http://fancyapps.com/fancybox/#docs
		fancyBoxImages.fancybox({
				// openEffect	: 'none',
				// closeEffect	: 'none'
				type: 'image'
		});

	}

});