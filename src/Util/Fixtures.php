<?php

namespace Portrino\Codeception\Util;

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
 * Class Fixtures
 *
 * @package Portrino\Codeception\Util
 */
class Fixtures extends \Codeception\Util\Fixtures
{
    /**
     * @param string $name
     * @return array|object
     */
    public static function get($name)
    {
        $data = parent::get($name);
        $result = $data;

        if (is_array($data) && isset($data['__model']) && class_exists($data['__model'])) {
            $modelClassName = $data['__model'];
            unset($data['__model']);
            $model = new $modelClassName();
            foreach ($data as $key => $value) {
                $model->{$key} = $value;
            }
            $result = $model;
        }
        return $result;
    }
}
