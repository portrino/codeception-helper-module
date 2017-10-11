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
     * @param string $name
     * @return string
     * @codeCoverageIgnore
     */
    protected function getQuotedName($name)
    {
        return $this->db->driver->getQuotedName($name);
    }

    /**
     * @param string $query
     * @param array $params
     * @codeCoverageIgnore
     */
    protected function executeQuery($query, $params = [])
    {
        $this->db->driver->executeQuery($query, $params);
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
        $query = sprintf($query, $this->getQuotedName($table));
        $this->debugSection('Query', $query);
        $this->executeQuery($query);
    }

    /**
     * Delete entries from $table where $criteria conditions
     * Use: $I->deleteFromDatabase('users', ['id' => '111111', 'banned' => 'yes']);
     *
     * @param  string $table tablename
     * @param  array $criteria conditions. See seeInDatabase() method.
     * @codeCoverageIgnore
     */
    public function deleteFromDatabase($table, $criteria)
    {
        $this->db->driver->deleteQueryByCriteria($table, $criteria);
    }
}
