<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic;

/**
 * @link https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-api
 */
interface AgentInterface
{
    /**
     * Add a custom parameter to the current web transaction with the specified value.
     *
     * For example, you can add a customer's full name from your customer database. This parameter is shown in any
     * transaction trace that results from this transaction.
     *
     * If the value given is a float with a value of NaN, Infinity, denorm or negative zero, the behavior of this
     * function is undefined. For other floating point values, New Relic may discard 1 or more bits of precision (ULPs)
     * from the given value.
     *
     * This function will return true if the parameter was added successfully.
     *
     * String values will be truncated to 255 characters.
     *
     * If you are using your custom parameters/attributes in Insights, avoid using any of Insights' reserved words for
     * naming them.
     *
     * @link https://docs.newrelic.com/docs/insights/new-relic-insights/decorating-events/insights-custom-attributes#keywords
     *
     * @param string                $key
     * @param string|int|float|bool $value
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function addCustomParameter($key, $value);

    /**
     * API equivalent of the newrelic.transaction_tracer.custom setting.
     *
     * It allows you to add user-defined functions or methods to the list to be instrumented. Internal PHP functions
     * cannot have custom tracing.
     *
     * function_name can be formatted either as "function_name" for procedural functions, or as "ClassName::method" for
     * methods. Both static and instance methods will be instrumented if the method syntax is used.
     *
     * This function will return true if the tracer was added successfully.
     *
     * @param string $functionName
     *
     * @return bool
     */
    public function addCustomTracer($functionName);

    /**
     * If the flag argument is set to true or omitted, the current transaction is marked as a background job.
     * If flag is set to false, then the transaction is marked as a web transaction.
     *
     * @link https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-newrelicini-settings#inivar-tt-custom
     *
     * @param bool $flag
     *
     * @throws \InvalidArgumentException
     */
    public function backgroundJob($flag = true);

    /**
     * If enable is omitted or set to true, this enables the capturing of URL parameters for displaying in transaction
     * traces.
     *
     * This will override the newrelic.capture_params setting.
     *
     * Note: Until version 2.1.3 of the PHP agent, this function was called newrelic_enable_params. Although this alias
     * still exists, it is deprecated and will be removed in the future.
     *
     * @link https://docs.newrelic.com/docs/agents/php-agent/configuration/php-agent-newrelicini-settings#inivar-capture_params
     *
     * @param bool $enable
     *
     * @throws \InvalidArgumentException
     */
    public function captureParams($enable = true);

    /**
     * Adds a custom metric with the specified name and value, which is of type double.
     *
     * Values saved are assumed to be milliseconds, so "4" will be stored as ".004" in our system. Your custom metrics
     * can then be used in custom dashboards and custom views in the New Relic user interface. Name your custom metrics
     * with a Custom/ prefix (for example, Custom/MyMetric). This will make them easily usable in custom dashboards.
     * If the value is NaN, Infinity, denorm or negative zero, the behavior of this function is undefined. New Relic
     * may discard 1 or more bits of precision (ULPs) from the given value.
     *
     * This function will return true if the metric was added successfully.
     *
     * Avoid creating too many unique custom metric names. New Relic limits the total number of custom metrics you can
     * use (not the total you can report for each of these custom metrics). Exceeding more than 2000 unique custom
     * metric names can cause automatic clamps that will affect other data.
     *
     * @param string $metricName
     * @param float  $value
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function customMetric($metricName, $value);

    /**
     * Prevents the output filter from attempting to insert the JavaScript for page load timing (sometimes referred to
     * as real user monitoring or RUM) for this current transaction.
     *
     * This function will always return true.
     *
     * @return bool
     */
    public function disableAutoRum();

