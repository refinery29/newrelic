<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
