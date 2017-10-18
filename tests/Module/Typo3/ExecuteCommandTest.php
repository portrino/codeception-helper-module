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

use Codeception\Lib\ModuleContainer;
use Codeception\Module\Asserts;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Portrino\Codeception\Tests\Module\Typo3Test;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3ExecuteCommandTest
 *
 * @package Portrino\Codeception\Tests\Module\Typo3
 */
class ExecuteCommandTest extends Typo3Test
{

    protected function setUp()
    {
        parent::setUp();

        $this->container = $this->prophesize(ModuleContainer::class);
        $this->process = $this->prophesize(Process::class);
        $this->builder = $this->prophesize(ProcessBuilder::class);
        $this->asserts = $this->prophesize(Asserts::class);

        $tmpBuilder = new ProcessBuilder();
        $cmd = $tmpBuilder
            ->setPrefix(self::$typo3cmsPath)
            ->setArguments(
                [
                    Typo3Command::DATABASE_UPDATE_SCHEMA
                ]
            )
            ->getProcess()
            ->getCommandLine();

        $this->process->getCommandLine()->willReturn($cmd);
        $this->process->run()->shouldBeCalledTimes(1);

        $this->builder->setPrefix(self::$typo3cmsPath)->shouldBeCalled();
        $this->builder->setArguments([Typo3Command::DATABASE_UPDATE_SCHEMA])->shouldBeCalled();
        $this->builder->getProcess()->willReturn($this->process);
    }


    /**
     * @test
     */
    public function executeCommandSuccessful()
    {
        $this->process->isSuccessful()->willReturn(true);
        $this->process->getOutput()->willReturn(self::DEBUG_SUCCESS);
        $this->asserts->assertTrue(true)->shouldBeCalled();

        $this->typo3 = new Typo3($this->container->reveal());
        $this->typo3->setBuilder($this->builder->reveal());
        $this->typo3->_inject($this->asserts->reveal());

        $this->typo3->executeCommand(Typo3Command::DATABASE_UPDATE_SCHEMA);
    }

    /**
     * @test
     */
    public function executeCommandFailure()
    {
        $this->process->isSuccessful()->willReturn(false);
        $this->process->getErrorOutput()->willReturn(self::DEBUG_ERROR);
        $this->asserts->assertTrue(false)->shouldBeCalled();

        $this->typo3 = new Typo3($this->container->reveal());
        $this->typo3->setBuilder($this->builder->reveal());
        $this->typo3->_inject($this->asserts->reveal());

        $this->typo3->executeCommand(Typo3Command::DATABASE_UPDATE_SCHEMA);
    }
}
