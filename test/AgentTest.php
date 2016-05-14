<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic\Test;

use Refinery29\NewRelic\Agent;
use Refinery29\NewRelic\AgentInterface;
use Refinery29\NewRelic\Handler;

class AgentTest extends \PHPUnit_Framework_TestCase
{
    public function testIsFinal()
    {
        $reflection = new \ReflectionClass(Agent::class);

        $this->assertTrue($reflection->isFinal());
    }

    public function testImplementsAgentInterface()
    {
        $reflection = new \ReflectionClass(Agent::class);

        $this->assertTrue($reflection->implementsInterface(AgentInterface::class));
    }

    public function testConstructCreatesHandler()
    {
        $agent = new Agent();

        $this->assertAttributeInstanceOf(Handler\DefaultHandler::class, 'handler', $agent);
    }

    public function testConstructSetsHandler()
    {
        $handler = $this->getHandlerMock();

        $agent = new Agent($handler);

        $this->assertAttributeSame($handler, 'handler', $agent);
    }

    public function testAddCustomParameter()
    {
        $key = 'foo';
        $value = 'bar';

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_add_custom_parameter',
            [
                $key,
                $value,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->addCustomParameter($key, $value));
    }

    public function testAddCustomTracer()
    {
        $functionName = 'bar';

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_add_custom_tracer',
            [
                $functionName,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->addCustomTracer($functionName));
    }

    public function testBackgroundJob()
    {
        $flag = true;

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_background_job',
            [
                $flag,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->backgroundJob($flag));
    }

    public function testCaptureParams()
    {
        $enable = true;

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_capture_params',
            [
                $enable,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->captureParams($enable));
    }

    public function testCustomMetric()
    {
        $name = 'foo';
        $value = 9000;

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_custom_metric',
            [
                $name,
                $value,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->customMetric($name, $value));
    }

    public function testDisableAutoRum()
    {
        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_disable_autorum',
            [],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->disableAutoRum());
    }

    public function testEndOfTransaction()
    {
        $handler = $this->getHandlerSpy(
            'newrelic_end_of_transaction',
            []
        );

        $agent = new Agent($handler);

        $this->assertNull($agent->endOfTransaction());
    }

    public function testEndTransaction()
    {
        $ignore = false;

        $handler = $this->getHandlerSpy(
            'newrelic_end_transaction',
            [
                $ignore,
            ]
        );

        $agent = new Agent($handler);

        $this->assertNull($agent->endTransaction($ignore));
    }

    public function testGetBrowserTimingFooter()
    {
        $includeTags = false;

        $result = '<p>Foo</p>';

        $handler = $this->getHandlerSpy(
            'newrelic_get_browser_timing_footer',
            [
                $includeTags,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->getBrowserTimingFooter($includeTags));
    }

    public function testGetBrowserTimingHeader()
    {
        $includeTags = false;

        $result = '<p>Foo</p>';

        $handler = $this->getHandlerSpy(
            'newrelic_get_browser_timing_header',
            [
                $includeTags,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->getBrowserTimingHeader($includeTags));
    }

    public function testIgnoreApdex()
    {
        $handler = $this->getHandlerSpy(
            'newrelic_ignore_apdex',
            []
        );

        $agent = new Agent($handler);

        $this->assertNull($agent->ignoreApdex());
    }

    public function testIgnoreTransaction()
    {
        $handler = $this->getHandlerSpy(
            'newrelic_ignore_transaction',
            []
        );

        $agent = new Agent($handler);

        $this->assertNull($agent->ignoreTransaction());
    }

    public function testNameTransaction()
    {
        $name = 'foo';

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_name_transaction',
            [
                $name,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->nameTransaction($name));
    }

    public function testNoticeError()
    {
        $message = 'foo';
        $exception = new \InvalidArgumentException('bar');

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_notice_error',
            [
                $message,
                $exception,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->noticeError($message, $exception));
    }

    public function testRecordCustomEvent()
    {
        $name = 'foo';
        $attributes = [
            'bar' => 'baz',
            'qux' => 'vzy',
        ];

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_record_custom_event',
            [
                $name,
                $attributes,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->recordCustomEvent($name, $attributes));
    }

    public function testSetAppName()
    {
        $name = 'foo';
        $licence = 'bar9000';
        $xmit = false;

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_set_appname',
            [
                $name,
                $licence,
                $xmit,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->setAppName($name, $licence, $xmit));
    }

    public function testSetUserAttributes()
    {
        $user = 'foo';
        $account = 'bar';
        $product = 'baz';

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_set_user_attributes',
            [
                $user,
                $account,
                $product,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->setUserAttributes($user, $account, $product));
    }

    public function testStartTransaction()
    {
        $name = 'foo';
        $licence = 'bar9000';

        $result = true;

        $handler = $this->getHandlerSpy(
            'newrelic_start_transaction',
            [
                $name,
                $licence,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->startTransaction($name, $licence));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Handler\Handler
     */
    private function getHandlerMock()
    {
        return $this->getMockBuilder(Handler\Handler::class)->getMock();
    }

    /**
     * @param string $functionName
     * @param array  $arguments
     * @param mixed  $result
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Handler\Handler
     */
    private function getHandlerSpy($functionName, array $arguments = [], $result = null)
    {
        $handler = $this->getHandlerMock();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with(
                $this->identicalTo($functionName),
                $this->identicalTo($arguments)
            )
            ->willReturn($result)
        ;

        return $handler;
    }
}
