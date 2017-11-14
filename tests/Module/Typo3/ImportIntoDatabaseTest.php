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
use Composer\Semver\Comparator;
use Composer\Semver\VersionParser;
use PackageVersions\Versions;
use Portrino\Codeception\Exception\MethodNotSupportedException;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Portrino\Codeception\Tests\Module\Typo3Test;
use Prophecy\Argument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class ImportIntoDatabaseTest
 * @package Portrino\Codeception\Tests\Module\Typo3
 */
class ImportIntoDatabaseTest extends Typo3Test
{
    /**
     * @var string
     */
    protected static $file = __DIR__ . '/../../Fixture/data/dump.sql';

    /**
     * @var bool
     */
    protected static $isMethodSupported;

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        $versionParser = new VersionParser();
        $version = Versions::getVersion('symfony/process');
        $version = $versionParser->normalize(substr($version, 0, strpos($version, '@')));
        self::$isMethodSupported = Comparator::greaterThan($version, '2.8.0');
        parent::setUpBeforeClass();
    }

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        if (self::$isMethodSupported) {
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

            $this->typo3 = new Typo3($this->container->reveal());
            $this->typo3->setProcessBuilderFactory($this->processBuilderFactory->reveal());
            $this->typo3->_inject($this->asserts->reveal());
        }

        if (!self::$isMethodSupported) {
            $this->container = $this->prophesize(ModuleContainer::class);
            $this->typo3 = new Typo3($this->container->reveal());
        }
    }

    /**
     * @test
     */
    public function importIntoDatabaseSuccessfully()
    {
        if (self::$isMethodSupported) {
            $this->typo3->importIntoDatabase(self::$file);
        }

        if (!self::$isMethodSupported) {
            static::expectException(MethodNotSupportedException::class);
            $this->typo3->importIntoDatabase(self::$file);
        }
    }
}
