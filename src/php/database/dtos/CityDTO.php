<?php

namespace Database\DTOs;

class CityDTO
{
  public int $id;
  public string $name;
  public string $postalCode;
  public CountryDTO $country;
}
