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

use Codeception\Lib\ModuleContainer;
use Codeception\Module\Asserts;
use PHPUnit\Framework\TestCase;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Portrino\Codeception\Module\Shopware;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class ShopwareTest
 *
 * @package Portrino\Codeception\Tests\Module
 */
abstract class ShopwareTest extends TestCase
{
    const DEBUG_EXECUTE = 'Execute';
    const DEBUG_SUCCESS = 'Success';
    const DEBUG_ERROR = 'Error';

    /**
     * @var string
     */
    protected static $shopwareConsolePath = '../../../../../bin/console';

    /**
     * @var Shopware
     */
    protected $shopware;

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
     * @var ProcessBuilderFactory|ObjectProphecy
     */
    protected $processBuilderFactory;

    /**
     * @var Asserts|ObjectProphecy
     */
    protected $asserts;
}
