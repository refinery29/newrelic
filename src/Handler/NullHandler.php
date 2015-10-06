<?php

namespace Refinery29\NewRelic\Handler;

class NullHandler implements Handler
{
    public function handle($functionName, array $arguments = [])
    {
        return false;
    }
}
