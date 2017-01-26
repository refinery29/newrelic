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
use Refinery29\Test\Util\TestHelper;

final class AgentTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testImplementsAgentInterface()
    {
        $this->assertImplements(AgentInterface::class, Agent::class);
    }

    public function testConstructCreatesHandler()
    {
        $agent = new Agent();

        $this->assertAttributeInstanceOf(Handler\DefaultHandler::class, 'handler', $agent);
    }

    public function testConstructSetsHandler()
    {
        $handler = $this->createHandlerMock();

        $agent = new Agent($handler);

        $this->assertAttributeSame($handler, 'handler', $agent);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $key
     */
    public function testAddCustomParameterRejectsInvalidKey($key)
    {
        $this->expectException(\InvalidArgumentException::class);

        $value = $this->getFaker()->randomNumber();

        $agent = new Agent($this->createHandlerMock());

        $agent->addCustomParameter(
            $key,
            $value
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param string $key
     */
    public function testAddCustomParameterRejectsBlankKey($key)
    {
        $this->expectException(\InvalidArgumentException::class);

        $value = $this->getFaker()->randomNumber();

        $agent = new Agent($this->createHandlerMock());

        $agent->addCustomParameter(
            $key,
            $value
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidScalar::data()
     *
     * @param mixed $value
     */
    public function testAddCustomParameterRejectsInvalidValue($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        $key = $this->getFaker()->word;

        $agent = new Agent($this->createHandlerMock());

        $agent->addCustomParameter(
            $key,
            $value
        );
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

        $handler = $this->createHandlerSpy(
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

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $functionName
     */
    public function testAddCustomTracerRejectsInvalidFunctionName($functionName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->addCustomTracer($functionName);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $functionName
     */
    public function testAddCustomTracerRejectsBlankFunctionName($functionName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->addCustomTracer($functionName);
    }

    public function testAddCustomTracer()
    {
        $faker = $this->getFaker();

        $functionName = $faker->word;

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
            'newrelic_add_custom_tracer',
            [
                $functionName,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->addCustomTracer($functionName));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $flag
     */
    public function testBackgroundJobRejectsInvalidFlag($flag)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->backgroundJob($flag);
    }

    public function testBackgroundJob()
    {
        $faker = $this->getFaker();

        $flag = $faker->boolean();

        $handler = $this->createHandlerSpy('newrelic_background_job', [
            $flag,
        ]);

        $agent = new Agent($handler);

        $agent->backgroundJob($flag);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $enable
     */
    public function testCaptureParamsRejectsInvalidEnable($enable)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->captureParams($enable);
    }

    public function testCaptureParams()
    {
        $faker = $this->getFaker();

        $enable = $faker->boolean();

        $handler = $this->createHandlerSpy('newrelic_capture_params', [
            $enable,
        ]);

        $agent = new Agent($handler);

        $agent->captureParams($enable);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $metricName
     */
    public function testCustomMetricRejectsInvalidMetricName($metricName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $value = $this->getFaker()->randomNumber();

        $agent = new Agent($this->createHandlerMock());

        $agent->customMetric(
            $metricName,
            $value
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param string $metricName
     */
    public function testCustomMetricRejectsBlankMetricName($metricName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $value = $this->getFaker()->randomNumber();

        $agent = new Agent($this->createHandlerMock());

        $agent->customMetric(
            $metricName,
            $value
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidFloat::data()
     *
     * @param mixed $value
     */
    public function testCustomMetricRejectsInvalidValue($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        $metricName = $this->getFaker()->word;

        $agent = new Agent($this->createHandlerMock());

        $agent->customMetric(
            $metricName,
            $value
        );
    }

    public function testCustomMetric()
    {
        $faker = $this->getFaker();

        $name = $faker->word;
        $value = $faker->randomFloat();

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
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

        $handler = $this->createHandlerSpy(
            'newrelic_disable_autorum',
            [],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->disableAutoRum());
    }

    public function testEndOfTransaction()
    {
        $handler = $this->createHandlerSpy('newrelic_end_of_transaction');

        $agent = new Agent($handler);

        $agent->endOfTransaction();
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $ignore
     */
    public function testEndTransactionRejectsInvalidIgnore($ignore)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->endTransaction($ignore);
    }

    public function testEndTransaction()
    {
        $ignore = $this->getFaker()->boolean();

        $handler = $this->createHandlerSpy('newrelic_end_transaction', [
            $ignore,
        ]);

        $agent = new Agent($handler);

        $this->assertNull($agent->endTransaction($ignore));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $includeTags
     */
    public function testGetBrowserTimingFooterRejectsInvalidIncludeTags($includeTags)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->getBrowserTimingFooter($includeTags);
    }

    public function testGetBrowserTimingFooter()
    {
        $faker = $this->getFaker();

        $includeTags = $faker->boolean();
        $result = $faker->text();

        $handler = $this->createHandlerSpy(
            'newrelic_get_browser_timing_footer',
            [
                $includeTags,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->getBrowserTimingFooter($includeTags));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $includeTags
     */
    public function testGetBrowserTimingHeaderRejectsInvalidIncludeTags($includeTags)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->getBrowserTimingHeader($includeTags);
    }

    public function testGetBrowserTimingHeader()
    {
        $faker = $this->getFaker();

        $includeTags = $faker->boolean();
        $result = $faker->text();

        $handler = $this->createHandlerSpy(
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
        $handler = $this->createHandlerSpy('newrelic_ignore_apdex');

        $agent = new Agent($handler);

        $agent->ignoreApdex();
    }

    public function testIgnoreTransaction()
    {
        $handler = $this->createHandlerSpy('newrelic_ignore_transaction');

        $agent = new Agent($handler);

        $agent->ignoreTransaction();
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $name
     */
    public function testNameTransactionRejectsInvalidName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->nameTransaction($name);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $name
     */
    public function testNameTransactionRejectsBlankName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->nameTransaction($name);
    }

    public function testNameTransaction()
    {
        $faker = $this->getFaker();

        $name = $faker->word;

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
            'newrelic_name_transaction',
            [
                $name,
            ],
            $result
        );

        $agent = new Agent($handler);

        $this->assertSame($result, $agent->nameTransaction($name));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $message
     */
    public function testNoticeErrorRejectsInvalidMessage($message)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->noticeError($message);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $message
     */
    public function testNoticeErrorRejectsBlankMessage($message)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->noticeError($message);
    }

    public function testNoticeError()
    {
        $faker = $this->getFaker();

        $message = $faker->sentence();
        $exception = new \InvalidArgumentException($faker->sentence());

        $handler = $this->createHandlerSpy('newrelic_notice_error', [
            $message,
            $exception,
        ]);

        $agent = new Agent($handler);

        $agent->noticeError($message, $exception);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $name
     */
    public function testRecordCustomEventRejectsInvalidName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $attributes = \array_combine(
            $faker->words(),
            $faker->words()
        );

        $agent = new Agent($this->createHandlerMock());

        $agent->recordCustomEvent(
            $name,
            $attributes
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $name
     */
    public function testRecordCustomEventRejectsBlankName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $attributes = \array_combine(
            $faker->words(),
            $faker->words()
        );

        $agent = new Agent($this->createHandlerMock());

        $agent->recordCustomEvent(
            $name,
            $attributes
        );
    }

    public function testRecordCustomEventRejectsNumericAttributeKeys()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $name = $faker->word;
        $attributes = $faker->words();

        $agent = new Agent($this->createHandlerMock());

        $agent->recordCustomEvent(
            $name,
            $attributes
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidScalar::data()
     *
     * @param mixed $value
     */
    public function testRecordCustomEventRejectsInvalidScalarAttributeValues($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $name = $faker->word;
        $key = $faker->word;

        $attributes = [
            $key => $value,
        ];

        $agent = new Agent($this->createHandlerMock());

        $agent->recordCustomEvent(
            $name,
            $attributes
        );
    }

    public function testRecordCustomEvent()
    {
        $faker = $this->getFaker();

        $name = $faker->word;
        $attributes = \array_combine(
            $faker->words(),
            $faker->words()
        );

        $handler = $this->createHandlerSpy('newrelic_record_custom_event', [
            $name,
            $attributes,
        ]);

        $agent = new Agent($handler);

        $agent->recordCustomEvent($name, $attributes);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $name
     */
    public function testSetAppNameRejectsInvalidName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $license = $faker->sentence();
        $xmit = $faker->boolean();

        $agent = new Agent($this->createHandlerMock());

        $agent->setAppname(
            $name,
            $license,
            $xmit
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param string $name
     */
    public function testSetAppNameRejectsBlankName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $license = $faker->sentence();
        $xmit = $faker->boolean();

        $agent = new Agent($this->createHandlerMock());

        $agent->setAppname(
            $name,
            $license,
            $xmit
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param string $license
     */
    public function testSetAppNameRejectsInvalidLicense($license)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $name = $faker->word;
        $xmit = $faker->boolean();

        $agent = new Agent($this->createHandlerMock());

        $agent->setAppname(
            $name,
            $license,
            $xmit
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $xmit
     */
    public function testSetAppNameRejectsInvalidXmit($xmit)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $name = $faker->word;
        $license = $faker->sentence();

        $agent = new Agent($this->createHandlerMock());

        $agent->setAppname(
            $name,
            $license,
            $xmit
        );
    }

    public function testSetAppName()
    {
        $faker = $this->getFaker();

        $name = $faker->word;
        $licence = $faker->sentence();
        $xmit = $faker->boolean();

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
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

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $user
     */
    public function testSetUserAttributesRejectsInvalidUser($user)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->setUserAttributes($user);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $account
     */
    public function testSetUserAttributesRejectsInvalidAccount($account)
    {
        $this->expectException(\InvalidArgumentException::class);

        $user = $this->getFaker()->word;

        $agent = new Agent($this->createHandlerMock());

        $agent->setUserAttributes(
            $user,
            $account
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $product
     */
    public function testSetUserAttributesRejectsInvalidProduct($product)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $user = $faker->word;
        $account = $faker->word;

        $agent = new Agent($this->createHandlerMock());

        $agent->setUserAttributes(
            $user,
            $account,
            $product
        );
    }

    public function testSetUserAttributes()
    {
        $faker = $this->getFaker();

        $user = $faker->userName;
        $account = $faker->word;
        $product = $faker->word;

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
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

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $appName
     */
    public function testStartTransactionRejectsInvalidAppName($appName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->startTransaction($appName);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $appName
     */
    public function testStartTransactionRejectsBlankAppName($appName)
    {
        $this->expectException(\InvalidArgumentException::class);

        $agent = new Agent($this->createHandlerMock());

        $agent->startTransaction($appName);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $license
     */
    public function testStartTransactionRejectsInvalidLicense($license)
    {
        $this->expectException(\InvalidArgumentException::class);

        $appName = $this->getFaker()->word;

        $agent = new Agent($this->createHandlerMock());

        $agent->startTransaction(
            $appName,
            $license
        );
    }

    public function testStartTransaction()
    {
        $faker = $this->getFaker();

        $name = $faker->word;
        $licence = $faker->sentence();

        $result = $faker->boolean();

        $handler = $this->createHandlerSpy(
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
    private function createHandlerMock()
    {
        return $this->createMock(Handler\Handler::class);
    }

    /**
     * @param string $functionName
     * @param array  $arguments
     * @param mixed  $result
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Handler\Handler
     */
    private function createHandlerSpy($functionName, array $arguments = [], $result = null)
    {
        $handler = $this->createHandlerMock();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with(
                $this->identicalTo($functionName),
                $this->identicalTo($arguments)
            )
            ->willReturn($result);

        return $handler;
    }
}
