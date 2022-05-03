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
    $this->id = $id;
    $this->name = $name;
    $this->postalCode = $postalCode;
    $this->country = $country;
  }
}
