<?php

namespace Portrino\Codeception\Scheduler;


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
     * @param string $statusString
     * @return TaskResult
     */
    public static function fromStatusString($statusString)
    {
        $result = new TaskResult();
        $result->statusString = $statusString;
        if ((int)$statusString === 0) {
            $result->status = self::STATUS_SUCCESS;
        } else {
            $result->status = self::STATUS_ERROR;
        }
        return $result;
    }
}
