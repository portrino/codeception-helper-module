<?php
namespace Portrino\Codeception\Interfaces;

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
