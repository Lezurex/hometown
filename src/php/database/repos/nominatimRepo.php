<?php
namespace Database\Repos;

interface nominatimRepo
{
    public function getCoordinates($address, $zip_code, $country);

}