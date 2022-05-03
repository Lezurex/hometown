<?php

namespace Database\DTOs;

class CountryDTO
{
  public int $id;
  public string $name;

  public function __construct($id, $name)
  {
    $this->id = $id;
    $this->name = $name;
  }
}
