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
use Codeception\TestInterface;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Portrino\Codeception\Tests\Module\Typo3Test;
use Prophecy\Argument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class BeforeTest
 * @package Portrino\Codeception\Tests\Module\Typo3
 */
class BeforeTest extends Typo3Test
{
    /**
     *
     */
    protected function setUp()
    {
        $this->container = $this->prophesize(ModuleContainer::class);
        $this->process = $this->prophesize(Process::class);
        $this->processBuilderFactory = $this->prophesize(ProcessBuilderFactory::class);
        $this->builder = $this->prophesize(ProcessBuilder::class);
        $this->asserts = $this->prophesize(Asserts::class);

        $tmpBuilder = new ProcessBuilder();
        $cmd = $tmpBuilder
            ->setPrefix(self::$typo3cmsPath)
            ->add(Typo3Command::DATABASE_IMPORT)
            ->getProcess()
            ->getCommandLine();

        $this->process->getCommandLine()->willReturn($cmd);
        $this->process->start()->shouldBeCalledTimes(1);
        $this->process->wait()->shouldBeCalledTimes(1);

        $this->builder->setPrefix(self::$typo3cmsPath)->shouldBeCalled();
        $this->builder->add(Typo3Command::DATABASE_IMPORT)->shouldBeCalled();

        $this->builder->setInput(Argument::any())->willReturn($this->builder);
        $this->builder->getProcess()->willReturn($this->process);

        $this->process->isSuccessful()->willReturn(true);
        $this->process->getOutput()->willReturn(self::DEBUG_SUCCESS);

        $this->processBuilderFactory->getBuilder()->willReturn($this->builder);

        $this->typo3 = new Typo3(
            $this->container->reveal(),
            [
                'domain' => 'www.example.com',
                'data-dir' => __DIR__ . '/../../Fixture/data/'
            ]
        );
        $this->typo3->setProcessBuilderFactory($this->processBuilderFactory->reveal());
        $this->typo3->_inject($this->asserts->reveal());
    }

    /**
     * @test
     */
    public function beforeImportsSysdomain()
    {
        $test = $this->prophesize(TestInterface::class);
        $this->typo3->_before($test->reveal());
    }
}
