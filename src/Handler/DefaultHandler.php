<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic\Handler;

final class DefaultHandler implements Handler
{
    public function handle($functionName, array $arguments = [])
    {
        return \call_user_func_array($functionName, $arguments);
    }

    /**
     * @return bool
     */
    public function isExtensionLoaded()
    {
        return \extension_loaded('newrelic') && function_exists('newrelic_set_appname');
    }
}
