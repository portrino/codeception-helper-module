<?php

namespace Portrino\Codeception\Traits\Page;

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
