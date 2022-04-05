<?php

namespace Database\Repos;

use Database\Database;
use PDO;

class MariaMarkerRepo implements MarkerRepo
{

  public function getAllMarkers(): array
  {
    $result = Database::getConnection()->query("SELECT * FROM marker;");
    return $result->fetchAll(PDO::FETCH_ASSOC);
  }
}
