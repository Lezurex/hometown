<?php

namespace Database\Repos;

use Database\Database;
use Database\DTOs\CountryDTO;
use PDO;

class MariaCountryRepo implements CountryRepo
{

  private const ASSERT_ERROR = "Provided country is not an instance of Country!";

  private Database $database;

  public function __construct(Database $database)
  {
    self::$database = $database;
  }

  public function getAllCities(): array
  {
    $result = self::$database::getConnection()->query("SELECT country.id, country.name FROM country;");

    $daoCountries = $result->fetchAll(PDO::FETCH_ASSOC);
    $dtoCountries = array();

    foreach ($daoCountries as $country) {
      $dtoCountries[] = new CountryDTO($country['id'], $country['name']);
    }

    return $dtoCountries;
  }

  public function addCountry(CountryDTO $country)
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("INSERT INTO country (name,)
        VALUES (:name);");

    $stmt->bindParam(':name', $country->name);

    $stmt->execute();
  }

  public function deleteCountry(CountryDTO $country)
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("DELETE FROM country WHERE id = :id;");

    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
  }

  public function updateCountry(CountryDTO $country)
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("UPDATE country SET
        name = :name WHERE id = :id;");

    $stmt->bindParam(':name', $country->name);
    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
  }

  public function countryExists(CountryDTO $country): bool
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("SELECT FROM country WHERE id = :id");

    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
    return $stmt->rowCount() == 1;
  }
}
