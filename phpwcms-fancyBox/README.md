phpwcms-fancyBox
================

**phpwcms** jQuery FancyBox replacement for default Lightbox (SlimBox) integration with Swipe support for touch devices. Swipe support options are enabled only when more than one fancyBox item is detected.

Copyright (c) 2012 Oliver Georgi — oliver@phpwcms.de

### Installation

Download related files and place content of folder **template** into the template folder of your **phpwcms** installation.

### Requires

phpwcms with jQuery support Version 1.6 or newer.

### Configuration

The frontend render script has a single option to enable or disable Swipe support. If set to TRUE Swipe support will be enabled, FALSE will disable Swipe support.

	$phpwcms['fancybox_swipe_support'] = true;

To set **fancyBox** related options check the JavaScript files:

	jquery.fancybox.initSwipeOff.js  
	jquery.fancybox.initSwipeOn.js

There you can change or add the options as described in the [fancyBox documentation](http://fancyapps.com/fancybox/#docs).

### Bug tracker

Have a bug? Please create an [issue](https://github.com/slackero/phpwcms-fancyBox/issues) on GitHub.

### Thanks

That little enhancement for phpwcms would not be possible without:

- **[fancyBox](http://fancyapps.com/fancybox)** Copyright (c) 2012 Janis Skarnelis
- **[TouchSwipe](http://labs.skinkers.com/touchSwipe)** Copyright (c) 2010 Matt Bryson