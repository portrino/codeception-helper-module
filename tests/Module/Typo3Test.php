<?php

namespace Portrino\Codeception\Tests\Module;

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
 * @package Portrino\Codeception\Tests\Module
 */
class Typo3Test extends TestCase
{
    /**
     * @var Typo3|PHPUnit_Framework_MockObject_MockObject
     */
    protected $typo3;

    /**
     * @var ProcessBuilder|PHPUnit_Framework_MockObject_MockObject
     */
    protected $builder;

    /**
     * @var Di
     */
    protected $di;

    /**
     * @var array
     */
    protected $moduleConfig;

    /**
     * @var
     */
    protected $typo3cmsPath;

    /**
     * @var Asserts|PHPUnit_Framework_MockObject_MockObject
     */
    protected $asserts;

    const DEBUG_EXECUTE = 'Execute';
    const DEBUG_SUCCESS = 'Success';
    const DEBUG_ERROR = 'Error';

    /**
     * @test
     */
    public function executeCommandSuccessful()
    {
        $this->typo3 = $this
            ->getMockBuilder(Typo3::class)
            ->setMethods(
                [
                    'debugSection',
                    'createBuilder'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->asserts = $this
            ->getMockBuilder(Asserts::class)
            ->setMethods(
                [
                    'assertTrue'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->asserts
            ->expects(static::once())
            ->method('assertTrue')
            ->with(true);

        $this->builder = $this
            ->getMockBuilder(ProcessBuilder::class)
            ->setMethods(
                [
                    'getProcess'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $process = $this
            ->getMockBuilder(Process::class)
            ->setMethods(
                [
                    'run',
                    'isSuccessful',
                    'getOutput',
                    'getErrorOutput',
                    'getCommandLine'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $process
            ->expects(static::once())
            ->method('run')
            ->willReturn(Typo3::EXIT_STATUS_SUCCESS);

        $process
            ->expects(static::any())
            ->method('isSuccessful')
            ->willReturn(true);

        $process
            ->expects(static::any())
            ->method('getOutput')
            ->willReturn('SUCCESS');

        $process
            ->expects(static::any())
            ->method('getErrorOutput')
            ->willReturn('FAILURE');

        $this->builder
            ->expects(static::once())
            ->method('getProcess')
            ->willReturn($process);

        $this->typo3
            ->expects(static::any())
            ->method('createBuilder')
            ->willReturn($this->builder);

        $tmpBuilder = new ProcessBuilder();
        $cmd = $tmpBuilder
            ->setPrefix('../../../../../../bin/typo3cms')
            ->setArguments(
                [
                    Typo3Command::DATABASE_UPDATE_SCHEMA
                ]
            )
            ->getProcess()
            ->getCommandLine();

        $process
            ->expects(static::any())
            ->method('getCommandLine')
            ->willReturn($cmd);

        $this->typo3
            ->expects(static::at(1))
            ->method('debugSection')
            ->with('Execute', $cmd);

        $this->typo3
            ->expects(static::at(2))
            ->method('debugSection')
            ->with('Success', 'SUCCESS');


        $this->typo3->_inject($this->asserts);

        $this->typo3->executeCommand(Typo3Command::DATABASE_UPDATE_SCHEMA);
    }

    /**
     * @test
     */
    public function executeCommandFailure()
    {
        $this->typo3 = $this
            ->getMockBuilder(Typo3::class)
            ->setMethods(
                [
                    'debugSection',
                    'createBuilder'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->asserts = $this
            ->getMockBuilder(Asserts::class)
            ->setMethods(
                [
                    'assertTrue'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $this->asserts
            ->expects(static::once())
            ->method('assertTrue')
            ->with(false);

        $this->builder = $this
            ->getMockBuilder(ProcessBuilder::class)
            ->setMethods(
                [
                    'getProcess'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $process = $this
            ->getMockBuilder(Process::class)
            ->setMethods(
                [
                    'run',
                    'isSuccessful',
                    'getOutput',
                    'getErrorOutput',
                    'getCommandLine'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $process
            ->expects(static::once())
            ->method('run')
            ->willReturn(Typo3::EXIT_STATUS_SUCCESS);

        $process
            ->expects(static::any())
            ->method('isSuccessful')
            ->willReturn(false);

        $process
            ->expects(static::any())
            ->method('getOutput')
            ->willReturn('SUCCESS');

        $process
            ->expects(static::any())
            ->method('getErrorOutput')
            ->willReturn('FAILURE');

        $this->builder
            ->expects(static::once())
            ->method('getProcess')
            ->willReturn($process);

        $this->typo3
            ->expects(static::any())
            ->method('createBuilder')
            ->willReturn($this->builder);

        $tmpBuilder = new ProcessBuilder();
        $cmd = $tmpBuilder
            ->setPrefix('../../../../../../bin/typo3cms')
            ->setArguments(
                [
                    Typo3Command::DATABASE_UPDATE_SCHEMA
                ]
            )
            ->getProcess()
            ->getCommandLine();

        $process
            ->expects(static::any())
            ->method('getCommandLine')
            ->willReturn($cmd);

        $this->typo3
            ->expects(static::at(1))
            ->method('debugSection')
            ->with('Execute', $cmd);

        $this->typo3
            ->expects(static::at(2))
            ->method('debugSection')
            ->with('Error', 'FAILURE');


        $this->typo3->_inject($this->asserts);

        $this->typo3->executeCommand(Typo3Command::DATABASE_UPDATE_SCHEMA);
    }

    /**
     * @test
     */
    public function executeSchedulerTask()
    {
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
        $this->typo3->executeSchedulerTask(1, true, ['foo' => 'bar']);
    }

    /**
     * @test
     */
    public function flushCache()
    {
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
            ->with(Typo3Command::CACHE_FLUSH, ['force' => true, 'files-only' => true]);

        $this->typo3->flushCache(true, true);
    }

    /**
     * @test
     */
    public function flushCacheGroups()
    {
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
            ->with(Typo3Command::CACHE_FLUSH_GROUPS, ['groups' => 'pages, system']);

        $this->typo3->flushCacheGroups('pages, system');
    }
}
