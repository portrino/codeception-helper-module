<?php
namespace Portrino\Codeception\Model\Typo3;

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
 * Class Typo3FrontendUser
 * @package Portrino\Codeception\Model\Typo3
 */
class Typo3FrontendUser extends AbstractModel
{
    const SALUTATION_MR = 'mr';
    const SALUTATION_MS = 'ms';
    const SALUTATION_MRS = 'mrs';

    /**
     * @var int
     */
    public $uid = null;

    /**
     * @var string
     */
    public $salutation = null;

    /**
     * @var string
     */
    public $firstName = null;

    /**
     * @var string
     */
    public $middleName = null;

    /**
     * @var string
     */
    public $lastName = null;

    /**
     * @var string
     */
    public $email = null;

    /**
     * @var string
     */
    public $username = null;

    /**
     * @var string
     */
    public $password = null;

    /**
     * @var string
     */
    public $passwordRepeat = null;

    /**
     * @var string
     */
    public $newPassword = null;

    /**
     * @var string
     */
    public $newPasswordRepeat = null;

    /**
     * @var string
     */
    public $company = null;

    /**
     * @var string
     */
    public $address = null;

    /**
     * @var string
     */
    public $zip = null;

    /**
     * @var string
     */
    public $city = null;

    /**
     * @var string
     */
    public $telephone = null;

    /**
     * @var string
     */
    public $fax = null;

    /**
     * @var bool
     */
    public $newsletter = null;
}
