<?php

namespace Database\Repos;

include_once './MarkerRepo.php';

use Database\Database;
use Database\DTOs\CityDTO;
use Database\DTOs\CountryDTO;
use Database\DTOs\MarkerDTO;
use PDO;

class MariaMarkerRepo implements MarkerRepo
{

    private const ASSERT_ERROR = "Provided marker is not an instance of Marker!";

    private Database $database;

    public function __construct(Database $database)
    {
        self::$database = $database;
    }

    public function getAllMarkers(): array
    {
        $result = self::$database::getConnection()->query(
            "SELECT
    marker.id,
    marker.title,
    marker.lat,
    marker.lon,
    marker.address,
    city.id AS cityId,
    city.name AS cityName,
    city.postalCode AS cityZip,
    country.id AS countryId,
    country.name AS countryName
FROM
    marker
INNER JOIN(city, country)
ON
    (
        marker.cityID = city.id AND city.countryId = country.id
    );"
        );

        $daoMarkers = $result->fetchAll(PDO::FETCH_ASSOC);
        $dtoMarkers = array();

        foreach ($daoMarkers as $marker) {
            $country = new CountryDTO($marker['countryId'], $marker['countryName']);
            $city = new CityDTO($marker['cityId'], $marker['cityName'], $marker['cityZip'], $country);
            $dtoMarkers[] = new MarkerDTO($marker['id'], $marker['title'], $marker['lat'], $marker['lon'], $marker['address'], $city);
        }

        return $dtoMarkers;
    }

    public function addMarker(MarkerDTO $marker)
    {
        assert($marker instanceof MarkerDTO, self::ASSERT_ERROR);
        $stmt = self::$database->getConnection()->prepare("INSERT INTO marker (title, lat, lon, address, cityId)
        VALUES (:title, :lat, :lon, :address, :cityId);");

        $stmt->bindParam(':title', $marker->title);
        $stmt->bindParam(':lat', $marker->lat);
        $stmt->bindParam(':lon', $marker->lon);
        $stmt->bindParam(':address', $marker->address);
        $stmt->bindParam(':cityId', $marker->city->id);

        $stmt->execute();
    }

    public function deleteMarker(MarkerDTO $marker)
    {
        assert($marker instanceof MarkerDTO, self::ASSERT_ERROR);
        $stmt = self::$database->getConnection()->prepare("DELETE FROM marker WHERE id = :id;");

        $stmt->bindParam(':id', $marker->id);

        $stmt->execute();
    }

    public function updateMaker(MarkerDTO $marker)
    {
        assert($marker instanceof MarkerDTO, self::ASSERT_ERROR);
        $stmt = self::$database->getConnection()->prepare("UPDATE marker SET
        title = :title, lat = :lat, lon = :lon, address = :address, cityId = :cityId WHERE id = :id;");

        $stmt->bindParam(':title', $marker->title);
        $stmt->bindParam(':lat', $marker->lat);
        $stmt->bindParam(':lon', $marker->lon);
        $stmt->bindParam(':address', $marker->address);
        $stmt->bindParam(':cityId', $marker->city->id);
        $stmt->bindParam(':id', $marker->id);

        $stmt->execute();
    }

    public function markerExists(MarkerDTO $marker): bool
    {
        assert($marker instanceof MarkerDTO, self::ASSERT_ERROR);
        $stmt = self::$database->getConnection()->prepare("SELECT FROM marker WHERE id = :id");

        $stmt->bindParam(':id', $marker->id);

        $stmt->execute();
        return $stmt->rowCount() == 1;
    }
}
