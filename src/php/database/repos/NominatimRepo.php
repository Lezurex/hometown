<?php

namespace Database\Repos;

interface NominatimRepo
{
    public function getCoordinates($address, $zip_code, $country);
}
