# php-urlquery-class
PHP URL Query Class

This class elegantly resolves a common concern of adding and removing query parameters from a URL. The constructor takes the URL, or if not specified, it will use the current url from `$_SERVER['REQUEST_URI']`.

Example Usage:
==============

```lang=php
echo (
  new UrlQuery('https://example.org/?test=this')
)->add(['this'=> 'that', 'step' => 2]);

// Output: https://example.org/?test=this&this=that&step=2
```

```lang=php
echo (
  new UrlQuery('https://example.org/?test=this&this=that&step=2')
)->remove(['this', 'step']);

// Output: https://example.org/?test=this
```

```lang=php
echo (new UrlQuery)->add(['token' => 'abc123']);

// Output: https://my.current/url/?already=there?token=abc123
```
