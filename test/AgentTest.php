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
use Refinery29\Test\Util\Faker\GeneratorTrait;

class AgentTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

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

    /**
     * @dataProvider providerScalar
     *
     * @param mixed $value
     */
    public function testAddCustomParameter($value)
    {
        $faker = $this->getFaker();

        $key = $faker->word;

        $result = $faker->boolean();

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

    /**
     * @return \Generator
     */
    public function providerScalar()
    {
        $faker = $this->getFaker();

        $values = [
            $faker->word,
            $faker->randomNumber(),
            $faker->randomFloat(),
            $faker->boolean(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testAddCustomTracer()
    {
        $faker = $this->getFaker();

        $functionName = $faker->word;

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $flag = $faker->boolean();

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $enable = $faker->boolean();

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $name = $faker->word;
        $value = $faker->randomFloat();

        $result = $faker->boolean();

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
        $result = $this->getFaker()->boolean();

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
        $ignore = $this->getFaker()->boolean();

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
        $faker = $this->getFaker();

        $includeTags = $faker->boolean();
        $result = $faker->text();

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
        $faker = $this->getFaker();

        $includeTags = $faker->boolean();
        $result = $faker->text();

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
        $faker = $this->getFaker();

        $name = $faker->word;

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $message = $faker->sentence();
        $exception = new \InvalidArgumentException($faker->sentence());

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
        $faker = $this->getFaker();

        $name = $faker->word;
        $attributes = array_combine(
            $faker->words(),
            $faker->words()
        );

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $name = $faker->word;
        $licence = $faker->sentence();
        $xmit = $faker->boolean();

        $result = $faker->boolean();

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

        $this->assertSame($result, $agent->setAppname($name, $licence, $xmit));
    }

    public function testSetUserAttributes()
    {
        $faker = $this->getFaker();

        $user = $faker->userName;
        $account = $faker->word;
        $product = $faker->word;

        $result = $faker->boolean();

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
        $faker = $this->getFaker();

        $name = $faker->word;
        $licence = $faker->sentence();

        $result = $faker->boolean();

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
