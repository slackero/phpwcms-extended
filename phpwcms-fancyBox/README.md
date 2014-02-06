phpwcms-fancyBox
================

**phpwcms** jQuery FancyBox is a replacement of the default Lightbox (SlimBox) integration enhanced by with Swipe support for touch devices. Swipe support options are enabled  when more than one fancyBox item is detected only.

Copyright (c) 2012-2014 Oliver Georgi — oliver@phpwcms.de


### Components

**fancyBox** is a tool that offers a nice and elegant way to add zooming functionality for images, html content and multi-media on your webpages. Check [license](http://www.fancyapps.com/fancybox/#license). Copyright (c) 2012 Janis Skarnelis - janis@fancyapps.com

**TouchSwipe** is a jquery plugin to be used with jQuery on touch input devices such as iPad, iPhone etc.


---

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

- **[fancyBox](http://fancyapps.com/fancybox)** Copyright (c) 2012 Janis Skarnelis - janis@fancyapps.com
- **[TouchSwipe](http://labs.skinkers.com/touchSwipe/)** Copyright (c) 2010 Matt Bryson

### Changelog

#### 6 Feb 2014
- touchSwipe 1.6.5
- move touchSwipe to seperate folder

#### 2 Jul 2013
- fancyBox v2.1.5

#### 7 Feb 2013
- fancyBox v2.1.4
- touchSwipe v1.6
- changed position of fancyBox init scripts
- optimisation