<?php

namespace Portrino\Codeception\Module;

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
use Codeception\Module;
use Codeception\TestInterface;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3
 * @package Portrino\Codeception\Module
 */
class Typo3 extends Module
{
    /**
     * @var array
     */
    protected $requiredFields = [
        'domain'
    ];

    /**
     * @var array
     */
    protected $config = [
        'bin-dir' => '../../../../../../bin/'
    ];

    /**
     * @var
     */
    protected $typo3cmsPath;

    /**
     * @var ProcessBuilder
     */
    protected $builder;

    /**
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param null $config
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->typo3cmsPath = sprintf('%s%s', $this->config['bin-dir'], 'typo3cms');
        $this->builder = new ProcessBuilder();
        $this->builder->setPrefix($this->typo3cmsPath);
    }

    /**
     * **HOOK** executed before suite
     *
     * @param array $settings
     */
    public function _beforeSuite($settings = [])
    {
        $this->builder->setArguments(
            [
                'database:updateschema',
                '*.add,*.change'
            ]
        );
        $this->builder->getProcess()->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->debugSection('ERR > ', $buffer);
            } else {
                $this->debug($buffer);
            }
        });
    }

    /**
     * **HOOK** executed before test
     *
     * @param TestInterface $test
     */
    public function _before(TestInterface $test)
    {
        $file = 'tests/_data/dynamic/sys_domain/' . (string)$this->config['domain'] . '.sql';
        $input = new InputStream();
        $sql = file_get_contents($file);
        $input->write($sql);

        $this->builder->setInput($input);
        $this->builder->setArguments(
            [
                'database:import',
            ]
        );

        $process = $this->builder->getProcess();
        $process->start();
        $input->close();
    }
}