    /**
     * Stop recording the web transaction immediately.
     *
     * Usually used when a page is done with all computation and is about to stream data (file download, audio or video
     * streaming, etc.) and you don't want the time taken to stream to be counted as part of the transaction. This is
     * especially relevant when the time taken to complete the operation is completely outside the bounds of your
     * application. For example, a user on a very slow connection may take a very long time to download even small
     * files, and you wouldn't want that download time to skew the real transaction time.
     */
    public function endOfTransaction();

    /**
     * Despite being similar in name to newrelic_end_of_transaction above, this call serves a very different purpose.
     *
     * newrelic_end_of_transaction simply marks the end time of the transaction but takes no other action. The
     * transaction is still only sent to the daemon when the PHP engine determines that the script is done executing
     * and is shutting down. This function on the other hand, causes the current transaction to end immediately, and
     * will ship all of the metrics gathered thus far to the daemon unless the ignore parameter is set to true. In
     * effect this call simulates what would happen when PHP terminates the current transaction. This is most commonly
     * used in command line scripts that do some form of job queue processing. You would use this call at the end of
     * processing a single job task, and begin a new transaction (see below) when a new task is pulled off the queue.
     *
     * Normally, when you end a transaction you want the metrics that have been gathered thus far to be recorded.
     * However, there are times when you may want to end a transaction without doing so. In this case use the second
     * form of the function and set ignore to true.
     *
     * This function will return true if the transaction was successfully ended and data was sent to the New Relic
     * daemon.
     *
     * @param bool $ignore
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function endTransaction($ignore = false);

    /**
     * Returns the JavaScript string to inject at the very end of the HTML output for page load timing (sometimes
     * referred to as real user monitoring or RUM). If include_tags omitted or set to true, the returned JavaScript
     * string will be enclosed in a <script> tag.
     *
     * @param bool $includeTags
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getBrowserTimingFooter($includeTags = false);

    /**
     * Returns the JavaScript string to inject as part of the header for page load timing (sometimes referred to as
     * real user monitoring or RUM). If include_tags are omitted or set to true, the returned JavaScript string will be
     * enclosed in a <script> tag.
     *
     * @param bool $includeTags
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getBrowserTimingHeader($includeTags = false);

    /**
     * Do not generate Apdex metrics for this transaction.
     *
     * This is useful when you have either very short or very long transactions (such as file downloads) that can skew
     * your Apdex score.
     */
    public function ignoreApdex();

    /**
     * Do not generate metrics for this transaction.
     *
     * This is useful when you have transactions that are particularly slow for known reasons and you do not want them
     * always being reported as the transaction trace or skewing your site averages.
     */
    public function ignoreTransaction();

    /**
     * Sets the name of the transaction to the specified name.
     *
     * This can be useful if you have implemented your own dispatching scheme and want to name transactions according
     * to their purpose rather than their URL.
     *
     * This function will return true if the transaction name was successfully changed. If false is returned, please
     * check the agent log for more information.
     *
     * Call this function as early as possible. It will have no effect, for example, if called after the JavaScript
     * footer for page load timing (sometimes referred to as real user monitoring or RUM) has been sent.
     *
     * Avoid creating too many unique transaction names. This will make your graphs less useful, and you may run into
     * limits we set on the number of unique transaction names per account. It also can slow down the performance of
     * your application.
     *
     * Example: Naming transactions
     *
     * You have /product/123 and /product/234. If you generate a separate transaction name for each, then New Relic
     * will store separate information for these two transaction names.
     *
     * Instead, store the transaction as /product/*, or use something significant about the code itself to name the
     * transaction, such as /Product/view. The total number of unique transaction names should be less than 1000.
     * Exceeding that is not recommended.
     *
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function nameTransaction($name);

    /**
     * Report an error at this line of code, with a complete stack trace.
     *
     * Only the exception for the last call is retained during the course of a transaction. Agent version 4.3 enhanced
     * this form to use the exception class as the category for grouping within the New Relic APM user interface.
     *
     * The exception parameter must be a valid PHP Exception class, and the stack frame recorded in that class will be
     * the one reported, rather than the stack at the time this function was called. When using this form, if the error
     * message is empty, a standard message in the same format as created by Exception::__toString() will be
     * automatically generated.
     *
     * @link https://docs.newrelic.com/docs/applications-menu/errors-dashboard
     *
     * @param string     $message
     * @param \Exception $exception
     *
     * @throws \InvalidArgumentException
     */
    public function noticeError($message, \Exception $exception = null);

