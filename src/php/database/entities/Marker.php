<?php

namespace Database\Entities;

class Marker
{
  public int $id;
  public string $title;
  public float $lat;
  public float $lon;
  public string $address;
  public int $cityId;
}
