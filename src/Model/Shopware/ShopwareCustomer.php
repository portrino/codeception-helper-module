<?php

namespace Portrino\Codeception\Model\Shopware;

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

use Portrino\Codeception\Model\AbstractModel;

/**
 * Class ShopwareCustomer
 * @package Portrino\Codeception\Model\Shopware
 */
class ShopwareCustomer extends AbstractModel
{
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';
    const SALUTATION_MRS = 'mrs';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $salutation;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $billingFirstname;

    /**
     * @var string
     */
    public $billingLastname;

    /**
     * @var string
     */
    public $billingSalutation;

    /**
     * @var string
     */
    public $billingStreet;

    /**
     * @var string
     */
    public $billingCity;

    /**
     * @var string
     */
    public $billingZipcode;

    /**
     * @var int
     */
    public $billingCountry;

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'salutation' => $this->salutation,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'billing' => [
                'firstname' => $this->billingFirstname,
                'lastname' => $this->billingLastname,
                'salutation' => $this->billingSalutation,
                'street' => $this->billingStreet,
                'city' => $this->billingCity,
                'zipcode' => $this->billingZipcode,
                'country' => $this->billingCountry
            ]
        ];
        return array_filter($result, function($value) { return $value !== null; });
    }
}
