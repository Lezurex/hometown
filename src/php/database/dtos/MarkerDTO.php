<?php

namespace Database\DTOs;

class MarkerDTO
{
  public int $id;
  public string $title;
  public float $lat;
  public float $lon;
  public string $address;
  public CityDTO $city;
}
