<?php

namespace Portrino\Codeception\Tests\Module\Typo3;

/*
 * This file is part of the Codeception Helper Module project
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read
 * LICENSE file that was distributed with this source code.
 *
 */

use Codeception\Lib\Di;
use Codeception\Module\Asserts;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3Test
 *
 * @package Portrino\Codeception\Tests\Module\Typo3
 */
class Typo3ExecuteSchedulerTaskTest extends TestCase
{
    /**
     * @var Typo3|PHPUnit_Framework_MockObject_MockObject
     */
    protected $typo3;

    /**
     * @var array
     */
    protected $moduleConfig;

    const DEBUG_EXECUTE = 'Execute';
    const DEBUG_SUCCESS = 'Success';
    const DEBUG_ERROR = 'Error';

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->typo3 = $this
            ->getMockBuilder(Typo3::class)
            ->setMethods(
                [
                    'executeCommand'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->typo3
            ->expects(static::once())
            ->method('executeCommand')
            ->with(Typo3Command::SCHEDULER_RUN, ['task-id' => 1, 'force' => true], ['foo' => 'bar']);
    }

    /**
     * @test
     */
    public function executeSchedulerTaskSuccesful()
    {
        $this->typo3->executeSchedulerTask(1, true, ['foo' => 'bar']);
    }
}
