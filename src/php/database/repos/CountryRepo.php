<?php

namespace Database\Repos;

use Database\DTOs\CountryDTO;

interface CountryRepo
{
  public function getAllCities(): array;

  public function addCountry(CountryDTO $country);

  public function deleteCountry(CountryDTO $country);

  public function updateCountry(CountryDTO $country);

  public function countryExists(CountryDTO $country): bool;

  public function addOrGet(CountryDTO $country): CountryDTO;
}
