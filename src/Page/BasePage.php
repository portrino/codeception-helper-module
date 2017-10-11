<?php

namespace Portrino\Codeception\Page;

use Codeception\Actor;

/**
 * Class BasePage
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
     * BasePage constructor.
     * @param Actor $I
     */
    public function __construct(Actor $I)
    {
        $this->tester = $this->getTester();
    }

    abstract public function getTester();

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
