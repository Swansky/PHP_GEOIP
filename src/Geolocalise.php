<?php


class Geolocalise
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function geolocalisation(): void
    {
        //$_SERVER['REMOTE_ADDR'] = "127.0.0.1"; // FOR LOCAL TEST WITH CLI USED
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $addr = $_SERVER['REMOTE_ADDR'];
            $addrSplit = explode(".", $addr);
            $computeAddr = ip2long($addr);
            $geoips = $this->findIp($computeAddr);
            foreach ($geoips as $geoip) {
                $geoip->printInformation();
            }
        }
    }

    private function findIp(int $computeAddr): array
    {
        $geoips = array();
        try {
            $pdo = $this->database->getConnection();
            $statement = $pdo->prepare("SELECT country_code,country_name,region_name,city_name,latitude,longitude FROM geoip WHERE ip_from=?");
            $statement->execute(array($computeAddr));
            $response = $statement->fetchAll();
            foreach ($response as $geoipFetch) {
                $geoip = new Geoip();
                $geoip->setCountryCode($geoipFetch["country_code"]);
                $geoip->setCountryName($geoipFetch["country_name"]);
                $geoip->setRegionName($geoipFetch["region_name"]);
                $geoip->setCityName($geoipFetch["city_name"]);
                $geoip->setLatitude($geoipFetch["latitude"]);
                $geoip->setLongitude($geoipFetch["longitude"]);
                array_push($geoips, $geoip);
            }
        } catch (Exception $e) {
            ErrorUtils::SendCriticalError("Impossible to find information for this ip: " . $e->getMessage());
        }

        return $geoips;
    }

}