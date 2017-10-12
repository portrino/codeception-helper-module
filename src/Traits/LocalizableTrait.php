<?php

namespace Portrino\Codeception\Traits;

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

use Portrino\Codeception\Interfaces\Localizable;

/**
 *
 * Trait LocalizableTrait
 * @package Portrino\Codeception\Traits
 */
trait LocalizableTrait
{
//    /**
//     * @var array
//     */
//    protected $localeUrls = [
//        Localizable::LOCALE_DE => '',
//        Localizable::LOCALE_EN => ''
//    ];
//
//    /**
//     * @var array
//     */
//    protected $labels = [
//        Localizable::LOCALE_DE => [
//            'key' => 'value'
//        ],
//        Localizable::LOCALE_EN => [
//            'key' => 'value'
//        ]
//    ];

    /**
     * @var string
     */
    public $language = Localizable::DE;

    /**
     * @param $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getLabel($key)
    {
        return $this->labels[$this->language][$key];
    }
}
