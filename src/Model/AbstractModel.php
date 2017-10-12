<?php

namespace Portrino\Codeception\Model;

/**
 * Class AbstractFixture
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
