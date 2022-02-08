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
use ComPHPPuebla\Fixtures\Processors\PreProcessor;
use ComPHPPuebla\Fixtures\Processors\UuidGenerator;

class Fixture
{
    /** @var Loader */
    private $loader;

    /** @var Connection */
    private $connection;

    /** @var PreProcessor[] */
    private $preProcessors;

    public function __construct(
        Connection $connection,
        Loader $loader = null,
        array $preProcessors = []
    ) {
        $this->connection = $connection;
        $this->loader = $loader ?? new CachingYamlLoader(new YamlLoader());
        $this->setProcessors($preProcessors);
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
            $this->processRow($table, new Row($primaryKey, $identifier, $row));
        }
    }


    private function processRow(string $table, Row $row): void
    {
        foreach ($this->preProcessors as $processor) {
            $processor->beforeInsert($row);
        }

        $this->connection->insert($table, $row);
    }

    /**
     * @param PreProcessor[] $preProcessors
     */
    private function setProcessors(array $preProcessors): void
    {
        $this->preProcessors = array_merge($preProcessors, [new UuidGenerator()]);
    }
}
