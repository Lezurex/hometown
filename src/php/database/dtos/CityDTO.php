<?php

namespace Database\DTOs;

class CityDTO
{
  public string $name;
  public string $postalCode;
  public CountryDTO $country;
}
