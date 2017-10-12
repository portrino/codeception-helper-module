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
