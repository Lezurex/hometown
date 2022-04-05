CREATE DATABASE IF NOT EXISTS hometown;
USE hometown;
CREATE TABLE IF NOT EXISTS country (id SERIAL, name VARCHAR(255));
CREATE TABLE IF NOT EXISTS city (
  id SERIAL,
  name VARCHAR(255),
  postalCode VARCHAR(11),
  countryId BIGINT UNSIGNED,
  CONSTRAINT fkCountryId FOREIGN KEY(countryId) references country(id)
);
CREATE TABLE IF NOT EXISTS marker (
  id SERIAL,
  title VARCHAR(255) NOT NULL,
  lat DOUBLE NOT NULL,
  lon DOUBLE NOT NULL,
  address VARCHAR(255) NOT NULL,
  cityId BIGINT UNSIGNED NOT NULL,
  CONSTRAINT fkCityId FOREIGN KEY(cityId) references city(id)
);
CREATE TABLE IF NOT EXISTS admin (
  id SERIAL,
  username VARCHAR(255),
  passwordHash VARCHAR(255)
)