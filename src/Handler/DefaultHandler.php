<?php

namespace Refinery29\NewRelic\Handler;

class DefaultHandler implements Handler
{
    public function handle($functionName, array $arguments = [])
    {
        return call_user_func_array($functionName, $arguments);
    }

    /**
     * @return bool
     */
    public function isExtensionLoaded()
    {
        return extension_loaded('newrelic') && function_exists('newrelic_set_appname');
    }
}
