<?php

namespace Portrino\Codeception\Tests\Util;

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

use PHPUnit\Framework\TestCase;
use Portrino\Codeception\Model\Typo3\Typo3FrontendUser;
use Portrino\Codeception\Util\Fixtures;

/**
 * Class FixturesTest
 * @package Portrino\Codeception\Tests\Module
 */
class FixturesTest extends TestCase
{
    /**
     * @test
     */
    public function getFixtureReturnsModel()
    {
        \Codeception\Util\Fixtures::add(
            'frontend_user',
            [
                '__model' => \Portrino\Codeception\Model\Typo3\Typo3FrontendUser::class,
                'username' => 'dev@portrino.de',
                'email' => 'dev@portrino.de',
                'password' => 'XZeRkbAdA0oQ'
            ]
        );
        /** @var Typo3FrontendUser $frontendUser */
        $frontendUser = Fixtures::get('frontend_user');

        static::assertEquals(Typo3FrontendUser::class, get_class($frontendUser));

        static::assertEquals('dev@portrino.de', $frontendUser->username);
        static::assertEquals('dev@portrino.de', $frontendUser->email);
        static::assertEquals('XZeRkbAdA0oQ', $frontendUser->password);
    }
}
