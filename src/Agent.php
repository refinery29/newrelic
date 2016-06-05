<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic;

use Assert\Assertion;
use Refinery29\NewRelic\Handler\DefaultHandler;
use Refinery29\NewRelic\Handler\Handler;

final class Agent implements AgentInterface
{
    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Handler $handler = null)
    {
        $this->handler = $handler ?: new DefaultHandler();
    }

    public function addCustomParameter($key, $value)
    {
        Assertion::string($key);
        Assertion::notBlank($key);
        Assertion::scalar($value);

        return $this->handle('newrelic_add_custom_parameter', [
            $key,
            $value,
        ]);
    }

    public function addCustomTracer($functionName)
    {
        Assertion::string($functionName);
        Assertion::notBlank($functionName);

        return $this->handle('newrelic_add_custom_tracer', [
            $functionName,
        ]);
    }

    public function backgroundJob($flag = true)
    {
        Assertion::boolean($flag);

        $this->handle('newrelic_background_job', [
            $flag,
        ]);
    }

    public function captureParams($enable = true)
    {
        Assertion::boolean($enable);

        $this->handle('newrelic_capture_params', [
            $enable,
        ]);
    }

    public function customMetric($metricName, $value)
    {
        Assertion::string($metricName);
        Assertion::notBlank($metricName);
        Assertion::float($value);

        return $this->handle('newrelic_custom_metric', [
            $metricName,
            $value,
        ]);
    }

    public function disableAutoRum()
    {
        return $this->handle('newrelic_disable_autorum');
    }

    public function endOfTransaction()
    {
        $this->handle('newrelic_end_of_transaction');
    }

    public function endTransaction($ignore = false)
    {
        Assertion::boolean($ignore);

        return $this->handle('newrelic_end_transaction', [
            $ignore,
        ]);
    }

    public function getBrowserTimingFooter($includeTags = false)
    {
        Assertion::boolean($includeTags);

        return $this->handle('newrelic_get_browser_timing_footer', [
            $includeTags,
        ]);
    }

    public function getBrowserTimingHeader($includeTags = false)
    {
        Assertion::boolean($includeTags);

        return $this->handle('newrelic_get_browser_timing_header', [
            $includeTags,
        ]);
    }

    public function ignoreApdex()
    {
        $this->handle('newrelic_ignore_apdex');
    }

    public function ignoreTransaction()
    {
        $this->handle('newrelic_ignore_transaction');
    }

    public function nameTransaction($name)
    {
        Assertion::string($name);
        Assertion::notBlank($name);

        return $this->handle('newrelic_name_transaction', [
            $name,
        ]);
    }

    public function noticeError($message, \Exception $exception = null)
    {
        Assertion::string($message);
        Assertion::notBlank($message);

        $this->handle('newrelic_notice_error', [
            $message,
            $exception,
        ]);
    }

    public function recordCustomEvent($name, array $attributes)
    {
        Assertion::string($name);
        Assertion::notBlank($name);
        Assertion::allString(array_keys($attributes));
        Assertion::allScalar(array_values($attributes));

        $this->handle('newrelic_record_custom_event', [
            $name,
            $attributes,
        ]);
    }

    public function setAppname($name, $license = '', $xmit = false)
    {
        Assertion::string($name);
        Assertion::notBlank($name);
        Assertion::string($license);
        Assertion::boolean($xmit);

        return $this->handle('newrelic_set_appname', [
            $name,
            $license,
            $xmit,
        ]);
    }

    public function setUserAttributes($user = '', $account = '', $product = '')
    {
        Assertion::string($user);
        Assertion::string($account);
        Assertion::string($product);

        return $this->handle('newrelic_set_user_attributes', [
            $user,
            $account,
            $product,
        ]);
    }

    public function startTransaction($appName, $license = '')
    {
        Assertion::string($appName);
        Assertion::notBlank($appName);
        Assertion::string($license);

        return $this->handle('newrelic_start_transaction', [
            $appName,
            $license,
        ]);
    }

    /**
     * @param string $functionName
     * @param array  $arguments
     *
     * @return mixed
     */
    private function handle($functionName, array $arguments = [])
    {
        return $this->handler->handle($functionName, $arguments);
    }
}
