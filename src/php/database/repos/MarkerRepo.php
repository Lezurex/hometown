<?php

namespace Database\Repos;

use Database\DTOs\MarkerDTO;

interface MarkerRepo
{
  public function getAllMarkers(): array;

  /**
   * @param MarkerDTO $marker
   */
  public function addMarker(MarkerDTO $marker);

  public function deleteMarker(MarkerDTO $marker);

  public function updateMaker(MarkerDTO $marker);

  public function markerExists(MarkerDTO $marker): bool;
}
