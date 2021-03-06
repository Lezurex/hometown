<?php

namespace Database\Repos;

include_once 'CountryRepo.php';
include_once __DIR__ . '/../Database.php';
include_once __DIR__ . '/../dtos/CountryDTO.php';

use Database\Database;
use Database\DTOs\CountryDTO;
use PDO;

class MariaCountryRepo implements CountryRepo
{

  private const ASSERT_ERROR = "Provided country is not an instance of Country!";

  private Database $database;

  public function __construct(Database $database)
  {
    $this->database = $database;
  }

  public function getAllCities(): array
  {
    $result = $this->database::getConnection()->query("SELECT country.id, country.name FROM country;");

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
    $stmt = $this->database->getConnection()->prepare("INSERT INTO country (name)
        VALUES (:name);");

    $stmt->bindParam(':name', $country->name);

    $stmt->execute();
  }

  public function deleteCountry(CountryDTO $country)
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = $this->database->getConnection()->prepare("DELETE FROM country WHERE id = :id;");

    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
  }

  public function updateCountry(CountryDTO $country)
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = $this->database->getConnection()->prepare("UPDATE country SET
        name = :name WHERE id = :id;");

    $stmt->bindParam(':name', $country->name);
    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
  }

  public function countryExists(CountryDTO $country): bool
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = $this->database->getConnection()->prepare("SELECT FROM country WHERE id = :id");

    $stmt->bindParam(':id', $country->id);

    $stmt->execute();
    return $stmt->rowCount() == 1;
  }

  public function addOrGet(CountryDTO $country): CountryDTO
  {
    assert($country instanceof CountryDTO, self::ASSERT_ERROR);
    $stmt = $this->database->getConnection()->prepare("SELECT * FROM country WHERE name = :name");

    $stmt->bindParam(':name', $country->name);

    $stmt->execute();
    if ($stmt->rowCount() >= 1) {
      $result = $stmt->fetch();
      return new CountryDTO($result['id'], $result['name']);
    } else {
      $this->addCountry($country);
      return $this->addOrGet($country);
    }
  }
}
