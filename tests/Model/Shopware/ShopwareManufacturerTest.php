<?php

namespace Portrino\Codeception\Tests\Model\Shopware;

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
use Portrino\Codeception\Model\Shopware\ShopwareManufacturer;

/**
 * Class ShopwareManufacturerTest
 * @package Portrino\Codeception\Tests\Model
 */
class ShopwareManufacturerTest extends TestCase
{
    /**
     * @test
     */
    public function toArray()
    {
        $shopwareManufacturer = new ShopwareManufacturer();

        $shopwareManufacturer->name = 'name';
        $shopwareManufacturer->description = 'description';
        $shopwareManufacturer->image = 'http://via.placeholder.com/350x150';
        $shopwareManufacturer->metaDescription = 'meta description';
        $shopwareManufacturer->metaKeywords = 'meta keywords';

        $customerArray = [
            'name' => 'name',
            'description' => 'description',
            'image' => [
                'link' => 'http://via.placeholder.com/350x150'
            ],
            'metaDescription' => 'meta description',
            'metaKeywords' => 'meta keywords'
        ];

        static::assertEquals(ShopwareManufacturer::class, get_class($shopwareManufacturer));

        static::assertEquals($customerArray, $shopwareManufacturer->toArray());
    }
}
