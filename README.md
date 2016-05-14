# newrelic

[![Build Status](https://travis-ci.org/refinery29/newrelic.svg?branch=master)](https://travis-ci.org/refinery29/newrelic)
[![Code Climate](https://codeclimate.com/github/refinery29/newrelic/badges/gpa.svg)](https://codeclimate.com/github/refinery29/newrelic)
[![Test Coverage](https://codeclimate.com/github/refinery29/newrelic/badges/coverage.svg)](https://codeclimate.com/github/refinery29/newrelic/coverage)

This repository provides a wrapper around the [New Relic PHP API](https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-api), 
inspired by [`intouch/newrelic`](https://github.com/In-Touch/newrelic).
 
## Installation

Run

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

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.
