phpwcms Language Switch
=======================

If you need an easy to work with solution to switch between different language trees, put the scripts into your **phpwcms** installation.

Your page tree should be structured like this:

```
+ WEBROOT [ID 0, LEVEL 0, index]
|
|
+---+ EN [ID 1, LEVEL 1, en/home]
|   |
|   +--- About [en/about]
|   |
|   +--- Contact [en/contact]
|
|
+---+ DE [ID 2, LEVEL 1]
|   |
|   +--- Über [de/about]
|   |
|   +--- Kontakt [de/contact]
|
|
+---+ ... [ID 31, LEVEL 1, ...]
|
...
```

The **alias** — article or structure level or news – will be used to detect the opposite language’s content. Based on the setting `$phpwcms['alias_allow_slash']` there are 4 options to format the alias. `{lang}` is the equal replacer of the values in `$phpwcms['allowed_lang']`.

- `{lang}`**/**alias
- alias**/**`{lang}`
- `{lang}`**/**alias
- alias**/**`{lang}`

So the best is to think twice before you start structuring your site content.


Keep in mind:
-------------

There is no support for _translated_ alias at the moment. I recommend to target your main audiance and take the default language to name the lead alias and get better SEO results.

If no matching content can be detected the matching algorithm try to match the parent node and so on.


Replacer:
---------

There are several options to use a unique template for all languages. Here are the main replacement tags.

- [`{lang}`]foo[/`{lang}`] (case insensitive),  
[en]This is English[/en][de]Das ist Deutsch[/de]
- `@@Default@@`: check `template/template_lang/` after first parsing
- `{SWITCH_LANG}`: is replaced by the language switch
- `{LANG}`: is replaced by the active language code, useful in combination with class names
- `{NAV_MAIN}`: optional, can be used to render the main menu using the active language ID as entry ID (inactivated by commenting in the code)


Creator and supporter:
----------------------

**Oliver Georgi**

- [github.com/slackero](https://github.com/slackero)
- <og@phpwcms.org>.


Copyright and license:
----------------------

Copyright 2015 Oliver Georgi, released under [GNU GPL-2](https://github.com/slackero/phpwcms-extended/blob/master/LICENSE)
