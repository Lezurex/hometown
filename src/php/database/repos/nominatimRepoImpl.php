<?php
include_once 'nominatimRepo.php';

use Database\Repos\nominatimRepo;

class nominatimRepoImpl implements nominatimRepo
{
    public function getCoordinates($address, $zip_code, $country): array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://nominatim.openstreetmap.org/search.php?street=$address&country=$country&postalcode=$zip_code&format=jsonv2");
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
        curl_setopt($curl, CURLOPT_REFERER, "https://ap20b.lezurex.com/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $apiJSON = json_decode(curl_exec($curl), true);
        curl_close($curl);
        $lat = $apiJSON[0]['lat'];
        $lon = $apiJSON[0]['lon'];
        $cityId = 0;

        return [$lat, $lon, $cityId];
    }
}

