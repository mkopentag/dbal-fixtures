<?php
/**
 * PHP version 7.1
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace ComPHPPuebla\Fixtures;

use ComPHPPuebla\Fixtures\Database\DBALConnection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class FixtureTest extends TestCase
{
    use ProvidesConnections;

    /**
     * @test
     * @dataProvider databaseConnections
     */
    public function it_persists_fixtures(ConnectionFactory $factory)
    {
        $connection = $factory->connect();
        $fixtures = new Fixture(new DBALConnection($connection));
        $database = new TestDatabase($connection);

        $fixtures->loadAll("$this->path/fixture.yml");

        $station1 = $database->findStationNamed('CASMEN GASOL');
        $station2 = $database->findStationNamed('COMBUSTIBLES JV');

        // Stations have been saved
        $this->assertGreaterThan(0, $station1['station_id']);
        $this->assertGreaterThan(0, $station2['station_id']);
    }

    /**
     * @test
     * @dataProvider databaseConnections
     */
    public function it_does_not_overwrite_non_auto_generated_ids(ConnectionFactory $factory)
    {
        $connection = $factory->connect();
        $fixtures = new Fixture(new DBALConnection($connection));
        $database = new TestDatabase($connection);

        $fixtures->load("$this->path/fixture-with-id.yml", 'state_1');

        $state = $database->findStateWithUrl('puebla');

        $this->assertNotFalse($state);
    }

    /**
     * @test
     * @dataProvider databaseConnections
     */
    public function it_can_generate_uuid(ConnectionFactory $factory)
    {
        $connection = $factory->connect();
        $fixtures = new Fixture(new DBALConnection($connection));
        $database = new TestDatabase($connection);

        $fixtures->load("$this->path/fixture-with-generated-uuid.yml", 'station');

        $station = $database->findStationNamed('uuid');

        $this->assertTrue(Uuid::isValid($station['location']));
    }

    /**
     * @test
     * @dataProvider databaseConnections
     */
    public function it_does_not_overwrite_null_values(ConnectionFactory $factory)
    {
        $connection = $factory->connect();
        $fixtures = new Fixture(new DBALConnection($connection));
        $database = new TestDatabase($connection);

        $fixtures->load("$this->path/fixture-with-nulls.yml", 'role_1');

        $role = $database->findRoleNamed('admin');

        $this->assertNotFalse($role);
        $this->assertNull($role['parent_role']);
    }

    /** @before */
    protected function configureFixtures(): void
    {
        $this->path = __DIR__ . '/../../data/';
    }

    /** @var string */
    private $path;
}
