<?php

namespace Portrino\Codeception\Factory;

use Symfony\Component\Process\ProcessBuilder;

/**
 * Class ProcessBuilderFactory
 * @package Portrino\Codeception\Factory
 */
class ProcessBuilderFactory
{
    /**
     * @return ProcessBuilder
     */
    public function getBuilder()
    {
        return new ProcessBuilder();
    }
}
