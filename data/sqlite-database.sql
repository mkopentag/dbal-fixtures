PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE stations (
    station_id INTEGER NOT NULL,
    name VARCHAR(100) NOT NULL,
    social_reason VARCHAR(100) NOT NULL,
    address_line_1 VARCHAR(150) NOT NULL,
    address_line_2 VARCHAR(80) NOT NULL,
    location VARCHAR(100) NOT NULL,
    latitude DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
    created_at DATETIME NOT NULL,
    last_updated_at DATETIME NOT NULL,
    PRIMARY KEY(station_id)
);

CREATE TABLE states (
    url VARCHAR(500) NOT NULL,
    name VARCHAR(500) NOT NULL,
    is_enabled BOOLEAN,
    PRIMARY KEY(url)
);

CREATE TABLE roles (
    role_id INTEGER NOT NULL,
    name VARCHAR(500) NOT NULL,
    parent_role VARCHAR(500),
    PRIMARY KEY(role_id)
);

COMMIT;
