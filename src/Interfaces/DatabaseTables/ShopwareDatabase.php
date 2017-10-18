<?php
namespace Portrino\Codeception\Interfaces\DatabaseTables;

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
 * Interface ShopwareDatabase
 *
 * @package Portrino\Codeception\Interfaces\DatabaseTables
 */
interface ShopwareDatabase
{
    const S_ARTICLES = 's_articles';
    const S_ARTICLES_DETAILS = 's_articles_details';

    const S_USER = 's_user';
    const S_USER_ATTRIBUTES = 's_user_attributes';

    const S_CORE_AUTH_ATTRIBUTES = 's_core_auth_attributes';
    const S_CORE_AUTH = 's_core_auth';
}
