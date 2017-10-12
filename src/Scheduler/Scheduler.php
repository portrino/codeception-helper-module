<?php

namespace Portrino\Codeception\Scheduler;

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

use Codeception\Actor;
use Exception;

/**
 * Class Scheduler
 * @package Portrino\Codeception\Scheduler
 */
class Scheduler
{
    /**
     * @var TaskResult
     */
    protected $lastTaskResult;

    /**
     * @var string
     */
    protected $typo3cmsPath;

    /**
     * Scheduler constructor.
     * @param string $typo3cmsPath
     */
    public function __construct($typo3cmsPath = '../../../../../../bin/typo3cms')
    {
        $this->typo3cmsPath = $typo3cmsPath;
    }

    /**
     * @param Task $task
     * @param array ...$arguments
     * @return $this
     */
    public function run(Task $task, ...$arguments)
    {
        array_push($arguments, $this->typo3cmsPath, $task->id);
        $cmd = vsprintf(
            $task->cmdPattern,
            $arguments
        );
        $this->lastTaskResult = TaskResult::fromStatusString(
            shell_exec($cmd)
        );
        $this->lastTaskResult->task = $task;
        return $this;
    }

    /**
     * @param string $cmd
     * @return TaskResult
     */
    protected function execute($cmd)
    {
        return TaskResult::fromStatusString(
            shell_exec($cmd)
        );
    }

    /**
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->lastTaskResult->isSuccessful();
    }
}
