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
        if (count($apiJSON) == 0) {
            die('Not found!');
        }
        $osmType = strtoupper(substr($apiJSON[0]['osm_type'], 0, 1));
        $osmId = $apiJSON[0]['osm_id'];
        curl_setopt($curl, CURLOPT_URL, "https://nominatim.openstreetmap.org/details.php?osmtype=$osmType&osmid=$osmId&format=json&addressdetails=1");
        $apiJSON = json_decode(curl_exec($curl), true);
        curl_close($curl);
        $lat = $apiJSON['centroid']['coordinates'][0];
        $lon = $apiJSON['centroid']['coordinates'][1];
        $city = "";
        foreach ($apiJSON['address'] as $item) {
            if ($item['type'] == 'village' || $item['type'] == 'city') {
                $city = $item['localname'];
                break;
            }
        }
        $postalCode = '';
        foreach ($apiJSON['address'] as $item) {
            if ($item['type'] == 'postcode') {
                $postalCode = $item['localname'];
                break;
            }
        }
        $country = "";
        foreach ($apiJSON['address'] as $item) {
            if ($item['type'] == 'country') {
                $country = $item['localname'];
                break;
            }
        }

        return [$lat, $lon, $city, $postalCode, $country];
    }
}
