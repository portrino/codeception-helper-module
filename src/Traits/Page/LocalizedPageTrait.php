<?php
namespace Portrino\Codeception\Traits\Page;

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
use Portrino\Codeception\Traits\LocalizableTrait;

/**
 * Trait LocalizedPageTrait
 * @package Portrino\Codeception\Traits\Page
 */
trait LocalizedPageTrait
{
    use LocalizableTrait;

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->language == 'en') {
            $result = $this->language . '/' . $this->localeUrls[$this->language];
        } else {
            $result = $this->localeUrls[$this->language];
        }

        return $result;
    }
}
