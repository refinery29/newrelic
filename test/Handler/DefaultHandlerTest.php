<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic\Test\Handler;

use Refinery29\NewRelic\Handler\DefaultHandler;
use Refinery29\NewRelic\Handler\Handler;
use Refinery29\Test\Util\TestHelper;

final class DefaultHandlerTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testImplementsHandlerInterface()
    {
        $this->assertImplements(Handler::class, DefaultHandler::class);
    }

    public function testHandleCallsFunctionWithArguments()
    {
        $functionName = 'strpos';
        $arguments = [
            'foobarbaz',
            'bar',
            0,
        ];

        $handler = new DefaultHandler();

        $expected = \call_user_func_array($functionName, $arguments);

        $this->assertSame($expected, $handler->handle($functionName, $arguments));
    }

    public function testIsExtensionLoaded()
    {
        $handler = new DefaultHandler();

        $this->assertSame($this->isExtensionLoaded(), $handler->isExtensionLoaded());
    }

    /**
     * @return bool
     */
    private function isExtensionLoaded()
    {
        return \extension_loaded('newrelic') && function_exists('newrelic_set_appname');
    }
}
