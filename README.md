# newrelic

[![Build Status](https://magnum.travis-ci.com/refinery29/newrelic.svg?token=WxyzZysW5QK9hWX3J4Yg&branch=master)](https://magnum.travis-ci.com/refinery29/newrelic)
[![Code Climate](https://codeclimate.com/repos/56138bd8e30ba004d2001775/badges/ddbe21a804cf7cd8748a/gpa.svg)](https://codeclimate.com/repos/56138bd8e30ba004d2001775/feed)
[![Test Coverage](https://codeclimate.com/repos/56138bd8e30ba004d2001775/badges/ddbe21a804cf7cd8748a/coverage.svg)](https://codeclimate.com/repos/56138bd8e30ba004d2001775/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/561390b2a1933400150003a2/badge.svg?style=flat)](https://www.versioneye.com/user/projects/561390b2a1933400150003a2)

This repository provides a wrapper around the [New Relic PHP API](https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-api), 
inspired by [`intouch/newrelic`](https://github.com/In-Touch/newrelic).
 
## Installation

Add this to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:refinery29/doctrine-service-provider"
        }
    ]
}
```

Run:

```
$ composer require refinery29/newrelic
```

## Usage


```php
use Refinery29\NewRelic\Agent;

$agent = new Agent();

$agent->setAppname('Refinery29 API');
$agent->nameTransaction('POST /entries');
```

:bulb: Ideally, you should create one instance of `Refinery29\NewRelic\Agent`, share it using a container, 
and inject it as a dependency into objects wishing to consume it.

## Handlers

If you don't inject a handler, `Refinery29\NewRelic\Agent` creates an instance of `Refinery29\NewRelic\Handler\DefaultHandler`
and uses it to make calls to the New Relic API.

You may want to inject a `NullHandler` if you don't want to actually make calls to the New Relic API, for example, 
in non-production environments:

```php
use Refinery29\NewRelic\Agent;
use Refinery29\NewRelic\Handler;

$handler = new Handler\NullHandler();

$agent = new Agent($handler);

$agent->setAppname('Refinery29 API');
$agent->nameTransaction('POST /entries');
```
