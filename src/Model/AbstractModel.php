<?php
namespace Portrino\Codeception\Model;

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
 * Class AbstractFixture
 *
 * @package Portrino\Codeception\Model
 */
abstract class AbstractModel
{
    /**
     * reset all properties
     */
    public function reset()
    {
        foreach ($this as $key => $value) {
            $this->$key = null;
        }
    }
}
