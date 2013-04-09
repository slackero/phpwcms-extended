/**
 * fancyBox with Swipe support for phpwcms
 * November 11, 2012, <oliver@phpwcms.de>
 **/

// initialize fancyBox with Swipe enabled
$(function() {
	
	// select all items based on lightbox selector
	var fancyBoxImages		= $("a[rel^='lightbox']");
	var fancyBoxImagesCount	= fancyBoxImages.length;
	// test device having touch support
	var hasTouch = 'ontouchstart' in window;
	
	// for all options visit http://fancyapps.com/fancybox/#docs
	
	if(fancyBoxImagesCount) {
		
		// more than 1 fancyBox Item means we enable Swipe support
		if(hasTouch && fancyBoxImagesCount > 1) {
			
			var fancyBoxOptions = {
				// openEffect	: 'none',
				// closeEffect	: 'none',
				closeBtn: false,
				arrows: false,
				type: 'image',
				afterShow: function() {
					$('.fancybox-wrap').swipe({
						swipe: function(event, direction) {
							if (direction === 'left' || direction === 'up') {
								$.fancybox.prev( direction );
							} else {
								$.fancybox.next( direction );
							}
						}
					});
				}
			};
		
		// only 1 fancyBox Item means Swipe support not needed
		} else {
			
			var fancyBoxOptions = {
				// openEffect	: 'none',
				// closeEffect	: 'none'
				type: 'image'
			};
		
		}
		
		fancyBoxImages.fancybox(fancyBoxOptions);
	}
	
	var fancyBoxOthers = $("a.fancybox-custom");
	var fancyBoxOthersCount = fancyBoxOthers.length;
	
	if(fancyBoxOthersCount) {
		
		// more than 1 fancyBox Item means we enable Swipe support
		if(hasTouch && fancyBoxImagesCount > 1) {
			
			var fancyBoxOthersOptions = {
				// openEffect	: 'none',
				// closeEffect	: 'none',
				closeBtn: false,
				arrows: false,
				//type: 'image',
				afterShow: function() {
					$('.fancybox-wrap').swipe({
						swipe: function(event, direction) {
							if (direction === 'left' || direction === 'up') {
								$.fancybox.prev( direction );
							} else {
								$.fancybox.next( direction );
							}
						}
					});
				}
			};
		
		// only 1 fancyBox Item means Swipe support not needed
		} else {
			
			var fancyBoxOthersOptions = {
				// openEffect	: 'none',
				// closeEffect	: 'none'
				//type: 'image'
			};
		
		}
		
		fancyBoxOthers.fancybox(fancyBoxOthersOptions);
	}

});