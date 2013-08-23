![Sample picture phpwcms jQuery Cycle Plugin](https://raw.github.com/slackero/phpwcms-extended/master/phpwcms-cycle-slider/phpwcms-Cycle-Plugin.jpg)  
<small>*Photo: Doreen Ritzau, [re:do](http://www.re-do.de/), © 2013*</small>

phpwcms jQuery Cycle Plugin
===========================

**phpwcms** jQuery Cycle Plugin is a flexible slider solution based on a custom template for Content Part **Images \<div\>**. jQuery Cycle Plugin is one of the best and most flexible jQuery Slider scripts.

Copyright © 2013 Oliver Georgi — oliver@phpwcms.de


### Installation

Download related files and place content of folder **template** into the template folder of your **phpwcms** installation.


### Requires

phpwcms with jQuery support Version jQuery v1.7.1 or newer.


### Configuration

Edit `cycle-slider.css` and `init-slider.js` for your needs. Visit [Cycle Plugin options reference](http://jquery.malsup.com/cycle/options.html).

It is also possible to set all options using the HTML5 data attribute with JSON value: `data-options='{"autoSizeImage":true,"enablePrevNext":true,"enablePagination":true,"paginateMode":"thumbnail","wrapSliderSection":true}`

 Option            | Value                     | Description                        
-------------------|---------------------------|-----------------------------------------------------------
 autoSizeImage     | bool: false\|true          | `true` will catch first img src and use as background-image
 enablePrevNext    | bool: false\|true          | enable or disable prev/next pagination
 enablePagination  | bool: false\|true          | enable or disable single item pagination
 paginateMode      | string: default\|thumbnail | `default` will use 1/2/3 while `thumbnail` will use first image thumbnail as paginate item, thumbnail can be defined by `data-thumbnail` attribute within the first image (see example)
 wrapSliderSection | bool: false\|true          | `true` will wrap slider section by additional \<div>


### Usage

Create a new Content Part **Images \<div\>**, select the template `Cycle-Slider.tmpl` or `Cycle-Slider-Grey.tmpl`, add more than 1 image and *Update* or *Save*. Done!


### Bug tracker

Have a bug? Please create an [issue](https://github.com/slackero/phpwcms-extended/issues) on GitHub.


### Thanks

This little enhancement for phpwcms would not be possible without:

- **[jQuery Cycle Plugin](http://jquery.malsup.com/cycle/)** Copyright © 2007-2013 M. Alsup
- **[jQuery](http://jquery.org/)** Copyright © 2005, 2013 jQuery Foundation, Inc.


### Changelog

…