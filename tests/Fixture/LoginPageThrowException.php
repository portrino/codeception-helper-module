<?php

namespace Portrino\Codeception\Tests\Fixture;

use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Page\BasePage;

/**
 * Class LoginPageThrowException
 * @package Portrino\Codeception\Tests\Fixture
 */
class LoginPageThrowException extends BasePage
{
    /**
     * @var string
     */
    protected $url = 'login';

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|AcceptanceTesterThrowException
     */
    protected $tester;

    /**
     * LoginPageThrowException constructor.
     * @param PHPUnit_Framework_MockObject_MockObject|AcceptanceTesterThrowException $tester
     */
    public function __construct(AcceptanceTesterThrowException $tester)
    {
        $this->tester = $tester;
    }
}
