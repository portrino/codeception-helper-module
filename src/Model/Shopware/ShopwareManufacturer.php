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
 * Class ShopwareManufacturer
 * @package Portrino\Codeception\Model\Shopware
 */
class ShopwareManufacturer extends AbstractModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $metaDescription;

    /**
     * @var string
     */
    public $metaKeywords;

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => [
                'link' => $this->image
            ],
            'metaDescription' => $this->metaDescription,
            'metaKeywords' => $this->metaKeywords
        ];
        return array_filter($result, function ($value) {
            return $value !== null;
        });
    }
}
