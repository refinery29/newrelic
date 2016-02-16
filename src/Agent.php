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

class Agent
{
    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Handler $handler = null)
    {
        $this->handler = $handler ?: new DefaultHandler();
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function addCustomParameter($key, $value)
    {
        return $this->handle('newrelic_add_custom_parameter', [
            $key,
            $value,
        ]);
    }

    /**
     * @param string $functionName
     *
     * @return mixed
     */
    public function addCustomTracer($functionName)
    {
        return $this->handle('newrelic_add_custom_tracer', [
            $functionName,
        ]);
    }

    /**
     * @param bool $flag
     *
     * @return mixed
     */
    public function backgroundJob($flag = true)
    {
        return $this->handle('newrelic_background_job', [
            $flag,
        ]);
    }

    /**
     * @param bool $enable
     *
     * @return mixed
     */
    public function captureParams($enable = true)
    {
        return $this->handle('newrelic_capture_params', [
            $enable,
        ]);
    }

    /**
     * @param string $metricName
     * @param mixed  $value
     *
     * @return mixed
     */
    public function customMetric($metricName, $value)
    {
        return $this->handle('newrelic_custom_metric', [
            $metricName,
            $value,
        ]);
    }

    /**
     * @return mixed
     */
    public function disableAutoRum()
    {
        return $this->handle('newrelic_disable_autorum');
    }

    /**
     * @return mixed
     */
    public function endOfTransaction()
    {
        return $this->handle('newrelic_end_of_transaction');
    }

    /**
     * @param bool $ignore
     *
     * @return mixed
     */
    public function endTransaction($ignore = false)
    {
        return $this->handle('newrelic_end_transaction', [
            $ignore,
        ]);
    }

    /**
     * @param bool $includeTags
     *
     * @return mixed
     */
    public function getBrowserTimingFooter($includeTags = false)
    {
        return $this->handle('newrelic_get_browser_timing_footer', [
            $includeTags,
        ]);
    }

    /**
     * @param bool $includeTags
     *
     * @return mixed
     */
    public function getBrowserTimingHeader($includeTags = false)
    {
        return $this->handle('newrelic_get_browser_timing_header', [
            $includeTags,
        ]);
    }

    /**
     * @return mixed
     */
    public function ignoreApdex()
    {
        return $this->handle('newrelic_ignore_apdex');
    }

    /**
     * @return mixed
     */
    public function ignoreTransaction()
    {
        return $this->handle('newrelic_ignore_transaction');
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function nameTransaction($name)
    {
        return $this->handle('newrelic_name_transaction', [
            $name,
        ]);
    }

    /**
     * @param string     $message
     * @param \Exception $exception
     *
     * @return mixed
     */
    public function noticeError($message, \Exception $exception = null)
    {
        return $this->handle('newrelic_notice_error', [
            $message,
            $exception,
        ]);
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return mixed
     */
    public function recordCustomEvent($name, array $attributes)
    {
        return $this->handle('newrelic_record_custom_event', [
            $name,
            $attributes,
        ]);
    }

    /**
     * @param string $name
     * @param string $license
     * @param bool   $xmit
     *
     * @return mixed
     */
    public function setAppname($name, $license = '', $xmit = false)
    {
        return $this->handle('newrelic_set_appname', [
            $name,
            $license,
            $xmit,
        ]);
    }

    /**
     * @param string $user
     * @param string $account
     * @param string $product
     *
     * @return mixed
     */
    public function setUserAttributes($user = '', $account = '', $product = '')
    {
        return $this->handle('newrelic_set_user_attributes', [
            $user,
            $account,
            $product,
        ]);
    }

    /**
     * @param string $appName
     * @param string $license
     *
     * @return bool|mixed
     */
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
