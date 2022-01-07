<?php

class GeoipMigrate
{
    private Database $database;


    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    // first technic
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

    // SQL Method find by Yohann Duboeuf https://github.com/YohannDuboeuf/PHP_GEOIP
    public function migrateCSVFileToDataBase(Parameter $parameter)
    {
        try {
            $pdo = $this->database->getConnection();
            $prepareStatement = $pdo->prepare("LOAD DATA LOCAL INFILE ? INTO TABLE geoip FIELDS TERMINATED BY ? OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY ?");
            $prepareStatement->execute(array($parameter->getCsvPath(), $parameter->getSeparator(), $parameter->getEndCsv()));

        } catch (Exception $e) {
            ErrorUtils::SendCriticalError("Impossible to load csv file to mysql server: " . $e->getMessage());
        }
    }

}