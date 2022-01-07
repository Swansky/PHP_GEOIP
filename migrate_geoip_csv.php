<?php
declare(strict_types=1);
ini_set('memory_limit', '4096M');

require_once "src/ParametersManager.php";
require_once "src/Database.php";
require_once "src/Geoip.php";
require_once "src/GeoipLoader.php";
require_once "src/ErrorUtils.php";
require_once "src/GeoipMigrate.php";
require_once "src/Geolocalise.php";
require_once "src/Parameter.php";
$database = new Database();
$database->connect();
$geolocalise = new Geolocalise($database);
$geolocalise->geolocalisation();

$parametersManager = new ParametersManager();
$parametersManager->checkOptions();
$parameter = $parametersManager->getParameter();
$parameter->printAllParameter();

echo "\n\nStart db connexion...\n\n";

$connection = $database->getConnection();

$methodUsed = $parameter->getMethodUsed();
$totalStart = microtime(true);
if ($methodUsed == Parameter::$CLASSIC_METHOD) {
    echo "Start csv parsing...\n\n";
    $start = microtime(true);
    $geoipLoader = new GeoipLoader();
    $allGeoIp = $geoipLoader->loadFromCSV($parameter->getCsvPath(), $parameter->getSeparator());
    $time_elapsed_secs = microtime(true) - $start;
    echo sizeof($allGeoIp) . " elements have been parsed in " . $time_elapsed_secs . "s\n";

    echo "Start migrate to bdd...\n";
    $start = microtime(true);
    $geoipMigrate = new GeoipMigrate($database);
    $geoipMigrate->migrateGeoIpToDataBase($allGeoIp);
    $time_elapsed_secs = microtime(true) - $start;
} else if ($methodUsed == Parameter::$FAST_METHOD) {
    echo "Start migrate to bdd...\n";
    $geoipMigrate = new GeoipMigrate($database);
    $geoipMigrate->migrateCSVFileToDataBase($parameter);
}

$time_elapsed_secs = microtime(true) - $totalStart;
echo "\nTotal migration done in " . $time_elapsed_secs . "s  with " . $parameter->methodToString() . " method !";





