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

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Codeception\Module\Asserts;
use Codeception\TestInterface;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Typo3
 * @package Portrino\Codeception\Module
 */
class Typo3 extends Module implements DependsOnModule
{
    /**
     * @var string
     */
    protected $dependencyMessage = '"Asserts" module is required.';

    /**
     * @var Asserts
     */
    protected $asserts;

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
     * @return array
     * @codeCoverageIgnore
     */
    public function _depends()
    {
        return [Asserts::class => $this->dependencyMessage];
    }

    /**
     * **HOOK** executed before suite
     *
     * @param array $settings
     */
    public function _beforeSuite($settings = [])
    {
        $this->executeCommand(
            Typo3Command::DATABASE_UPDATE_SCHEMA,
            [
                '*.add,*.change'
            ]
        );
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
        $process = $this->builder->add('database:import')->setInput($input)->getProcess();
        $this->debugSection('Execute', $process->getCommandLine());
        $process->start();
        $input->close();
    }

    /**
     * @param string $command
     * @param array $arguments
     * @param array $environmentVariables
     * @return int
     */
    public function executeCommand($command, $arguments = [], $environmentVariables = [])
    {
        $process = $this->builder
            ->add($command)
            ->setArguments($arguments)
            ->addEnvironmentVariables($environmentVariables)
            ->getProcess();

        $this->debugSection('Execute', $process->getCommandLine());

        $result = (bool)$process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->debugSection('Error', $buffer);
            } else {
                $this->debugSection('Success', $buffer);
            }
        });

        $this->asserts->assertTrue($result);
    }

    /**
     * execute scheduler task
     *
     * @param int $taskId Uid of the task that should be executed (instead of all scheduled tasks)
     * @param bool $force The execution can be forced with this flag. The task will then be executed even if it is not
     *                    scheduled for execution yet. Only works, when a task is specified.
     * @param array $environmentVariables
     */
    public function executeSchedulerTask($taskId, $force = false, $environmentVariables = [])
    {
        $this->executeCommand(
            Typo3Command::SCHEDULER_RUN,
            [
                'task-id' => $taskId,
                'force' => $force
            ],
            $environmentVariables
        );
    }

    /**
     * flush cache
     *
     * @param bool $force
     * @param bool $filesOnly
     */
    public function flushCache($force = false, $filesOnly = false)
    {
        $this->executeCommand(
            Typo3Command::CACHE_FLUSH,
            [
                'force' => $force,
                'files-only' => $filesOnly
            ]
        );
    }

    /**
     * flush cache by group:
     *
     * all
     * lowlevel
     * pages
     * system
     *
     * @param string $groups comma sep string (e.g.: pages, all)
     */
    public function flushCacheGroups($groups)
    {
        $this->executeCommand(
            Typo3Command::CACHE_FLUSH_GROUPS,
            [
                'groups' => $groups
            ]
        );
    }
}
