<?php

namespace Codeception\Module\Portrino;

use Codeception\Lib\Interfaces\DependsOnModule;
use Codeception\Module;
use Codeception\Module\Db;

/**
 * Class Database
 * @package Codeception\Module\Portrino
 */
class Database extends Module implements DependsOnModule
{
    /**
     * @var string
     */
    protected $dependencyMessage = 'Db module is required.';

    /**
     * @var Db
     */
    protected $db;

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function _depends()
    {
        return [Db::class => $this->dependencyMessage];
    }

    /**
     * @param Db $db
     * @codeCoverageIgnore
     */
    public function _inject(Db $db)
    {
        $this->db = $db;
    }

    /**
     * Truncate table in database
     * Use: $I->truncateTableInDatabase('users');
     *
     * @param  string $table
     */
    public function truncateTableInDatabase($table)
    {
        $query = 'TRUNCATE %s';
        $query = sprintf($query, $this->db->driver->getQuotedName($table));
        $this->debugSection('Query', $query);
        $this->executeQuery($query);
    }

    /**
     * @param string $query
     * @param array $params
     */
    protected function executeQuery($query, $params = [])
    {
        $this->db->driver->executeQuery($query, $params);
    }
}
