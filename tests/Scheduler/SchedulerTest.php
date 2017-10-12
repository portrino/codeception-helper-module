<?php

namespace Portrino\Codeception\Tests\Scheduler;

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

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Scheduler\Scheduler;
use Portrino\Codeception\Scheduler\Task;
use Portrino\Codeception\Scheduler\TaskResult;

/**
 * Class SchedulerTest
 * @package Portrino\Codeception\Tests\Scheduler
 */
class SchedulerTest extends TestCase
{
    /**
     * @var Scheduler|PHPUnit_Framework_MockObject_MockObject
     */
    protected $scheduler;

    /**
     * @var TaskResult|PHPUnit_Framework_MockObject_MockObject
     */
    protected $taskResult;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $cmdPattern = '%s scheduler:run %d --force 2>&1; echo $?';

    /**
     * @var string
     */
    protected $typo3cmsPath = '../../../../../../bin/typo3cms';


    /**
     * @test
     */
    public function runTask()
    {
        $this->scheduler = $this
            ->getMockBuilder(Scheduler::class)
            ->setMethods(
                [
                    'execute',
                ]
            )
            ->getMock();

        $task = new Task($this->id, $this->cmdPattern);
        $run = $this->scheduler->run($task);

        $arguments = [];
        array_push($arguments, $this->typo3cmsPath, $this->id);
        $cmd = vsprintf(
            $task->cmdPattern,
            $arguments
        );
        $exec = shell_exec($cmd);
        $execute = TaskResult::fromStatusString($exec);

        $this->scheduler
            ->expects(static::any())
            ->method('execute')
            ->willReturn($execute);

        static::assertEquals($run, $this->scheduler->run($task));
    }

    /**
     * @test
     */
    public function taskWasSuccessful()
    {
        $this->scheduler = $this
            ->getMockBuilder(Scheduler::class)
            ->setMethods(
                [
                    'wasSuccessful',
                ]
            )
            ->getMock();

        $this->taskResult = $this
            ->getMockBuilder(TaskResult::class)
            ->setMethods(
                [
                    'isSuccessful',
                ]
            )
            ->getMock();

        $this->taskResult
            ->expects(static::any())
            ->method('isSuccessful')
            ->willReturn(True);


        $this->scheduler
            ->expects(static::any())
            ->method('wasSuccessful')
            ->willReturn($this->taskResult->isSuccessful());

        $wasSuccessful = $this->scheduler->wasSuccessful();

        static::assertTrue($wasSuccessful);
    }
}
