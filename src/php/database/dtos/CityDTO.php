<?php

namespace Database\DTOs;

class CityDTO
{
  public int $id;
  public string $name;
  public string $postalCode;
  public CountryDTO $country;

  public function __construct($id, $name, $postalCode, $country)
  {
    self::$id = $id;
    self::$name = $name;
    self::$postalCode = $postalCode;
    self::$country = $country;
  }
}
