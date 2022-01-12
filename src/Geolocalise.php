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
            $computeAddr = ip2long($addr);
            $geoip = $this->findIp($computeAddr);

            $geoip->printInformation();

        }
    }

    private function findIp(int $computeAddr): Geoip
    {
        try {
            $geoip = null;
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
            }
        } catch (Exception $e) {
            ErrorUtils::SendCriticalError("Impossible to find information for this ip: " . $e->getMessage());
        }
        return $geoip;
    }

}