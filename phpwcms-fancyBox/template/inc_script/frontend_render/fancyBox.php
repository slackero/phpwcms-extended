<?php
/**
 * phpwcms jQuery FancyBox replacement for Lightbox (SlimBox)
 * version: 11 Nov 2012
 * @requires jQuery v1.6 or later
 *
 * Examples at http://fancyapps.com/fancybox/
 * License: www.fancyapps.com/fancybox/#license
 *
 * Copyright 2012 Oliver Georgi - oliver@phpwcms.de
 */

if(substr($block['jslib'], 0, 6) == 'jquery' && version_compare(substr($block['jslib'], 7), '1.6', '>=')) {
	
	$phpwcms['fancybox_swipe_support'] = true;
	
	// Remove Slimbox support
	unset(
		$block['custom_htmlhead']['lightbox.css'],
		$block['custom_htmlhead']['slimbox.js']
	);	
	
	set_css_link( 'lib/fancybox/jquery.fancybox.css' );
	
	initJSPlugin('mousewheel.min');
	
	if($phpwcms['fancybox_swipe_support']) {
		initJSPlugin('touchSwipe.min');
	}
	
	$block['custom_htmlhead']['fancybox.js'] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/fancybox/jquery.fancybox.pack.js');

	if($phpwcms['fancybox_swipe_support']) {
		$block['custom_htmlhead']['fancybox.initSwipeOn'] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/fancybox/jquery.fancybox.initSwipeOn.js');
	} else {
		$block['custom_htmlhead']['fancybox.initSwipeOff'] = getJavaScriptSourceLink(TEMPLATE_PATH.'lib/fancybox/jquery.fancybox.initSwipeOff.js');
	}
	
}

?>