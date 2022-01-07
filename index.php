<?php


$databasehost = "127.0.0.1";
$databasename = "tp-geoip";
$databasetable = "geoip";
$databaseusername = "root";
$databasepassword = "example";
$fieldseparator = ",";
$contentseparator = '"';
$lineseparator = "\n";
$csvfile = "geoip.csv";
$addauto = 0;
$save = 1;
const HOST = "127.0.0.1";
const DB_NAME = "tp-geoip";
const CHARSET = "utf8";
const USERNAME = "root";
const PASSWORD = "example";

if (!file_exists($csvfile)) {
    die("File not found. Make sure you specified the correct path.");
}
try {
    $pdo = new PDO('mysql:host=' . HOST .
        ';dbname=' . DB_NAME .
        ';charset=' . CHARSET,
        USERNAME,
        PASSWORD, array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL
        ));
} catch (PDOException $e) {
    die("database connection failed: " . $e->getMessage());
}
$start = microtime(true);
$affectedRows = $pdo->exec("
    LOAD DATA LOCAL INFILE " . $pdo->quote($csvfile) . " INTO TABLE `$databasetable`
      FIELDS TERMINATED BY " . $pdo->quote($fieldseparator) . "
      OPTIONALLY ENCLOSED BY '\"' " . "
      LINES TERMINATED BY " . $pdo->quote($lineseparator));

$time_elapsed_secs = microtime(true) - $start;
echo "\nMigration done in " . $time_elapsed_secs . "s !\n";
echo "Loaded a total of $affectedRows records from this csv file.\n";
