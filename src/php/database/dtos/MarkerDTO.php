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
    self::$id = $id;
    self::$title = $title;
    self::$lat = $lat;
    self::$lon = $lon;
    self::$address = $address;
    self::$city = $city;
  }
  
}
