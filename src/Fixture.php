<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\Fixtures;

use ComPHPPuebla\Fixtures\Database\Connection;
use ComPHPPuebla\Fixtures\Database\Row;
use ComPHPPuebla\Fixtures\Loaders\CachingYamlLoader;
use ComPHPPuebla\Fixtures\Loaders\Loader;
use ComPHPPuebla\Fixtures\Loaders\YamlLoader;

class Fixture
{
    /** @var Loader */
    private $loader;

    /** @var Connection */
    private $connection;

    public function __construct(
        Connection $connection,
        Loader $loader = null
    ) {
        $this->connection = $connection;
        $this->loader = $loader ?? new CachingYamlLoader(new YamlLoader());
    }

    public function loadAll(string $pathToFixturesFile): void
    {
        $data = $this->loader->load($pathToFixturesFile);

        $this->processTableRows($data['table'], $data['items']);
    }

    public function load(string $pathToFixturesFile, string $alias): void
    {
        $data = $this->loader->load($pathToFixturesFile);

        $this->processTableRows($data['table'], [$alias => $data['items'][$alias]]);
    }

    public function loadWithOverride(string $pathToFixturesFile, array $override, string $alias): void
    {
        $data = $this->loader->load($pathToFixturesFile);
        $row = \array_merge($data['items'][$alias], $override);

        $this->processTableRows($data['table'], [$alias => $row]);
    }

    private function processTableRows(string $table, array $rows): void
    {
        $primaryKey = $this->connection->primaryKeyOf($table);
        foreach ($rows as $identifier => $row) {
            $this->connection->insert($table, (new Row($primaryKey, $identifier, $row)));
        }
    }
}
