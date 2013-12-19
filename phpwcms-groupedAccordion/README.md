phpwcms-groupedAccordion
================

**groupedAccordion** is a frontend render script to detect grouped content parts as introduced with this [commit](https://github.com/slackero/phpwcms/commit/5794d67969916bd3a49ce47e3f3880fc08707f4e) and inject a jQuery based Accordion script, based on a slightly enhanced version of [Zebra_Accordion](http://stefangabos.ro/jquery/zebra-accordion/).

Copyright (c) 2013 Oliver Georgi — contact@phpwcms.de


### Installation

Download related files and place content of folder **template** into the template folder of your **phpwcms** installation.


### Requires

phpwcms released after Dec. 11, 2013 with jQuery support Version 1.6 or newer.


### Configuration

Open the frontend render script at `template/inc_script/frontend_render/grouped-accordion.php`. There you can change or add options as described in the [Zebra-Accordion documentation](http://stefangabos.ro/jquery/zebra-accordion/). The Zebra_Accordion used for **phpwcms-groupedAccordion** was enhanced by two new options:

	switch: '.foo' // jQuery selector like '.class', 'tag', '#id'…
	content: '.foo' // jQuery selector like '.class', 'tag', '#id'…

The frontend render script is based on template vars as configured in `config/phpwcms/conf.template_default.inc.php`. `$template_default['classes']['cpgroup-title']` and `$template_default['classes']['cpgroup-content']` are used to set the `switch` and `content` selectors.

You are free to set your own values for related CSS class names in `conf.template_default.inc.php` or inside of your scripts (*frontend init/render*):

	$template_default['classes']['cpgroup-container'] = 'cpgroup-container';
	$template_default['classes']['cpgroup-title'] = 'cpgroup-title';
	$template_default['classes']['cpgroup-first'] = 'cpgroup-first';
	$template_default['classes']['cpgroup-last'] = 'cpgroup-last';
	$template_default['classes']['cpgroup'] = 'cpgroup';
	$template_default['classes']['cpgroup-container-clear'] = '';
	$template_default['classes']['cpgroup-content'] = 'cpgroup-content';


### Usage

Set grouped content parts in the backend of phpwcms.

![Select group from subsections](https://raw.github.com/slackero/phpwcms-extended/master/phpwcms-groupedAccordion/src/img/grouped-cp-edit.png)

You can see the grouped content parts in article CP listing mode

![Listed grouped subscections](https://raw.github.com/slackero/phpwcms-extended/master/phpwcms-groupedAccordion/src/img/grouped-cp-list.png)


### Bug tracker

Have a bug? Please create an [issue](https://github.com/slackero/phpwcms-extended/issues) on GitHub.


### Thanks

That little enhancement for phpwcms would not be possible without:

- **[Zebra_Accordion](http://stefangabos.ro/jquery/zebra-accordion/)** Copyright (c) 2011-2013 Stefan Gabos


### Changelog

#### 19 Dec 2013
- initial commit