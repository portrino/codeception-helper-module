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
use Codeception\Lib\ModuleContainer;
use Codeception\Module\Asserts;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Typo3;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3Test
 *
 * @package Portrino\Codeception\Tests\Module
 */
abstract class Typo3Test extends TestCase
{
    const DEBUG_EXECUTE = 'Execute';
    const DEBUG_SUCCESS = 'Success';
    const DEBUG_ERROR = 'Error';

    /**
     * @var string
     */
    protected static $typo3cmsPath = '../../../../../../bin/typo3cms';

    /**
     * @var Typo3
     */
    protected $typo3;

    /**
     * @var ProcessBuilder|ObjectProphecy
     */
    protected $builder;

    /**
     * @var ModuleContainer|ObjectProphecy
     */
    protected $container;

    /**
     * @var Process|ObjectProphecy
     */
    protected $process;

    /**
     * @var Asserts|ObjectProphecy
     */
    protected $asserts;
}
