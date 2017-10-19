<?php
namespace Portrino\Codeception\Module\Interfaces;

/**
 * Class CommandExecutorInterface
 * @package Portrino\Codeception\Module\Interfaces
 */
interface CommandExecutorInterface
{
    /**
     * @param string $command
     * @param array  $arguments
     * @param array  $environmentVariables
     */
    public function executeCommand($command, $arguments = [], $environmentVariables = []);
}
