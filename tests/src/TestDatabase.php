<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\Fixtures;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class TestDatabase
{
    /** @var Connection */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** @throws DBALException*/
    public function findStationNamed(string $name): array
    {
        return $this->connection->executeQuery('SELECT * FROM stations WHERE name = ?', [$name])->fetchAssociative();
    }

    /** @throws DBALException*/
    public function findStateWithUrl(string $url): array
    {
        return $this->connection->executeQuery('SELECT * FROM states WHERE url = ?', [$url])->fetchAssociative();
    }

    /** @throws DBALException*/
    public function findRoleNamed(string $name): array
    {
        return $this->connection->executeQuery('SELECT * FROM roles WHERE name = ?', [$name])->fetchAssociative();
    }

    /** @throws DBALException*/
    public function findLocationWithId(int $id): array
    {
        return $this->connection->executeQuery('SELECT * FROM locations WHERE id = ?', [$id])->fetchAssociative();
    }
}
