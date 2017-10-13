<?php
namespace Portrino\Codeception\Page;

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

/**
 * Class BasePage
 *
 * @package Portrino\Codeception\Page
 */
abstract class BasePage
{
    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var Actor
     */
    protected $tester;

    /**
     * @return $this
     */
    public function open()
    {
        $I = $this->tester;
        if (!method_exists($I, 'amOnPage')) {
            throw new \Exception('Tester does not implement method "amOnPage"', 1507723583210);
        }
        $I->amOnPage($this->getUrl());
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