    /**
     * Records a New Relic Insights custom event.
     *
     * For more information, see Inserting custom events with the PHP agent.
     *
     * The attributes parameter is expected to be an associative array: the keys should be the attribute names (which
     * may be up to 255 characters in length), and the values should be scalar values: arrays and objects are not
     * supported.
     *
     * @link https://docs.newrelic.com/docs/insights/new-relic-insights/understanding-insights/new-relic-insights
     * @link https://docs.newrelic.com/docs/insights/new-relic-insights/adding-querying-data/inserting-custom-events-new-relic-agents#php-att
     *
     * @param string $name
     * @param array  $attributes
     *
     * @throws \InvalidArgumentException
     */
    public function recordCustomEvent($name, array $attributes);

    /**
     * Sets the name of the application to name.
     *
     * The string uses the same format as newrelic.appname and can set multiple application names by separating each
     * with a semi-colon (;). However, be aware of the restriction on the application name ordering as described for
     * that setting.
     *
     * The first application name is the primary name. You can also specify up to two extra application names.
     * (However, the same application name can only ever be used once as a primary name.) Call this function as early
     * as possible. It will have no effect if called after the JavaScript footer for page load timing (sometimes
     * referred to as real user monitoring or RUM) has been sent.
     *
     * Consider setting the application name in a file loaded by PHP's auto_prepend_file  INI setting.
     *
     * If you use multiple licenses, you can also specify a license key along with the application name. An application
     * can appear in more than one account and the license key controls which account you are changing the name in. If
     * you do not wish to change the license and wish to use the third variant, simply set the license key to the empty
     * string ("").
     *
     * The xmit flag is new in PHP agent version 3.1. Usually, when you change an application name, the agent simply
     * discards the current transaction and does not send any of the accumulated metrics to the daemon. However, if you
     * want to record the metric and transaction data up to the point at which you called this function, you can
     * specify a value of true for this argument to make the agent send the transaction to the daemon. This has a very
     * slight performance impact as it takes a few milliseconds for the agent to dump its data. By default this
     * parameter is false.
     *
     * This function will return true if the application name was successfully changed.
     *
     * @link http://php.net/auto-prepend-file
     *
     * @param string $name
     * @param string $license
     * @param bool   $xmit
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function setAppname($name, $license = '', $xmit = false);

    /**
     * As of release 4.4, calling newrelic_set_user_attributes("a", "b", "c"); is equivalent to calling:
     * newrelic_add_custom_parameter("user", "a"); newrelic_add_custom_parameter("account", "b");
     * newrelic_add_custom_parameter("product", "c");.
     *
     * Previously, the three parameter strings were added to collected browser traces. All three parameters are
     * required, but may be empty strings.
     *
     * This function will return true if the attributes were added successfully.
     *
     * @param string $user
     * @param string $account
     * @param string $product
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function setUserAttributes($user = '', $account = '', $product = '');

    /**
     * If you have ended a transaction before your script terminates (perhaps due to it just having finished a task in
     * a job queue manager) and you want to start a new transaction, use this call.
     *
     * This will perform the same operations that occur when the script was first started. Of the two arguments, only
     * the application name is mandatory. However, if you are processing tasks for multiple accounts, you may also
     * provide a license for the associated account. The license set for this API call will supersede all per-directory
     * and global default licenses configured in INI files.
     *
     * This function will return true if the transaction was successfully started.
     *
     * @param string $appName
     * @param string $license
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function startTransaction($appName, $license = '');
}
