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
use Portrino\Codeception\Model\Shopware\ShopwareCustomer;

/**
 * Class ShopwareCustomerTest
 * @package Portrino\Codeception\Tests\Model
 */
class ShopwareCustomerTest extends TestCase
{
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';
    const SALUTATION_MRS = 'mrs';

    /**
     * @test
     */
    public function toArray()
    {
        $shopwareCustomer = new ShopwareCustomer;

        $shopwareCustomer->email = 'dev@portrino.de';
        $shopwareCustomer->password = '123456';
        $shopwareCustomer->salutation = ShopwareCustomer::SALUTATION_MR;
        $shopwareCustomer->lastname = 'Lastname';
        $shopwareCustomer->firstname = 'Firstname';
        $shopwareCustomer->billingFirstname = 'Firstname';
        $shopwareCustomer->billingLastname = 'Lastname';
        $shopwareCustomer->billingSalutation = ShopwareCustomer::SALUTATION_MR;
        $shopwareCustomer->billingStreet = 'Musterstraße 2';
        $shopwareCustomer->billingCity = 'Dresden';
        $shopwareCustomer->billingZipcode = '01109';
        $shopwareCustomer->billingCountry = 2;

        $customerArray = [
            'email' => 'dev@portrino.de',
            'password' => '123456',
            'salutation' => self::SALUTATION_MR,
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'billing' => [
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'salutation' => self::SALUTATION_MR,
                'street' => 'Musterstraße 2',
                'city' => 'Dresden',
                'zipcode' => '01109',
                'country' => 2
            ]
        ];

        static::assertEquals(ShopwareCustomer::class, get_class($shopwareCustomer));

        static::assertEquals($customerArray, $shopwareCustomer->toArray());
    }
}
