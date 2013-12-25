$(function() {
	
	/*
	// In case of orientation change fire scrollTo()
    $(window).bind('orientationchange', function () {
        window.scrollTo(0, 0);
    });
	*/

	// Search all carousel first
	var carousels = $('.carousel');
	
	// Build navigation and inject Carousel
	carousels.each(function(index) {
		
		var	$this		= $(this),
			carouselNum	= index,
			baseId		= 'carousel'+index,
			childCount	= 0;
		
		// count children first, the current is based
		// on 960px with 3 items fit in visible area
		childCount = $this.children();
		
		// if more than 3 children, inject navigation
		if(childCount.length > 3) {
			
			// Inject nav elements into DOM
			$this.after('<div class="carousel-nav">'+
			'<a class="carousel-prev" href="#" id="'+baseId+'-prev"><span>&lsaquo;</span></a>'+
			'<a class="carousel-next" href="#" id="'+baseId+'-next"><span>&rsaquo;</span></a>'+
			'</div>');
			
			// Init the Carousel
			$this.carouFredSel({
				circular: true,
				auto: {
					play: true,
					duration: 1000 // autoDuration = 5 x duration
				},
				align: 'left',
				cookie: false,
				items: {
					visible: 3,
					width: 316
				},
				width: 960,
				prev: {
					button: '#'+baseId+'-prev',
					key: 'left'
				},
			    next: {
					button: '#'+baseId+'-next',
					key: 'right'
				},
				scroll: {
					pauseOnHover: 'resume'
				},
				swipe: {
					onTouch: true,
					onMouse: true,
					items: 3
				}	
			});
			
		}
		
	});
});