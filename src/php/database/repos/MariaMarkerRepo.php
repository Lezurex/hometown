<?php

namespace Database\Repos;

use Database\Database;
use Database\DAOs\MarkerDAO;
use PDO;

class MariaMarkerRepo implements MarkerRepo
{

    private Database $database;

    public function __construct(Database $database)
    {
        self::$database = $database;
    }

    public function getAllMarkers(): array
    {
        $result = self::$database::getConnection()->query("SELECT * FROM marker;");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param MarkerDAO $marker
     */
    public function addMarker($marker)
    {
        assert($marker instanceof MarkerDAO, "Provided marker is not an instance of Marker!");
    }
}
