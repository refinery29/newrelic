<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\NewRelic\Test;

use Refinery29\Test\Util\TestHelper;

final class ProjectCodeTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testTestCodeIsAbstractOrFinal()
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__);
    }

    public function testProjectCodeIsAbstractOrFinal()
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__ . '/../src');
    }
}
