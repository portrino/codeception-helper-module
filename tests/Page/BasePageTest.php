<?php

namespace Portrino\Codeception\Tests\Page;

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

use Codeception\Actor;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Tests\Fixture\AcceptanceTester;
use Portrino\Codeception\Tests\Fixture\AcceptanceTesterThrowException;
use Portrino\Codeception\Tests\Fixture\LoginPage;
use Portrino\Codeception\Tests\Fixture\LoginPageThrowException;

/**
 * Class BasePageTest
 * @package Portrino\Codeception\Tests\Page
 */
class BasePageTest extends TestCase
{
    /**
     * @var Actor|PHPUnit_Framework_MockObject_MockObject
     */
    protected $tester;

    /**
     * @var LoginPage|PHPUnit_Framework_MockObject_MockObject
     */
    protected $loginPage;

    /**
     * @var LoginPageThrowException|PHPUnit_Framework_MockObject_MockObject
     */
    protected $loginPageThrowException;

    /**
     * @test
     */
    public function open()
    {
        /** @var AcceptanceTester|PHPUnit_Framework_MockObject_MockObject $tester */
        $tester = $this
            ->getMockBuilder(AcceptanceTester::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'amOnPage'
                ]
            )
            ->getMock();
        $tester->expects(static::once())
            ->method('amOnPage')
            ->with('login'); // @see LoginPage

        $this->loginPage = new LoginPage($tester);
        $this->loginPage->open();
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function openThrowException()
    {
        /** @var AcceptanceTesterThrowException|PHPUnit_Framework_MockObject_MockObject $exceptionTester */
        $exceptionTester = $this
            ->getMockBuilder(AcceptanceTesterThrowException::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'dummy'
                ]
            )
            ->getMock();

        $this->loginPageThrowException = new LoginPageThrowException($exceptionTester);
        $this->loginPageThrowException->open();
    }
}
