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
 *
 * @package Portrino\Codeception\Module
 */
class Typo3 extends Module implements DependsOnModule
{
    const EXIT_STATUS_SUCCESS = 0;
    const EXIT_STATUS_FAILED = 1;

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
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param null            $config
     * @codeCoverageIgnore
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
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
     * @param Asserts $assert
     * @codeCoverageIgnore
     */
    public function _inject(Asserts $asserts)
    {
        $this->asserts = $asserts;
        $this->typo3cmsPath = sprintf('%s%s', $this->config['bin-dir'], 'typo3cms');
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
        $this->importIntoDatabase($file);
    }

    /**
     * @param string $file
     */
    public function importIntoDatabase($file)
    {
        /** @var ProcessBuilder $builder */
        $builder = new ProcessBuilder();
        $builder->setPrefix($this->typo3cmsPath);
        $input = new InputStream();
        $sql = file_get_contents($file);
        $input->write($sql);
        $process = $builder->add(Typo3Command::DATABASE_IMPORT)->setInput($input)->getProcess();
        $this->debugSection('Execute', $process->getCommandLine());
        $process->start();
        $input->close();
        $process->wait();
    }

    /**
     * @return ProcessBuilder
     * @codeCoverageIgnore
     */
    protected function createBuilder()
    {
        return new ProcessBuilder();
    }

    /**
     * @param string $command
     * @param array  $arguments
     * @param array  $environmentVariables
     */
    public function executeCommand($command, $arguments = [], $environmentVariables = [])
    {
        /** @var ProcessBuilder $builder */
        $builder = $this->createBuilder();
        $builder->setPrefix($this->typo3cmsPath);

        array_unshift($arguments, $command);
        $process = $builder
            ->setArguments($arguments)
            ->addEnvironmentVariables($environmentVariables)
            ->getProcess();

        $this->debugSection('Execute', $process->getCommandLine());

        $process->run();

        if ($process->isSuccessful()) {
            $this->debugSection('Success', $process->getOutput());
        } else {
            $this->debugSection('Error', $process->getErrorOutput());
        }

        $this->asserts->assertTrue($process->isSuccessful());
    }

    /**
     * execute scheduler task
     *
     * @param int   $taskId               Uid of the task that should be executed (instead of all scheduled tasks)
     * @param bool  $force                The execution can be forced with this flag. The task will then be executed even if it is not
     *                                    scheduled for execution yet. Only works, when a task is specified.
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
