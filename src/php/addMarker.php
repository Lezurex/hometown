<?php
include_once 'database/MariaDatabaseImpl.php';
include_once 'database/Database.php';
include_once 'database/repos/MariaMarkerRepo.php';
include_once 'database/repos/MariaCountryRepo.php';
include_once 'database/repos/MariaCityRepo.php';
include_once 'database/dtos/MarkerDTO.php';
include_once 'database/repos/NominatimRepoImpl.php';
include_once 'database/dtos/CityDTO.php';

use Database\MariaDatabaseImpl;
use Database\DTOs\CityDTO;
use Database\DTOs\CountryDTO;
use Database\Repos\MariaMarkerRepo;
use Database\DTOs\MarkerDTO;
use Database\Repos\MariaCityRepo;
use Database\Repos\MariaCountryRepo;

$database = new MariaDatabaseImpl();

$markerRepo = new MariaMarkerRepo($database);
$cityRepo = new MariaCityRepo($database);
$countryRepo = new MariaCountryRepo($database);
$nominatimRepo = new NominatimRepoImpl();

$address = $_POST['address'];
$zip_code = $_POST['zip-code'];
$country = $_POST['country'];
$title = $_POST['title'];

$additional_data = $nominatimRepo->getCoordinates($address, $zip_code, $country);
$lat = $additional_data[0];
$lon = $additional_data[1];
$city_name = $additional_data[2];
$postalCode = $additional_data[3];
$country_name = $additional_data[4];

$country = $countryRepo->addOrGet(new CountryDTO(-1, $country_name));
$city = $cityRepo->addOrGet(new CityDTO(-1, $city_name, $postalCode, $country));

$markerRepo->addMarker(new MarkerDTO(-1, $title, $lat, $lon, $address, $city_id));
