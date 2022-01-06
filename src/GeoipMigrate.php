<?php

class GeoipMigrate
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function migrateGeoIpToDataBase(array $geoips): void
    {
        $pdo = $this->database->getConnection();
        try {
            foreach ($geoips as $geoip) {
                $prepareStatement = $pdo->prepare("INSERT INTO geoip (ip_from, ip_to, country_code, country_name, region_name, city_name, latitude, longitude) 
            VALUE (?,?,?,?,?,?,?,?)");
                $prepareStatement->execute(array($geoip->getIpFrom(), $geoip->getIpTo(),
                    $geoip->getCountryCode(), $geoip->getCountryName(), $geoip->getRegionName(),
                    $geoip->getCityName(), $geoip->getLatitude(), $geoip->getLongitude()));
            }
        } catch (Exception $e) {
            ErrorUtils::SendCriticalError("An error occurred during the migration.");
        }
    }

}