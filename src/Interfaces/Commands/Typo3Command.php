<?php
namespace Portrino\Codeception\Interfaces\Commands;

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
 * Interface Typo3Command
 *
 * @package Portrino\Codeception\Interfaces\Commands
 */
interface Typo3Command
{
    const CACHE_FLUSH = 'cache:flush';
    const CACHE_FLUSH_GROUPS = 'cache:flushgroups';

    const DATABASE_IMPORT = 'database:import';
    const DATABASE_UPDATE_SCHEMA = 'database:updateschema';

    const SCHEDULER_RUN = 'scheduler:run';
}
