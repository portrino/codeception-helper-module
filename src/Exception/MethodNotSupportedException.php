<?php
namespace Portrino\Codeception\Exception;

use Codeception\Module;

/**
 * Class MethodNotSupportedException
 * @package Portrino\Codeception\Exception
 */
class MethodNotSupportedException extends \Exception
{
    /**
     * @var string
     */
    protected $module;

    /**
     * MethodNotSupportedException constructor.
     * @param Module $module
     * @param string $message
     */
    public function __construct($module, $message)
    {
        if (is_object($module)) {
            $module = get_class($module);
        }
        $module = ltrim(str_replace('Codeception\Module\\', '', $module), '\\');
        $this->module = $module;
        parent::__construct($message);
        $this->message = "$module: {$this->message}";
    }
}
