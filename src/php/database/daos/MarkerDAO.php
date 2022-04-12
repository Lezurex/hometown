<?php

namespace Database\DAOs;

class MarkerDAO
{
  public int $id;
  public string $title;
  public float $lat;
  public float $lon;
  public string $address;
  public int $cityId;
}
