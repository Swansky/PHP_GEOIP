<?php

class Geoip
{
    // Column id csv and database
    private const IP_FROM = 0;
    private const IP_TO = 1;
    private const COUNTRY_CODE = 2;
    private const COUNTRY_NAME = 3;
    private const REGION_NAME = 4;
    private const CITY_NAME = 5;
    private const LATITUDE = 6;
    private const LONGITUDE = 7;

    private int $ip_from;
    private int $ip_to;
    private string $country_code;
    private string $country_name;
    private string $region_name;
    private string $city_name;
    private float $latitude;
    private float $longitude;


    public function setParametersWithId(int $paramId, string $value): void
    {
        switch ($paramId) {
            case self::IP_FROM:

                $this->ip_from = intval($value);
                break;
            case self::IP_TO:
                $this->ip_to = intval($value);
                break;
            case self::COUNTRY_CODE:
                $this->country_code = $value;
                break;
            case self::COUNTRY_NAME:
                $this->country_name = $value;
                break;
            case self::REGION_NAME:
                $this->region_name = $value;
                break;
            case self::CITY_NAME:
                $this->city_name = $value;
                break;
            case self::LATITUDE:
                $this->latitude = floatval($value);
                break;
            case self::LONGITUDE:
                $this->longitude = floatval($value);
                break;
            default:
                ErrorUtils::SendCriticalError("non-existent parameter id: " . $paramId);
        }
    }

    public function printInformation(): void
    {
        echo "Coutry name: " . $this->country_name . "\n";
        echo "Coutry code: " . $this->country_code . "\n";
        echo "region name: " . $this->region_name . "\n";
        echo "city name: " . $this->city_name . "\n";
        echo "Latitude: " . $this->latitude . "\n";
        echo "Longitude: " . $this->longitude . "\n";
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->city_name;
    }

    /**
     * @return string
     */
    public function getRegionName(): string
    {
        return $this->region_name;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->country_name;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @return int
     */
    public function getIpTo(): int
    {
        return $this->ip_to;
    }

    /**
     * @return int
     */
    public function getIpFrom(): int
    {
        return $this->ip_from;
    }

    /**
     * @param int $ip_from
     */
    public function setIpFrom(int $ip_from): void
    {
        $this->ip_from = $ip_from;
    }

    /**
     * @param int $ip_to
     */
    public function setIpTo(int $ip_to): void
    {
        $this->ip_to = $ip_to;
    }

    /**
     * @param string $country_code
     */
    public function setCountryCode(string $country_code): void
    {
        $this->country_code = $country_code;
    }

    /**
     * @param string $country_name
     */
    public function setCountryName(string $country_name): void
    {
        $this->country_name = $country_name;
    }

    /**
     * @param string $region_name
     */
    public function setRegionName(string $region_name): void
    {
        $this->region_name = $region_name;
    }

    /**
     * @param string $city_name
     */
    public function setCityName(string $city_name): void
    {
        $this->city_name = $city_name;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }
}