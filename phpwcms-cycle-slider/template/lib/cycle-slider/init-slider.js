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
		paginateMode: 'default', // default: 1,2,3 | thumbnail
		wrapSliderSection: false, // false or true, wrapped by <div class="cycle-slider-wrapper">
		cycleEffect: 'scrollRight', // Cycle Effect
		cycleSpeed: 'slow', // Cycle Speed
				
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
	
	if($sliderSection.length > 0) {
		
		$sliderSection.each(function(index) {
			
			var $sliderIndex		= index;
			var $thisSlider			= $(this);
			var $thisSliderOptions	= $sliderOptions;
			var $dataOptions		= $thisSlider.data('options');
			var $thumbnails			= [];

			if($.type($dataOptions) === 'object') {
				$.extend($thisSliderOptions, $dataOptions);	
			}			

			var $sliderItems		= $($thisSliderOptions.cycleOptions.slideExpr, $thisSlider);
		
			if($thisSliderOptions.autoSizeImage || $thisSliderOptions.paginateMode == 'thumbnail') {
			
				// Select first <img> Tag, catch image src and use it as CSS background image
				// Then hide the <img> Tag	
				$sliderItems.each(function() {
					var $item			= $(this);
					var $itemImage		= $('img:first', $item);
					var $itemImageSrc	= $itemImage.attr('src');
					if($thisSliderOptions.autoSizeImage && $itemImageSrc) {
						$item.css('background-image', 'url(' + $itemImageSrc + ')');
						$itemImage.hide();
					}
					// Choose pagination thumbnail
					if($thisSliderOptions.paginateMode == 'thumbnail') {
						// check for thumbnail src info
						var $itemImageThumbnail = $itemImage.data('thumbnail');
						if($.type($itemImageThumbnail) == 'string') {
							$thumbnails.push($itemImageThumbnail);
						} else if($itemImageSrc) {
							$thumbnails.push($itemImageSrc);
						} else {
							$thumbnails.push('');
						}
					}
				});
			}

			// Cycle but only when more than 1 item
			if($sliderItems.length > 1) {
				
				$thisSliderOptions.cycleOptions.fx = $thisSliderOptions.cycleEffect;
				$thisSliderOptions.cycleOptions.speed = $thisSliderOptions.cycleSpeed;
				
				if($thisSliderOptions.wrapSliderSection) {
					$thisSlider.wrap('<div class="cycle-slider-wrapper">');
				}
			
				// Add Prev/Next and Pagination (Dots)
				if($thisSliderOptions.enablePrevNext) {
					$thisSlider
						.append('<a id="slider-item-next" href="#" class="slider-nav slider-item-next"></a>')
						.append('<a id="slider-item-prev" href="#" class="slider-nav slider-item-prev"></a>');
				
					$thisSliderOptions.cycleOptions.next = '#slider-item-next';
					$thisSliderOptions.cycleOptions.prev = '#slider-item-prev';
				}
				if($thisSliderOptions.enablePagination) {
					$thisSliderOptions.cycleOptions.pager = '#slider-pagination-'+$sliderIndex;
					if($thisSliderOptions.paginateMode == 'thumbnail') {
						$thisSlider.after('<ul id="slider-pagination-'+$sliderIndex+'" class="slider-pagination-thumbnails">');
						$thisSliderOptions.cycleOptions.pagerAnchorBuilder = function(idx, slide) {
							var thumbnailSrc = $.type($thumbnails[idx]) == 'string' && $thumbnails[idx] ? $thumbnails[idx] : '';
							if(thumbnailSrc) {
								return '<li><a href="#" style="background-image:url('+thumbnailSrc+');"><img src="'+thumbnailSrc+'" alt="thumb'+(idx+1)+'" /></a></li>';
							} else {
								return '<li><a href="#"><span>'+(idx+1)+'</span></a></li>';
							}
						}
					} else {
						$thisSlider.append('<div id="slider-pagination-'+$sliderIndex+'" class="slider-pagination">');
					}
				}
				
				$thisSlider.cycle($thisSliderOptions.cycleOptions);
			}
		});
	}
});