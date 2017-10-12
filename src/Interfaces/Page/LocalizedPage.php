<?php
namespace Portrino\Codeception\Interfaces\Page;

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

use Portrino\Codeception\Interfaces\Localizable;

/**
 * Interface LocalizedPage
 * @package Portrino\Codeception\Interfaces\Page
 */
interface LocalizedPage extends Localizable
{
    /**
     * @return mixed|string
     */
    public function getUrl();
}
