<?php

namespace Portrino\Codeception\Tests\Fixture;

use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Page\BasePage;

/**
 * Class LoginPage
 * @package Portrino\Codeception\Tests\Fixture
 */
class LoginPage extends BasePage
{
    /**
     * @var string
     */
    protected $url = 'login';

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|AcceptanceTester
     */
    protected $tester;

    /**
     * LoginPage constructor.
     * @param PHPUnit_Framework_MockObject_MockObject|AcceptanceTester $tester
     */
    public function __construct(AcceptanceTester $tester)
    {
        $this->tester = $tester;
    }
}
