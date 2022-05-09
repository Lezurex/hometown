<?php

namespace Database\Repos;

use Database\DTOs\CityDTO;

interface CityRepo
{
  public function getAllCities(): array;

  public function getByPostalCode(int $postalCode, string $country): CityDTO;

  public function addCity(CityDTO $city);

  public function deleteCity(CityDTO $city);

  public function updateCity(CityDTO $city);

  public function cityExists(CityDTO $city): bool;

  public function addOrGet(CityDTO $city): CityDTO;
}
