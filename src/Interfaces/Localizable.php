<?php

namespace Portrino\Codeception\Interfaces;

/**
 * Interface LocalizedPage
 * @package Portrino\Codeception\Interfaces
 */
interface Localizable
{
    const DE = 'de';
    const EN = 'en';

    /**
     * @param $language
     * @return $this
     */
    public function setLanguage($language);

    /**
     * @param string $key
     * @return string
     */
    public function getLabel($key);
}
