<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic;

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
        return $this->handle('newrelic_add_custom_parameter', [
            $key,
            $value,
        ]);
    }

    public function addCustomTracer($functionName)
    {
        return $this->handle('newrelic_add_custom_tracer', [
            $functionName,
        ]);
    }

    public function backgroundJob($flag = true)
    {
        return $this->handle('newrelic_background_job', [
            $flag,
        ]);
    }

    public function captureParams($enable = true)
    {
        return $this->handle('newrelic_capture_params', [
            $enable,
        ]);
    }

    public function customMetric($metricName, $value)
    {
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
        return $this->handle('newrelic_end_of_transaction');
    }

    public function endTransaction($ignore = false)
    {
        return $this->handle('newrelic_end_transaction', [
            $ignore,
        ]);
    }

    public function getBrowserTimingFooter($includeTags = false)
    {
        return $this->handle('newrelic_get_browser_timing_footer', [
            $includeTags,
        ]);
    }

    public function getBrowserTimingHeader($includeTags = false)
    {
        return $this->handle('newrelic_get_browser_timing_header', [
            $includeTags,
        ]);
    }

    public function ignoreApdex()
    {
        return $this->handle('newrelic_ignore_apdex');
    }

    public function ignoreTransaction()
    {
        return $this->handle('newrelic_ignore_transaction');
    }

    public function nameTransaction($name)
    {
        return $this->handle('newrelic_name_transaction', [
            $name,
        ]);
    }

    public function noticeError($message, \Exception $exception = null)
    {
        return $this->handle('newrelic_notice_error', [
            $message,
            $exception,
        ]);
    }

    public function recordCustomEvent($name, array $attributes)
    {
        return $this->handle('newrelic_record_custom_event', [
            $name,
            $attributes,
        ]);
    }

    public function setAppname($name, $license = '', $xmit = false)
    {
        return $this->handle('newrelic_set_appname', [
            $name,
            $license,
            $xmit,
        ]);
    }

    public function setUserAttributes($user = '', $account = '', $product = '')
    {
        return $this->handle('newrelic_set_user_attributes', [
            $user,
            $account,
            $product,
        ]);
    }

    public function startTransaction($appName, $license = '')
    {
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
