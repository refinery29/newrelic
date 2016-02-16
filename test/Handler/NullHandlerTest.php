<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic\Test\Handler;

use Refinery29\NewRelic\Handler\Handler;
use Refinery29\NewRelic\Handler\NullHandler;

class NullHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsInterface()
    {
        $handler = new NullHandler();

        $this->assertInstanceOf(Handler::class, $handler);
    }

    public function testHandleReturnsFalse()
    {
        $functionName = 'strpos';
        $arguments = [
            'foobarbaz',
            'bar',
            0,
        ];

        $handler = new NullHandler();

        $this->assertFalse($handler->handle($functionName, $arguments));
    }
}
