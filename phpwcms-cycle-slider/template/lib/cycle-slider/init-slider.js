/*! 
 *  phpwcms Cycle Plugin
 *  --------------------
 *
 *  Copyright (c) 2013 Oliver Georgi — oliver@phpwcms.de
 *
 */
$(function(){
	
	var $sliderOptions = {
		autoSizeImage: true, // if false the Slider Item will be used as is
		enablePrevNext: true, // enable prev/next elements
		enablePagination: true, // show pagination
		
		// jQuery Cycle plugin options
		// http://jquery.malsup.com/cycle/options.html
		cycleOptions: {
			fx: 'scrollRight',
			speed: 'slow',
			slideExpr: '.slider-item',
			pauseOnPagerHover: 1,
			pause: 1,
			timeout: 5000,
			startingSlide: 0,
			fit: 1,
			slideResize: 0
		}
	};
	
	var $sliderSection = $('.cycle-slider-section');
	
	if($sliderSection) {

		var $sliderItems = $('.slider-item', $sliderSection);
		
		if($sliderOptions.autoSizeImage) {
			
			// Select first <img> Tag, catch image src and use it as CSS background image
			// Then hide the <img> Tag
			
			$sliderItems.each(function() {
				var $item = $(this);
				var $itemImage = $('img:first', $item);
				var $itemImageSrc = $itemImage.attr('src');
				if($itemImageSrc) {
					$item.css('background-image', 'url(' + $itemImageSrc + ')');
					$itemImage.hide();
				}
			});
		}

		// Cycle but only when more than 1 item
		if($sliderItems.length > 1) {
			
			// Add Prev/Next and Pagination (Dots)
			if($sliderOptions.enablePrevNext) {
				$sliderSection
					.append('<a id="slider-item-next" href="#" class="slider-nav slider-item-next"></a>')
					.append('<a id="slider-item-prev" href="#" class="slider-nav slider-item-prev"></a>');
				
				$sliderOptions.cycleOptions.next = '#slider-item-next';
				$sliderOptions.cycleOptions.prev = '#slider-item-prev';
			}
			if($sliderOptions.enablePagination) {
				$sliderSection.append('<div id="slider-pagination" class="slider-pagination">');
				$sliderOptions.cycleOptions.pager = '#slider-pagination';
			}
			
			$sliderSection.cycle($sliderOptions.cycleOptions);
		}
	}
});