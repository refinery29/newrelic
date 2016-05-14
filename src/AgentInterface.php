<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic;

interface AgentInterface
{
    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function addCustomParameter($key, $value);

    /**
     * @param string $functionName
     *
     * @return mixed
     */
    public function addCustomTracer($functionName);

    /**
     * @param bool $flag
     *
     * @return mixed
     */
    public function backgroundJob($flag = true);

    /**
     * @param bool $enable
     *
     * @return mixed
     */
    public function captureParams($enable = true);

    /**
     * @param string $metricName
     * @param mixed  $value
     *
     * @return mixed
     */
    public function customMetric($metricName, $value);

    /**
     * @return mixed
     */
    public function disableAutoRum();

    /**
     * @return mixed
     */
    public function endOfTransaction();

    /**
     * @param bool $ignore
     *
     * @return mixed
     */
    public function endTransaction($ignore = false);

    /**
     * @param bool $includeTags
     *
     * @return mixed
     */
    public function getBrowserTimingFooter($includeTags = false);

    /**
     * @param bool $includeTags
     *
     * @return mixed
     */
    public function getBrowserTimingHeader($includeTags = false);

    /**
     * @return mixed
     */
    public function ignoreApdex();

    /**
     * @return mixed
     */
    public function ignoreTransaction();

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function nameTransaction($name);

    /**
     * @param string     $message
     * @param \Exception $exception
     *
     * @return mixed
     */
    public function noticeError($message, \Exception $exception = null);

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return mixed
     */
    public function recordCustomEvent($name, array $attributes);

    /**
     * @param string $name
     * @param string $license
     * @param bool   $xmit
     *
     * @return mixed
     */
    public function setAppname($name, $license = '', $xmit = false);

    /**
     * @param string $user
     * @param string $account
     * @param string $product
     *
     * @return mixed
     */
    public function setUserAttributes($user = '', $account = '', $product = '');

    /**
     * @param string $appName
     * @param string $license
     *
     * @return bool|mixed
     */
    public function startTransaction($appName, $license = '');
}
