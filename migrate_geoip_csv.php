<?php
declare(strict_types=1);
ini_set('memory_limit', '-1');

require_once "src/ParametersManager.php";
require_once "src/Database.php";
require_once "src/Geoip.php";
require_once "src/GeoipLoader.php";
require_once "src/ErrorUtils.php";
require_once "src/GeoipMigrate.php";
require_once "src/Geolocalise.php";

$database = new Database();
$database->connect();
$geolocalise = new Geolocalise($database);
$geolocalise->geolocalisation();

$parametersManager = new ParametersManager();

$parametersManager->checkOptions();
$parametersManager->printAllParameter();


echo "\n\nStart db connexion...\n\n";

$connection = $database->getConnection();

echo "Start csv parsing...\n\n";
$start = microtime(true);
$geoipLoader = new GeoipLoader();
$allGeoIp = $geoipLoader->loadFromCSV($parametersManager->getFilePath(), $parametersManager->getSeparator());
$time_elapsed_secs = microtime(true) - $start;
echo sizeof($allGeoIp) . " elements have been parsed in " . $time_elapsed_secs . "s\n";


echo "Start migrate to bdd...\n";
$start = microtime(true);
$geoipMigrate = new GeoipMigrate($database);
$geoipMigrate->migrateGeoIpToDataBase($allGeoIp);
$time_elapsed_secs = microtime(true) - $start;
echo "\nMigration done in " . $time_elapsed_secs . "s !";

