<?php

namespace Portrino\Codeception\Interfaces\Page;

use Portrino\Codeception\Interfaces\Localizable;

/**
 * Interface LocalizedPage
 * @package Portrino\Codeception\Interfaces\Page
 */
interface LocalizedPage extends Localizable
{
    /**
     * @return mixed|string
     */
    public function getUrl();
}
