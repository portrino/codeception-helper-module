<?php

namespace Portrino\Codeception\Scheduler;

/**
 * Class Task
 * @package Portrino\Codeception\Scheduler
 */
class Task
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $cmdPattern = '%s scheduler:run %d --force 2>&1; echo $?';

    /**
     * Task constructor.
     * @param int $id
     * @param string $cmdPattern
     */
    public function __construct($id, $cmdPattern = '')
    {
        $this->id = $id;

        if ($cmdPattern) {
            $this->cmdPattern = $cmdPattern;
        }
    }
}
