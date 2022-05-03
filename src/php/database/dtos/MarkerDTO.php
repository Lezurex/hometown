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

  /**
   * @param int $id
   * @param string $title
   * @param float $lat
   * @param float $lon
   * @param string $address
   * @param CityDTO $city
   */
  public function __construct($id, $title, $lat, $lon, $address, $city)
  {
    $this->id = $id;
    $this->title = $title;
    $this->lat = $lat;
    $this->lon = $lon;
    $this->address = $address;
    $this->city = $city;
  }
}
