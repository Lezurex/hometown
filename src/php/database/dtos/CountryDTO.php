<?php

namespace Database\DTOs;

class CountryDTO
{
  public int $id;
  public string $name;

  public function __construct($id, $name)
  {
    self::$id = $id;
    self::$name = $name;
  }
}
