<?php

namespace Portrino\Codeception\Module\Traits;

use Codeception\Module\Asserts;
use Portrino\Codeception\Factory\ProcessBuilderFactory;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Trait CommandExecutorTrait
 * @package Portrino\Codeception\Module\Traits
 */
trait CommandExecutorTrait
{
    /**
     * @var string
     */
    protected $consolePath;

    /**
     * @var int
     */
    protected $processTimeout;

    /**
     * @var int
     */
    protected $processIdleTimeout;

    /**
     * @var Asserts
     */
    protected $asserts;

    /**
     * @var ProcessBuilderFactory
     */
    protected $processBuilderFactory;

    /**
     * @param ProcessBuilderFactory $processBuilderFactory
     */
    public function setProcessBuilderFactory($processBuilderFactory)
    {
        $this->processBuilderFactory = $processBuilderFactory;
    }

    /**
     * @param string $command
     * @param array  $arguments
     * @param array  $environmentVariables
     */
    public function executeCommand($command, $arguments = [], $environmentVariables = [])
    {
        $builder = $this->processBuilderFactory->getBuilder();

        $builder->setPrefix($this->consolePath);

        array_unshift($arguments, $command);
        $arguments = array_map('strval', $arguments);

        $builder->setArguments($arguments);
        if (count($environmentVariables) > 0) {
            $builder->addEnvironmentVariables($environmentVariables);
        }
        $process = $builder->getProcess();

        $this->debugSection('Execute', $process->getCommandLine());

        $process->setTimeout($this->processTimeout);
        $process->setIdleTimeout($this->processIdleTimeout);

        $process->run();

        if ($process->isSuccessful()) {
            $this->debugSection('Success', $process->getOutput());
        } else {
            $this->debugSection('Error', $process->getErrorOutput());
        }

        $this->asserts->assertTrue($process->isSuccessful());
    }
}
