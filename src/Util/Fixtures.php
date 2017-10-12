<?php

namespace Portrino\Codeception\Util;

/**
 * Class Fixtures
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

        if (isset($data['__model']) && class_exists($data['__model'])) {
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
