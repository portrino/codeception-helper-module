<?php

namespace Portrino\Codeception\Tests\Module;

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
use PHPUnit_Framework_MockObject_MockObject;
use Portrino\Codeception\Module\Database;

/**
 * Class DatabaseTest
 * @package Portrino\Codeception\Tests\Module
 */
class DatabaseTest extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Database
     */
    protected $database;

    /**
     * @var string
     */
    protected static $truncateQuery = 'TRUNCATE `foo_bar`';

    /**
     * @test
     */
    public function truncateTableInDatabase()
    {
        /** @var Database|PHPUnit_Framework_MockObject_MockObject $database */
        $database = $this->getMockBuilder(Database::class)
            ->setMethods(
                [
                    'executeQuery',
                    'getQuotedName',
                    'debugSection'
                ]
            )
            ->disableOriginalConstructor()
            ->getMock();

        $database
            ->expects(static::once())
            ->method('getQuotedName')
            ->with('foo_bar')
            ->willReturn('`foo_bar`');

        $database
            ->expects(static::once())
            ->method('executeQuery')
            ->with(self::$truncateQuery, []);

        $database
            ->expects(static::once())
            ->method('debugSection')
            ->with('Query', self::$truncateQuery);

        $database->truncateTableInDatabase('foo_bar');
    }
}
