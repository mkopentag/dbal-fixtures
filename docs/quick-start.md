# Quick start guide

If you want to have a glance on how to use this library, follow this steps:

1. Create the sample SQLite database

```bash
$ sqlite3 test_db.sq3 < data/database.sql
```

2. Save the following fixture in a file name `stations.yml`.

```yaml
table: stations
items:
  station_1:
    name: "CASMEN GASOL"
    social_reason: "CASMEN SA CV"
    address_line_1: "23 PTE NO 711"
    address_line_2: "EL CARMEN"
    location: "PUEBLA PUE"
    latitude: 19.03817
    longitude: -98.20737
    created_at: "2013-10-06 00:00:00"
    last_updated_at: "2013-10-06 00:00:00"
  station_2:
    name: "COMBUSTIBLES JV"
    social_reason: "COMBUSTIBLES JV SA CV"
    address_line_1: "24 SUR NO 507"
    address_line_2: "CENTRO"
    location: "PUEBLA PUE"
    latitude: 19.03492
    longitude: -98.18554
    created_at: "2013-10-06 00:00:00"
    last_updated_at: "2013-10-06 00:00:00"

```

3. Use the following code to load the fixture in a file named `loader.php`.

```php
use Doctrine\DBAL\DriverManager;
use ComPHPPuebla\Fixtures\Database\DBALConnection;
use ComPHPPuebla\Fixtures\Fixture;

$connection = DriverManager::getConnection([
   'path' => 'test.sq3',
   'driver' => 'pdo_sqlite',
]);

$fixture = new Fixture(new DBALConnection($connection));
$fixture->load('fixture.yml');
```

4. Run the PHP file

```bash
$ php loader.php
```

5. Verify that you have 3 stations, the first one with 2 reviews, the second 
one with 3 reviews, and the third one with only one review. Columns starting
with a `$` should have random fake data.
