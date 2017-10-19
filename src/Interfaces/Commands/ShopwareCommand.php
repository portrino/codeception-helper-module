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
 * Interface ShopwareCommand
 * @package Portrino\Codeception\Interfaces\Commands
 */
interface ShopwareCommand
{
    const CACHE_CLEAR = 'sw:cache:clear';
    const CACHE_THEME_GENERATE = 'sw:theme:cache:generate';

    const PLUGIN_CONFIG_SET = 'sw:plugin:config:set';

    const PLUGIN_INSTALL = 'sw:plugin:install';
    const PLUGIN_ACTIVATE = 'sw:plugin:activate';
    const PLUGIN_LIST_REFRESH = 'sw:plugin:refresh';

    const RUN_SQL_COMMAND = 'dbal:run-sql';
}
