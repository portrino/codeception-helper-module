<?php

namespace Portrino\Codeception\Tests\Fixture;

use Codeception\Actor;

/**
 * Class AcceptanceTester
 * @package Portrino\Codeception\Tests\Fixture
 */
class AcceptanceTester extends Actor
{
    /**
     * @return string
     */
    public function amOnPage()
    {
        return 'foo';
    }
}
