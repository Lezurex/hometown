<?php

include_once __DIR__ . '/database/MariaDatabaseImpl.php';
include_once __DIR__ . '/database/repos/MariaMarkerRepo.php';


use Database\MariaDatabaseImpl;
use Database\Repos\MariaMarkerRepo;

$markerRepo = new MariaMarkerRepo(new MariaDatabaseImpl());

echo json_encode($markerRepo->getAllMarkers());
