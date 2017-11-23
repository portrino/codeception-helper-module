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
use Composer\Semver\Comparator;
use Composer\Semver\VersionParser;
use PackageVersions\Versions;
use Portrino\Codeception\Exception\MethodNotSupportedException;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Portrino\Codeception\Interfaces\Commands\Typo3Command;
use Portrino\Codeception\Module\Interfaces\CommandExecutorInterface;
use Portrino\Codeception\Module\Traits\CommandExecutorTrait;
use Symfony\Component\Process\InputStream;

/**
 * Class Typo3
 *
 * @package Portrino\Codeception\Module
 */
class Typo3 extends Module implements DependsOnModule, CommandExecutorInterface
{
    use CommandExecutorTrait;

    const EXIT_STATUS_SUCCESS = 0;
    const EXIT_STATUS_FAILED = 1;

    /**
     * @var string
     */
    protected $dependencyMessage = '"Asserts" module is required.';

    /**
     * @var array
     */
    protected $requiredFields = [
        'domain'
    ];

    /**
     * @var array[]
     *          ['bin-dir']                 String Defines location of Typo3 bin folder
     *          ['data-dir']                String Defines location of Codeception _data folder
     *          ['process-timeout']         int Set Symfony process Timeout: Maximum number of seconds a process can take to finish
     *          ['process-idle-timeout']    int Set Symfony process Idle Timeout: Maximum number of seconds a process can run without outputting anything
     */
    protected $config = [
        'bin-dir' => '../../../../../../bin/',
        'data-dir' => 'tests/_data',
        'process-timeout' => 3600,
        'process-idle-timeout' => 60
    ];

    /**
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param null|array $config
     * @codeCoverageIgnore
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->consolePath = sprintf('%s%s', $this->config['bin-dir'], 'typo3cms');
        $this->processTimeout = $this->config['process-timeout'];
        $this->processIdleTimeout = $this->config['process-idle-timeout'];
        $this->processBuilderFactory = new ProcessBuilderFactory();
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
        $file = vsprintf(
            '%s/sys_domain/%s.sql',
            [
                $this->config['data-dir'],
                $this->config['domain']
            ]
        );

        $this->importIntoDatabase($file);
    }

    /**
     * @param string $file
     * @throws MethodNotSupportedException
     */
    public function importIntoDatabase($file)
    {
        $versionParser = new VersionParser();
        $version = Versions::getVersion('symfony/process');
        $version = $versionParser->normalize(substr($version, 0, strpos($version, '@')));
        if (Comparator::lessThan($version, '2.8.0')) {
            throw new MethodNotSupportedException($this, '$I->importIntoDatabase is not supported for "symfony/process" < 2.8');
        }

        $builder = $this->processBuilderFactory->getBuilder();
        $builder->setPrefix($this->consolePath);
        $input = new InputStream();
        $sql = file_get_contents($file);
        $input->write($sql);
        $builder->add(Typo3Command::DATABASE_IMPORT);
        $builder->setInput($input);
        $process = $builder->getProcess();
        $this->debugSection('Execute', $process->getCommandLine());
        $process->start();
        $input->close();
        $process->wait();
    }

    /**
     * execute scheduler task
     *
     * @param int $taskId Uid of the task that should be executed (instead of all scheduled tasks)
     * @param bool $force The execution can be forced with this flag. The task will then be executed even if it is not
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
