<?php

namespace Portrino\Codeception\Traits;

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
