<?php

namespace Refinery29\NewRelic\Handler;

interface Handler
{
    /**
     * @param string $functionName
     * @param array  $arguments
     *
     * @return mixed
     */
    public function handle($functionName, array $arguments = []);
}
