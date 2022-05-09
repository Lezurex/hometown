<?php
include_once 'NominatimRepo.php';

use Database\Repos\NominatimRepo;

class NominatimRepoImpl implements NominatimRepo
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
        $city = $apiJSON[0]['address'][2]['localname'];
        $postalCode = $apiJSON[0]['address'][5]['localname'];
        $country = $apiJSON[0]['address'][6]['localname'];

        return [$lat, $lon, $city, $postalCode, $country];
    }
}
