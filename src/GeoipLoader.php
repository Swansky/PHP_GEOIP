<?php

class GeoipLoader
{

    public function loadFromCSV(string $filePath, string $separator): array
    {
        $geoips = array();

        $row = 1;
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            try {
                while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
                    $geoip = new Geoip();
                    $num = count($data);
                    $row++;
                    for ($c = 0; $c < $num; $c++) {
                        $geoip->setParametersWithId($c, $data[$c]);
                    }
                    array_push($geoips, $geoip);
                }
            } catch (Exception $e) {
                ErrorUtils::SendCriticalError("An error occurred while parsing the file.");
            }
            fclose($handle);
        }
        return $geoips;
    }

}