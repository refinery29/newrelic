<?php

namespace Refinery29\NewRelic\Test\Handler;

use Refinery29\NewRelic\Handler\DefaultHandler;
use Refinery29\NewRelic\Handler\Handler;

class DefaultHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsInterface()
    {
        $handler = new DefaultHandler();

        $this->assertInstanceOf(Handler::class, $handler);
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

        $expected = call_user_func_array($functionName, $arguments);

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
        return extension_loaded('newrelic') && function_exists('newrelic_set_appname');
    }
}
