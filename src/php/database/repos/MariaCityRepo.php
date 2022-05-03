<?php

namespace Database\Repos;

use Database\Database;
use Database\DTOs\CityDTO;
use Database\DTOs\CountryDTO;
use PDO;

class MariaCityRepo implements CityRepo
{

  private const ASSERT_ERROR = "Provided city is not an instance of City!";

  private Database $database;

  public function __construct(Database $database)
  {
    self::$database = $database;
  }

  public function getAllCities(): array
  {
    $result = self::$database::getConnection()->query(
      "SELECT
    city.id,
    city.name,
    city.postalCode,
    country.id AS countryId,
    country.name AS countryName
FROM
    city
INNER JOIN(country)
ON
    (
        city.countryId = country.id
    );"
    );

    $daoCities = $result->fetchAll(PDO::FETCH_ASSOC);
    $dtoCities = array();

    foreach ($daoCities as $city) {
      $country = new CountryDTO($city['countryId'], $city['countryName']);
      $dtoCities[] = new CityDTO($city['id'], $city['name'], $city['postalCode'], $country);
    }

    return $dtoCities;
  }

  public function addCity(CityDTO $city)
  {
    assert($city instanceof CityDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("INSERT INTO city (name, postalCode, countryId)
        VALUES (:name, :postalCode, :countryId);");

    $stmt->bindParam(':name', $city->name);
    $stmt->bindParam(':postalCode', $city->postalCode);
    $stmt->bindParam(':countryId', $city->country->id);

    $stmt->execute();
  }

  public function deleteCity(CityDTO $city)
  {
    assert($city instanceof CityDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("DELETE FROM city WHERE id = :id;");

    $stmt->bindParam(':id', $city->id);

    $stmt->execute();
  }

  public function updateCity(CityDTO $city)
  {
    assert($city instanceof CityDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("UPDATE city SET
        name = :name, postalCode = :postalCode, countryId = :countryId, WHERE id = :id;");

    $stmt->bindParam(':name', $city->title);
    $stmt->bindParam(':postalCode', $city->postalCode);
    $stmt->bindParam(':countryId', $city->country->id);
    $stmt->bindParam(':id', $city->id);

    $stmt->execute();
  }

  public function cityExists(CityDTO $city): bool
  {
    assert($city instanceof CityDTO, self::ASSERT_ERROR);
    $stmt = self::$database->getConnection()->prepare("SELECT FROM city WHERE id = :id");

    $stmt->bindParam(':id', $city->id);

    $stmt->execute();
    return $stmt->rowCount() == 1;
  }
}
