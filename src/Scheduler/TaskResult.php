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

/**
 * Class TaskResult
 * @package Portrino\Codeception\Scheduler
 */
class TaskResult
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'success';

    /**
     * @var Task
     */
    public $task;

    /**
     * @var string
     */
    protected $statusString = '';

    /**
     * @var string
     */
    protected $status = '';

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->status === self::STATUS_ERROR;
    }

    /**
     * @param mixed $statusString
     * @return TaskResult
     */
    public static function fromStatusString($statusString)
    {
        $result = new TaskResult();
        $result->statusString = $statusString;
        if ($statusString === 0) {
            $result->status = self::STATUS_SUCCESS;
        } else {
            $result->status = self::STATUS_ERROR;
        }
        return $result;
    }
}
