<?php
include_once '../MariaDatabaseImpl.php';
include_once '../Database.php';
include_once '../repos/MariaMarkerRepo.php';
include_once '../dtos/MarkerDTO.php';
include_once '../repos/nominatimRepoImpl.php';

use Database\MariaDatabaseImpl;
use Database\Database;
use Database\Repos\MariaMarkerRepo;
use Database\DTOs\MarkerDTO;
use Database\Repos\nominatimRepo;

$markerRepo = new MariaMarkerRepo(new MariaDatabaseImpl());
$nominatimRepo = new nominatimRepoImpl();

$address = $_POST['address'];
$zip_code = $_POST['zip-code'];
$country = $_POST['country'];
$title = $_POST['title'];

$additional_data = $nominatimRepo->getCoordinates($address, $zip_code, $country);
$lat = $additional_data[0];
$lon = $additional_data[1];
$city_id = $additional_data[2];

$markerRepo->addMarker(new MarkerDTO(null, $title, $lat, $lon, $address, $city_id));



