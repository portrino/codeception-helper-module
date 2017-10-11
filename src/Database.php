<?php

namespace Codeception\Module\Portrino;

use Codeception\Module\Db;


/**
 * Class Database
 * @package Codeception\Module\Portrino
 */
class Database extends Db
{

    /**
     * Truncate table in database
     * Use: $I->truncateTableInDatabase('users');
     *
     * @param  string $table
     */
    public function truncateTableInDatabase($table)
    {
        $query = 'TRUNCATE %s';

        $query = sprintf($query, $table);
        $this->debugSection('Query', $query);
        $this->driver->executeQuery($query, []);
    }
}
